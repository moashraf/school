<?php

namespace App\Http\Controllers;

use App\Models\Basic\Video_tutorial;
use App\Models\Branch\Slider;
use App\Models\School\Meetings\meeting_agenda;
use App\Models\School\Meetings\meeting_recommendations;
use App\Models\School\Meetings\meetings;
use App\Models\School\Meetings\Committees_and_teams;
use App\Models\School\School;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Mpdf\Mpdf;
use PDF;
use DOMPDF;
// Assuming you have the Dompdf alias set up


class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():void
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $current_school = Auth::guard('school')->user()->current_working_school_id;

        $school = School::find($current_school);
        $item_val = [
            'committees_and_teams_id' => null,
            'Number_of_attendees' => null,
            'created_at' => null,
            'Target_group' => null,
            'deleted_at' => null,
            'Semester' => null,
            'status' => 0,
            'location' => null,
            'stage' => null,
            'start_date' => null,
            'start_time' => null,
            'type' => null,
            'id' => null,
            'updated_at' => null,
            'end_date' => null,
            'end_time' => null,
            'title' => null,
            'meeting_agenda' => [],
            'meeting_recommendations' => []
        ];

        $Committee_id = request('Committees_id');
        $Committees_and_teams_model = new Committees_and_teams;
        $Committees_and_teams = $Committees_and_teams_model ->findOrFail((int)$Committee_id);
        $sliders = Slider::where('type', 1)->get();

        // video tutorial
        $video_tutorial = Video_tutorial::where('type', 2)->first();

        return view('website.school.meetings.create_edit',
            compact('current_school', 'school', 'Committees_and_teams','sliders','item_val', 'video_tutorial'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     * @throws \Exception
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {

        $this->validate($request, [
            'committees_and_teams_id' => 'required',
         ]);
        $startDate = $request->input('start_date'); // e.g., '2023-12-04'
        $startTime = $request->input('start_time'); // e.g., '22:29:29'
        $startDateTimeString = $startDate . ' ' . $startTime; // e.g., '2023-12-04 22:29:29'
        $startDateTime = new DateTime($startDateTimeString);
        $formattedStartDateTime = $startDateTime->format('Y-m-d H:i:s'); // Format for SQL timestamp
        $endDateTimeString = $startDate . ' ' . $request->input('end_time'); // e.g., '2023-12-04 22:29:29'
        $endDateTime = new DateTime($endDateTimeString);
        $formattedEndDateTime = $endDateTime->format('Y-m-d H:i:s'); // Format for SQL timestamp
        $status=$request->input('status');

        if(  $request->input('recommendation_item')  !==  null  &&  $request->input('meeting_agenda_item')  !==  null  &&
            ($request->input('recommendation_item')[0] ==null ||    $request->input('meeting_agenda_item')[0] ==null) )
          {   $status=0;   }
        else{
            $status=1;
        }
        $form = meetings::create([
            'committees_and_teams_id'=>$request->input('committees_and_teams_id'),
            'Number_of_attendees' => (int) $request->input('Number_of_attendees'),
            'title' => $request->input('title'),
            'Target_group' => $request->input('Target_group'),
            'status' =>  $status,
            'location' => $request->input('location'),
            'start_date' => $formattedStartDateTime,
            'type' => $request->input('type'),
            'end_time' => $formattedEndDateTime,
            'Semester' => $request->input('Semester'),
        ]);
        if ($request->input('recommendation_item') !=null) {
        foreach ($request->input('recommendation_item') as $index=>$item) {
            if ($item){
                $meetingRecommendation = new meeting_recommendations;
                $meetingRecommendation->meeting_id = $form->id;
                $meetingRecommendation->item = $item; // item from the array
                $meetingRecommendation->Implementation_period = $request->input('Implementation_period')[$index];
                $meetingRecommendation->entity_responsible_implementation = $request->input('entity_responsible_implementation')[$index];
                $meetingRecommendation->entity_responsible_implementation_related = $request->input('entity_responsible_implementation_related')[$index];
                $meetingRecommendation->status =1;
                $meetingRecommendation->save();
            }
        }
        }
        if ($request->input('meeting_recommendations_not_completed') !=null) {

            foreach ($request->input('meeting_recommendations_not_completed') as $index => $item) {
                if ($item) {
                    $meetingRecommendation = new meeting_recommendations;
                    $meetingRecommendation->meeting_id = $form->id;
                    $meetingRecommendation->Item = $item; // item from the array
                    $meetingRecommendation->status = 0;
                    $meetingRecommendation->save();
                }
            }
        }

        if ($request->input('meeting_agenda_item') !=null) {

            foreach ($request->input('meeting_agenda_item') as $item) {
                if ($item) {
                    $meeting_agenda = new meeting_agenda;
                    $meeting_agenda->meeting_id = $form->id;
                    $meeting_agenda->item = $item; // item from the array
                    $meeting_agenda->save();
                }

            }
        }
        return redirect()->route('school_route.Committees_and_teams_meetings.index')->with('success', 'لقد تم حفظ الاجتماع بنجاح');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
//        $current_school = Auth::guard('school')->user()->current_working_school_id;
//
//        $school = School::find($current_school);
//
//
//        $sliders = Slider::where('type', 1)->get();
//        $item_val = meetings::with(['meeting_agenda', 'meeting_recommendations'])
//            ->where('id', $id)
//            ->first();
//        // video tutorial
//        $Committee_id =$item_val->committees_and_teams_id;
//        $Committees_and_teams_model = new Committees_and_teams;
//        $Committees_and_teams = $Committees_and_teams_model->findOrFail($Committee_id);
//        $video_tutorial = Video_tutorial::where('type', 2)->first();
//        if ($item_val->start_date){
//            $dateTime = new DateTime($item_val->start_date);
//            $item_val->start_date = $dateTime->format('Y-m-d');
//            $item_val->start_time = $dateTime->format('H:i:s');
//        }
//        if ($item_val->end_time){
//            $Time = new DateTime($item_val->end_time);
//            $item_val->end_time = $Time->format('H:i:s');
//        }
//        $item_val = $item_val->toArray();
//        return view('website.school.meetings.show',
//            compact('current_school', 'school','Committees_and_teams','item_val', 'sliders', 'video_tutorial'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $current_school = Auth::guard('school')->user()->current_working_school_id;

        $school = School::find($current_school);


        $sliders = Slider::where('type', 1)->get();
        $item_val = meetings::with(['meeting_agenda', 'meeting_recommendations'])
            ->where('id', $id)
            ->first();
        // video tutorial
        $Committee_id =$item_val->committees_and_teams_id;
        $Committees_and_teams_model = new Committees_and_teams;
        $Committees_and_teams = $Committees_and_teams_model->findOrFail($Committee_id);
        $video_tutorial = Video_tutorial::where('type', 2)->first();
        $item_val = $this->updateDateValues($item_val);
        return view('website.school.meetings.create_edit',
            compact('current_school', 'school','Committees_and_teams','item_val', 'sliders', 'video_tutorial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'meeting_id' => 'required',
        ]);
        $this->updatebyid($id, $request);
        $meeting_id = $request->input('meeting_id');

// Delete existing meeting recommendations
        meeting_recommendations::where('meeting_id', $meeting_id)->delete();
// Delete existing meeting agendas
        meeting_agenda::where('meeting_id', $meeting_id)->delete();
        if ($request->input('recommendation_item') !=null) {
            foreach ($request->input('recommendation_item') as $index => $item) {
                if ($item) {
                    $meetingRecommendation = new meeting_recommendations;
                    $meetingRecommendation->meeting_id = $meeting_id;
                    $meetingRecommendation->status = 1;
                    $meetingRecommendation->item = $item; // item from the array
                    $meetingRecommendation->Implementation_period = $request->input('Implementation_period')[$index];
                    $meetingRecommendation->entity_responsible_implementation = $request->input('entity_responsible_implementation')[$index];
                    $meetingRecommendation->entity_responsible_implementation_related = $request->input('entity_responsible_implementation_related')[$index];
                    $meetingRecommendation->save();
                }
            }
        }

        if ($request->input('meeting_recommendations_not_completed') !=null) {
            foreach ($request->input('meeting_recommendations_not_completed') as $index => $item) {
                if ($item) {
                    $meetingRecommendation = new meeting_recommendations;
                    $meetingRecommendation->meeting_id = $meeting_id;
                    $meetingRecommendation->status = 0;
                    $meetingRecommendation->item = $item; // item from the array
                    $meetingRecommendation->save();
                }
            }
        }

        if ($request->input('meeting_agenda_item') !=null) {
            foreach ($request->input('meeting_agenda_item') as $index => $item) {
                if ($item) {
                    $meeting_agenda = new meeting_agenda;
                    $meeting_agenda->item = $item; // item from the array
                    $meeting_agenda->meeting_id = $meeting_id;
                    $meeting_agenda->save();
                }

            }
        }
        return redirect()->back()->with('success', 'تم تعديل الاجتماع بنجاح');
    }


    public function downloadPDF($id)
    {
        try {
            $item_val = meetings::with(['meeting_agenda', 'meeting_recommendations'])
                ->where('id', $id)
                ->firstOrFail();  // Use firstOrFail to automatically handle the case where $id is not found

            $Committee_id = $item_val->committees_and_teams_id;
            $Committees_and_teams_model = new Committees_and_teams;
            $Committees_and_teams = $Committees_and_teams_model->findOrFail($Committee_id); // This already throws an exception if not found
            $Committees_and_teams = $Committees_and_teams->toArray();

            $item_val = $this->updateDateValues($item_val);

            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'tempDir' => sys_get_temp_dir() // Optional: Specify a temp directory
            ]);
            $mpdf->debug = true; // Keep this for debugging, but remove or set to false in production

            // Load your view and pass the data
            $html = View('website.school.meetings.print_pdf', [
                'item_val' => $item_val,
                'Committees_and_teams' => $Committees_and_teams
            ])->render();

            // Write HTML to the PDF
            $mpdf->WriteHTML($html);

            // Output the PDF as a download
            return $mpdf->Output('meeting-details.pdf', \Mpdf\Output\Destination::DOWNLOAD);
        } catch (\Exception $e) {
            // Handle the exception, log it, or provide a user-friendly message
            // This is a basic example, adjust error handling as needed for your application
            return "An error occurred while generating the PDF: " . $e->getMessage();
        }
    }

