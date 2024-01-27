<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\AssignmentClassification;
use App\Models\AssignmentItems;
use App\Models\Basic\Video_tutorial;
use App\Models\School\Manager;
use App\Models\School\Meetings\meetings;
use App\Models\SingleAssignment;
use App\Models\School\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SingleAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assignmentClassifications = AssignmentClassification::with([
            'assignmentItems.singleAssignments.assignedUsers.user'
        ])->get()->toArray();
//        return response()->json($assignmentClassifications);
        $current_school = Auth::guard('school')->user()->current_working_school_id;
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
        $single_assignment_id = request('single_assignment_id')?:1;

        $SingleAssignment = AssignmentItems::find($single_assignment_id)->toArray();
        $header_items_data = [];
        $header_items_data['المسمي الوظيفي'] =$SingleAssignment['job_title'];
        $header_items_data['الارتباط التنظيمي'] =$SingleAssignment['organizational_connection'];
        $header_items_data['الهدف'] =$SingleAssignment['assignment_goal'];
        $SingleAssignment['header_items_data'] =$header_items_data;

        $current_school = Auth::guard('school')->user()->current_working_school_id;
        $Managers = Manager::where('belong_school_id',$current_school)->get()->toArray();
        $school = School::find($current_school);
        return view('website.school.assignments.new_assginment',
            compact('SingleAssignment','Managers','school'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        $committe_team_id = $request->input('committe_team_id');
        $assignment_item_id = $request->input('assignment_item_id');

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
