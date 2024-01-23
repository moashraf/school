<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\CommitteTeamTasks;
use App\Models\School\Meetings\Committees_and_teams;
use Illuminate\Http\Request;

class CommitteTeamTasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $committeesAndTeams = Committees_and_teams::all();

//        return view('', compact('committeesAndTeams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'committe_team_id' => 'required|exists:committees_and_teams,id',
            'task_description' => 'required',
        ]);


        $committeTeamTask = new CommitteTeamTasks([
            'committe_team_id' => $request->input('committe_team_id'),
            'task_description' => $request->input('task_description'),
        ]);


        $committeTeamTask->save();

//        return redirect()->route('committe_team_tasks.index')->with('success', 'Task created successfully');
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
