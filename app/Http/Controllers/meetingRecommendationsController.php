<?php

namespace App\Http\Controllers;
use App\Models\School\Meetings\meeting_recommendations;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MeetingRecommendationsController extends Controller
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'meeting_id' => 'required',
        ]);

        $form = meeting_recommendations::create([
            'meeting_id'=>$request->input('meeting_id'),
            'Item'=>$request->input('Item'),
            'status'=>$request->input('status'),
            'reason'=>$request->input('reason'),

        ]);

        return redirect()->back()->with('success', 'Your form has been sent successfully');
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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'meeting_id' => 'required',
        ]);
        $meeting_recommendations = meeting_recommendations::find($id);
        $meeting_recommendations->meeting_id = $request->input('meeting_id');
        $meeting_recommendations->Item = $request->input('Item');
        $meeting_recommendations->status = $request->input('status');
        $meeting_recommendations->reason = $request->input('reason');
        $meeting_recommendations->save();
        return redirect()->back()->with('success', 'Your form has been sent successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $meeting_recommendations = meeting_recommendations::find($id);

        if ($meeting_recommendations) {
            $meeting_recommendations->delete();
            return redirect()->back()->with('success', 'Record has been deleted successfully');
        }

        return redirect()->back()->with('error', 'Record not found');
    }
}
