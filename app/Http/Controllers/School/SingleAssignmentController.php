<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\AssignmentClassification;
use App\Models\AssignmentItems;
use App\Models\Basic\Video_tutorial;
use App\Models\School\Manager;
use App\Models\School\Meetings\Committees_and_teams;
use App\Models\School\Meetings\meetings;
use App\Models\SingleAssignment;
use App\Models\School\School;
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
        ])->get();
        $current_school = Auth::guard('school')->user()->current_working_school_id;

        foreach ($assignmentClassifications as $classification) {
            if ($classification->id == 4) {
                $committeesAndTeamsArray =$committes =$teams =[];
                $committes['name']= 'تكليف اللجان';
                $committes['id']= 0;
                $teams['name']= 'تكليف الفرق';
                $teams['id']= 0;
                // Fetch committees and teams where school_id is 5
                $committeesAndTeams = Committees_and_teams::where('school_id',$current_school )->get();
                foreach ($committeesAndTeams->toArray() as $key=>$committeesAndTeam) {

                    $committeesAndTeam['assignment_name'] =  $committeesAndTeam['title'];
                    $committeesAndTeam['assignment_start_date'] =  $committeesAndTeam['title'];
                    $committeesAndTeam['is_committe_or_team'] =  1;
                    if ($committeesAndTeam['classification']==1){
                        $committes['single_assignments'][] =$committeesAndTeam;
                    }else{
                        $teams['single_assignments'][] = $committeesAndTeam;
                    }
                }
                $committeesAndTeamsArray[]=$committes;
                $committeesAndTeamsArray[]=$teams;

                    // Assign it to the assignment_items of the classification
                $classification->setRelation('assignmentItems', collect($committeesAndTeamsArray));
            }
        }

        $assignmentClassifications = $assignmentClassifications->toArray();


//        return response()->json($assignmentClassifications);
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
        if (!empty($assignment_item_id)){
            $AssignmentItem = AssignmentItems::find($assignment_item_id)->toArray();
            $header_items_data = [];
            $header_items_data['المسمي الوظيفي'] =$AssignmentItem['job_title'];
            $header_items_data['الارتباط التنظيمي'] =$AssignmentItem['organizational_connection'];
            $header_items_data['الهدف'] =$AssignmentItem['assignment_goal'];
            $AssignmentItem['header_items_data'] =$header_items_data;
        }


        $current_school = Auth::guard('school')->user()->current_working_school_id;
        $Managers = Manager::where('belong_school_id',$current_school)->get()->toArray();
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
     */
    public function store(Request $request) : \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'assignment_name' => 'required',
            'assignment_item_id' => 'required',
        ]);
        $assignment_name = $request->input('assignment_name');
        $assignment_start_date = $request->input('assignment_start_date');
        $assignment_start_date = new DateTime($assignment_start_date);
        $assignment_start_date = $assignment_start_date->format('Y-m-d H:i:s'); // Format for SQL timestamp
        $assignment_duration = $request->input('assignment_duration');
        $assignment_specialization = $request->input('assignment_specialization');
        $assignment_goal = $request->input('assignment_goal');
        $is_committe_or_team = $request->input('is_committe_or_team');
        $committe_team_id = $request->input('committe_team_id',0);
        $assignment_item_id = $request->input('assignment_item_id');
//dd([$assignment_name,$assignment_start_date,$assignment_duration,$assignment_specialization,$assignment_goal,$is_committe_or_team,$assignment_item_id]);
        $form_SingleAssignment = SingleAssignment::create([

            'assignment_name' =>  $assignment_name,
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



        $AssignmentUsers = AssignmentUsers::create([

            'single_assignment_id' =>  $form_SingleAssignment->id,
            'user_id' =>  $assignment_start_date,

        ]);
        return redirect()->route('school_route.Committees_and_teams_meetings.index')->with('success', 'لقد تم حفظ الاجتماع بنجاح');

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
