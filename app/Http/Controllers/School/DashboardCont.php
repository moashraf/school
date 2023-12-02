<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Basic\Video_tutorial;
use App\Models\Branch\Slider;
use App\Models\School\Management\Edu_department;
use App\Models\School\Meetings\Committees_and_teams;
use App\Models\School\Management\Edu_department_office;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\School\Manager;
use App\Models\School\School;
use App\Models\School\Student\School_grade;
use App\Models\School\Student\Student;
use App\Models\School\Teacher\School_job;
use App\Models\School\Teacher\Teacher_speciality;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class DashboardCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function choose_school()
    {
        return view('website.school.choose_school');
    }


    public function choose_school_start_store(Request $request)
    {
        $messages = [
            'required' => 'الحقل :attribute مطلوب',
            'string'    => 'The :attribute must be text format',
            'file'    => 'The :attribute must be a file',
            'mimes' => 'Supported file format for :attribute are :mimes',
            'max'      => 'الحقل :attribute يحب ان لا يتجاوز :max',
            'min'      => 'الحقل :attribute يحب ان لا يكون اقل من :min حروف او ارقام',
            'unique' => 'رقم الجوال مسجل في لام بالفعل',
            'numeric' => 'الحقل :attribute يجب ان يكون رقما',
            'digits_between' => ':attribute يجب ان يكون بين :min و :max',
        ];


        $this->validate($request, [
            'type' => ['required', Rule::in(['1', '2'])], //first or second school roadmap
        ], $messages);

        $which_school = $request->input('type');
        $manager_id = Auth::guard('school')->id();

        $manager = Manager::find($manager_id);

        if ($which_school == 1) {
            // save the current working school in dashboard
            $manager->current_working_school_id = $manager->first_school_id;
        } else {
            // save the current working school in dashboard
            $manager->current_working_school_id = $manager->second_school_id;
        }

        $manager->save();

        return response()->json([
            "status" => true,
            "type" => "done",
            "msg" => "تم تسجيل المدرسة الحالية بنجاح",
            "url" => route('school_route.dashboard'),
        ]);
    }


    // change school from sidebar
    public function change_school_sidebar(Request $request)
    {
        $messages = [
            'required' => 'الحقل :attribute مطلوب',
            'string'    => 'The :attribute must be text format',
            'file'    => 'The :attribute must be a file',
            'mimes' => 'Supported file format for :attribute are :mimes',
            'max'      => 'الحقل :attribute يحب ان لا يتجاوز :max',
            'min'      => 'الحقل :attribute يحب ان لا يكون اقل من :min حروف او ارقام',
            'unique' => 'رقم الجوال مسجل في لام بالفعل',
            'numeric' => 'الحقل :attribute يجب ان يكون رقما',
            'digits_between' => ':attribute يجب ان يكون بين :min و :max',
        ];


        $this->validate($request, [
            'type' => ['required', Rule::in(['1', '2'])], //first or second school roadmap
        ], $messages);

        $which_school = $request->input('type');
        $manager_id = Auth::guard('school')->id();

        $manager = Manager::find($manager_id);

        if ($which_school == 1) {
            // save the current working school in dashboard
            $manager->current_working_school_id = $manager->first_school_id;
            $school_name = $manager->first_school->name;
        } else {
            // save the current working school in dashboard
            $manager->current_working_school_id = $manager->second_school_id;
            $school_name = $manager->second_school->name;
        }

        $manager->save();

        return response()->json([
            "status" => true,
            "type" => "done",
            "msg" => "الانتقال الي مدرسة " . $school_name,
        ]);
    }



    public function dashboard()
    {

        $current_school = Auth::guard('school')->user()->current_working_school_id;

        $school = School::find($current_school);

        Carbon::setLocale('ar');
        //Carbon::now()->translatedFormat('l j F Y H:i:s');
        $today_date_ar = Carbon::now()->translatedFormat('j F Y');

        https: //api.aladhan.com/v1/gToH/10-10-2002


        $client = new \GuzzleHttp\Client();
        $apiURL = 'http://api.aladhan.com/v1/gToH';
        $res = $client->request('GET', $apiURL, [
            'json' => [
                "date" => Carbon::now(),
            ],
        ]);

        $statusCode = $res->getStatusCode();
        $responseBody = json_decode($res->getBody(), true);
        $hijri_day = $responseBody['data']['hijri']['day'];
        $hijri_month = $responseBody['data']['hijri']['month']['ar'];
        $hijri_year = $responseBody['data']['hijri']['year'];
        $hijri_date = $hijri_day . " " . $hijri_month . " " . $hijri_year;


        $sliders = Slider::where('type', 1)->get();

        // video tutorial
        $video_tutorial = Video_tutorial::where('type', 2)->first();

        return view('website.school.dashboard', compact('current_school', 'school', 'today_date_ar', 'hijri_date', 'sliders', 'video_tutorial'));
    }

    public function new_meeting()
    {
        $current_school = Auth::guard('school')->user()->current_working_school_id;

        $school = School::find($current_school);


        $sliders = Slider::where('type', 1)->get();

        // video tutorial
        $video_tutorial = Video_tutorial::where('type', 2)->first();

        return view('website.school.new_meeting',
            compact('current_school', 'school', 'sliders', 'video_tutorial'));
    }

    public function Committees_and_teams_meetings()
    {


        $current_school = Auth::guard('school')->user()->current_working_school_id;

        $school = School::find($current_school);

        $Committees_and_teams = Committees_and_teams::where('school_id',$school->id)->get();
        dd($Committees_and_teams);
        Carbon::setLocale('ar');
        //Carbon::now()->translatedFormat('l j F Y H:i:s');
        $today_date_ar = Carbon::now()->translatedFormat('j F Y');

        https: //api.aladhan.com/v1/gToH/10-10-2002


        $client = new \GuzzleHttp\Client();
        $apiURL = 'http://api.aladhan.com/v1/gToH';
        $res = $client->request('GET', $apiURL, [
            'json' => [
                "date" => Carbon::now(),
            ],
        ]);

        $statusCode = $res->getStatusCode();
        $responseBody = json_decode($res->getBody(), true);
        $hijri_day = $responseBody['data']['hijri']['day'];
        $hijri_month = $responseBody['data']['hijri']['month']['ar'];
        $hijri_year = $responseBody['data']['hijri']['year'];
        $hijri_date = $hijri_day . " " . $hijri_month . " " . $hijri_year;




        return view('website.school.Committees_and_teams_meetings',
            compact('current_school', 'school', 'today_date_ar', 'hijri_date'));
    }
    public function new_meeting()
    {
         $current_school = Auth::guard('school')->user()->current_working_school_id;

        $school = School::find($current_school);


        $sliders = Slider::where('type', 1)->get();

        // video tutorial
        $video_tutorial = Video_tutorial::where('type', 2)->first();

        return view('website.school.new_meeting',
            compact('current_school', 'school', 'sliders', 'video_tutorial'));
    }





    //select the calendar data and funcation via ajax in creating
    public function calander_tasks_ajax($month, $year)
    {

        $current_school_id = Auth::guard('school')->user()->current_working_school_id;

        if (isset(request()->month) && isset(request()->year)) {
            $month = request()->month;
            $year = request()->year;
        } else {
            $dateComponents = getdate();
            $month = $dateComponents['mon'];
            $year = $dateComponents['year'];
        }

        $duration = prox_sett('timeslotduration');
        $cleanup = prox_sett('timeslotcleanup');
        $start = prox_sett('timeslotstart');
        $end = prox_sett('timeslotend');


        if (prox_sett('timeslotweekends') !== "null") {
            $weekends = unserialize(prox_sett('timeslotweekends'));
        } else {
            $weekends = array();
        }

        return build_calendar($month, $year, $current_school_id, $weekends);
    }


    public function manager_redirect()
    {
        $manager_id = Auth::guard('school')->id();

        $last_roadmap_access = Auth::guard('school')->user()->roadmap;
        /*
        1- choose school2- welcome, 3-general info sc1, 4- facilities sc1, 5- students sc1, 6- entsab sc1, 7- teachers sc1, 8- administrators sc1, 9- other info sc1, 10- general info sc2, 11- facilities sc2, 12- students sc2, 12- entsab sc2, 13- teachers sc2, 13- administrators sc2, 14- other info sc2
        */
        if ($last_roadmap_access == 1) {

            return "ASd";
        }
    }

    public function roadmap()
    {

        $last_roadmap_access = Auth::guard('school')->user()->roadmap;
        $shared_school = Auth::guard('school')->user()->shared_school;

        // school roadmap last access redireaction
        if ($shared_school == 1 && $last_roadmap_access == 19) {
            return redirect()->route('school_route.roadmap');
        } elseif ($shared_school == 2 && $last_roadmap_access > 10) {
            return redirect()->route('school_route.second_roadmap');
        }

        $roadmap = Auth::guard('school')->user()->roadmap;
        $departments = Edu_department::get();

        $first_school_id = Auth::guard('school')->user()->first_school_id;
        $first_school = School::find($first_school_id);
        $students = Student::where('school_id', $first_school_id)->get();
        $teachers = Manager::where('belong_school_id', $first_school_id)->where('type', 3)->get();
        $administrators = Manager::where('belong_school_id', $first_school_id)->where('type', 2)->get();

        $first_school_grades = School_grade::where('school_id', $first_school_id)->get();

        $teacher_specialities = Teacher_speciality::get();
        $school_jobs = School_job::get();

        $what_school_now = "first";


        return view('website.roadmap.roadmap', compact('roadmap', 'departments', 'first_school', 'students', 'teachers', 'administrators', 'first_school_grades', 'teacher_specialities', 'school_jobs', 'what_school_now'));
    }
}