/**
      Remove the specified resource from storage.

      @param int $id
      @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id,Request $request)
    {
        $meeting_id = $request->input('meeting_id');
        if ($meeting_id){
            $id =$meeting_id;
        }

        $meeting = meetings::findOrFail($id);
        if ($meeting) {
            $meeting->delete();
            return redirect()->back()->with('success', 'لقد تم حذف الاجتماع بتجاح');
        }
        return redirect()->back()->with('error', 'عذرا نواجه مشكله في حذف هذا الاجتماع');
    }


    /**
     * @param int $id
     * @param Request $request
     * @return void
     * @throws \Exception
     */
    public function updatebyid(int $id, Request $request): void
    {
        $startDate = $request->input('start_date'); // e.g., '2023-12-04'
        $startTime = $request->input('start_time'); // e.g., '22:29:29'
        $startDateTimeString = $startDate . ' ' . $startTime; // e.g., '2023-12-04 22:29:29'
        $startDateTime = new DateTime($startDateTimeString);
        $formattedStartDateTime = $startDateTime->format('Y-m-d H:i:s'); // Format for SQL timestamp
        $endDateTimeString = $startDate . ' ' .$request->input('end_time') ; // e.g., '2023-12-04 22:29:29'
        $endDateTime = new DateTime($endDateTimeString);
        $formattedEndDateTime = $endDateTime->format('Y-m-d H:i:s'); // Format for SQL timestamp

        $meetings = meetings::find($id);
        $meetings->committees_and_teams_id = $request->input('committees_and_teams_id');
        $meetings->number_of_attendees = (int) $request->input('Number_of_attendees');
        $meetings->Target_group = $request->input('Target_group');
        $meetings->title = $request->input('title');
        $meetings->status = $request->input('status');
        $meetings->location = $request->input('location');
        $meetings->start_date = $formattedStartDateTime;
        $meetings->type = $request->input('type');
        $meetings->Semester = $request->input('Semester');
        $meetings->end_time = $formattedEndDateTime;
        $meetings->save();
    }
    public function printPdf($id)
    {



        $item_val = meetings::with(['meeting_agenda', 'meeting_recommendations'])
            ->where('id', $id)
            ->first();
        // video tutorial
        $Committee_id =$item_val->committees_and_teams_id;
        $Committees_and_teams_model = new Committees_and_teams;
        $Committees_and_teams = $Committees_and_teams_model->findOrFail($Committee_id);
        if ($item_val->start_date==="0000-00-00 00:00:00"){
            $item_val->start_date = null;
        }
        $item_val = $this->updateDateValues($item_val);
        return view('website.school.meetings.print_pdf',compact('Committees_and_teams','item_val'));

    }

    /**
     * @param $item_val
     * @return mixed
     * @throws \Exception
     */
    public function updateDateValues($item_val)
    {
        if ($item_val->start_date) {
            $dateTime = new DateTime($item_val->start_date);
            $item_val->start_date = $dateTime->format('Y-m-d');
            $item_val->start_time = $dateTime->format('H:i:s');
        }
        if ($item_val->end_time) {
            $Time = new DateTime($item_val->end_time);
            $item_val->end_time = $Time->format('H:i:s');
        }
        return $item_val->toArray();
    }

}
