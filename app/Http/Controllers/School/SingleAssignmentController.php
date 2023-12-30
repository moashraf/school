<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\AssignmentClassification;
use Illuminate\Http\Request;

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
        ])->get();

        return response()->json($assignmentClassifications);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $SingleAssignment_id = request('SingleAssignment_id')?:1;

        $SingleAssignment = SingleAssignment::find($SingleAssignment_id);
        $Manager = Manager::find(1);

        return view('website.school.new_committee',
            compact('SingleAssignment','Manager'));


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
}
