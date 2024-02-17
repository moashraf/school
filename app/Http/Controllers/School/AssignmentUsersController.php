<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\AssignmentUsers;
use Illuminate\Http\Request;

class AssignmentUsersController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy(Request $request,$id)
    {
        $assignmentUserId = $request->input('assignment-user-id');
        if ($assignmentUserId){
           $assignmentUser = AssignmentUsers::findOrFail($assignmentUserId);
           if ($assignmentUser){
               $assignmentUser->delete();
               return redirect()->back()->with('success', 'لقد تم الحذف بتجاح');
           }
        }

        return redirect()->back()->with('error', 'عذرا نواجه مشكله في حذف هذا ');
    }
    public function deleteUser(Request $request)
    {
        // Retrieve the assignment user ID from the request
        $assignmentUserId = $request->input('assignment-user-id');
        // Use Eloquent to find the assignment user record by ID
        $assignmentUser = AssignmentUsers::find($assignmentUserId);

        if (!$assignmentUser) {
            // Handle case where assignment user is not found
            return redirect()->back()->with('error', 'Assignment user not found.');
        }

        // Delete the assignment user record
        $assignmentUser->delete();

        // Redirect the user to a relevant page after deletion
        return redirect()->back()->with('success', 'Assignment user deleted successfully.');
    }
}
