<?php

namespace App\Http\Controllers;

use App\Models\School\Meetings\meeting_agenda;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MeetingAgendaController extends Controller
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'meeting_id' => 'required',
            'Item' => 'required',
        ]);

        $form = meeting_agenda::create([
            'meeting_id'=>$request->input('meeting_id'),
            'Item'=>$request->input('Item'),
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
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'meeting_id' => 'required',
            'item' => 'required',
        ]);
        $meeting_agenda = meeting_agenda::find($id);
        $meeting_agenda->meeting_id = $request->input('meeting_id');
        $meeting_agenda->Item = $request->input('Item');
        $meeting_agenda->save();
        return redirect()->back()->with('success', 'Your form has been sent successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $meeting_agenda = meeting_agenda::find($id);

        if ($meeting_agenda) {
            $meeting_agenda->delete();
            return redirect()->back()->with('success', 'Record has been deleted successfully');
        }

        return redirect()->back()->with('error', 'Record not found');
    }
}
