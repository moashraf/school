<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\AssignmentClassification;
use App\Models\AssignmentItems;
use App\Models\AssignmentUsers;
use App\Models\Basic\Video_tutorial;
use App\Models\School\Manager;
use App\Models\School\Meetings\Committees_and_teams;
use App\Models\School\Meetings\meetings;
use App\Models\SingleAssignment;
use App\Models\School\School;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SingleAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $assignmentClassifications = AssignmentClassification::with([
            'assignmentItems.singleAssignments.assignedUsers.user'
        ])->get()->toArray();
        $current_school = Auth::guard('school')->user()->current_working_school_id;
        foreach ($assignmentClassifications as &$classification) {
            if ($classification['id'] == 4) {
                $committees = Committees_and_teams::where('school_id',$current_school )->where('classification',1)->get();
                $teams = Committees_and_teams::where('school_id',$current_school )->where('classification',2)->get();
                if ($classification['assignment_items']){

                    foreach ($classification['assignment_items'] as &$assignment_item){
                    if ($assignment_item['name']==='تكليف اللجان'){
                        $assignment_item['single_assignments'] = $committees->toArray();
                    }
                    if ($assignment_item['name']==='تكليف الفرق'){
                        $assignment_item['single_assignments'] = $teams->toArray();
                    }
                    }
                }
            }
        }



    // return response()->json($assignmentClassifications);
        $school = School::find($current_school);
        $video_tutorial = Video_tutorial::where('type', 2)->first();
        return view('website.school.assignments.assignment_data',
            compact('school','video_tutorial','assignmentClassifications'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $assignment_item_id = request('assignment_item_id');
        $AssignmentItem = [];
        $current_school = Auth::guard('school')->user()->current_working_school_id;
        if (!empty($assignment_item_id)){
            $AssignmentItem = AssignmentItems::find($assignment_item_id)->toArray();
            if ($AssignmentItem['classification_id']===2){//teachers
                $Managers = Manager::where('belong_school_id',$current_school)->where('type',3)->get()->toArray();
            }else{
                $Managers = Manager::where('belong_school_id',$current_school)->get()->toArray();
            }
            $header_items_data = [];
            $header_items_data['المسمي الوظيفي'] =$AssignmentItem['job_title'];
            $header_items_data['الارتباط التنظيمي'] =$AssignmentItem['organizational_connection'];
            $header_items_data['الهدف'] =$AssignmentItem['assignment_goal'];
            $AssignmentItem['header_items_data'] =$header_items_data;
        }



        $school = School::find($current_school);
        return view('website.school.assignments.new_assginment',
            compact('AssignmentItem','Managers','school'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     * @throws \Exception
     */
    public function store(Request $request) : \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'assignment_users' => 'required',
            'assignment_item_id' => 'required',
        ]);
        $assignment_users = $request->input('assignment_users');
        $assignment_start_date = $request->input('assignment_start_date');
        $assignment_start_date = new DateTime($assignment_start_date);
        $assignment_start_date = $assignment_start_date->format('Y-m-d H:i:s'); // Format for SQL timestamp
        $assignment_duration = $request->input('assignment_duration');
        $assignment_specialization = $request->input('assignment_specialization');
        $assignment_goal = $request->input('assignment_goal');//بشان
        $is_committe_or_team = $request->input('is_committe_or_team');
        $committe_team_id = $request->input('committe_team_id',0);
        $assignment_item_id = $request->input('assignment_item_id');
//dd([$assignment_users,$assignment_start_date,$assignment_duration,$assignment_specialization,$assignment_goal,$is_committe_or_team,$assignment_item_id]);
        $form_SingleAssignment = SingleAssignment::create([
             'assignment_start_date' =>  $assignment_start_date,
            'assignment_duration' =>  $assignment_duration,
            'assignment_specialization' =>  $assignment_specialization,
            'assignment_goal' =>  $assignment_goal,
            'is_committe_or_team' =>  $is_committe_or_team,
            'assignment_item_id' =>  $assignment_item_id,
         ]);
        if ($is_committe_or_team){
            $this->addMeetings($form_SingleAssignment->id,$committe_team_id,$request);
        }


// Prepare an array to hold all the records to be inserted
        $assignmentUsersData = [];

        foreach ($assignment_users as $assignment_user) {
            $assignmentUsersData[] = [
                'single_assignment_id' => $form_SingleAssignment->id,
                'user_id' => $assignment_user,
            ];
        }

// Insert all records in one query
        AssignmentUsers::insert($assignmentUsersData);

        return redirect()->route('school_route.single_assignment.index')->with('success', 'لقد تم حفظ الاجتماع بنجاح');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function create_single_assignment_committe_team(){
        $committe_team_id = request('committe_team_id');
       // $Committees_and_teams = [];
        $current_school = Auth::guard('school')->user()->current_working_school_id;
        $school = School::find($current_school);

        if (!empty($committe_team_id)){
            $Committees_and_teams = Committees_and_teams::where('school_id',$current_school )->where('id',$committe_team_id)->first();
           //  $Committees_and_teams = Committees_and_teams::find($committe_team_id)->toArray();
$member=0;
//            if ($AssignmentItem['classification_id']===2){//teachers
//                $Managers = Manager::where('belong_school_id',$current_school)->where('type',3)->get()->toArray();
//            }else{
//                $Managers = Manager::where('belong_school_id',$current_school)->get()->toArray();
//            }

        }



        return view('website.school.assignments.create_single_assignment_committe_team',
            compact('Committees_and_teams','member','school'));


    }
    public function addMeetings($committeId, $semester, $request)
    {
        if ($request->input('meetings') !=null) {
            foreach ($request->input('meetings') as $index=>$item) {
                if ($item){
                    $startDate = $request->input('start_date')[$index]; // e.g., '2023-12-04'
                    $startTime = $request->input('start_time')[$index]; // e.g., '22:29:29'
                    $startDateTimeString = $startDate . ' ' . $startTime; // e.g., '2023-12-04 22:29:29'
                    $startDateTime = new DateTime($startDateTimeString);
                    $formattedStartDateTime = $startDateTime->format('Y-m-d H:i:s'); // Format for SQL timestamp
                    $meeting = new meetings();
                    $meeting->committees_and_teams_id = $committeId;
                    $meeting->status =0;
                    $meeting->start_date = $formattedStartDateTime;
                    $meeting->location = $request->input('location')[$index];
                    $meeting->Semester =$semester;
                    $meeting->save();
                }
            }
        }

    }
}
