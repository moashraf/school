<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Imports\Student_sheetImport;
use App\Imports\StudentImport;
use App\Imports\Teacher_sheetImport;
use App\Models\Basic\Video_tutorial;
use App\Models\Branch\Visa;
use App\Models\Cat\Article\Article;
use App\Models\Patient\Destination;
use App\Models\School\Management\Edu_department;
use App\Models\School\Management\Edu_department_office;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use App\Models\School\Manager;
use App\Models\School\School;
use App\Models\School\Student\School_grade;
use App\Models\School\Student\School_grade_class;
use App\Models\School\Student\Student;
use App\Models\School\Teacher\School_job;
use App\Models\School\Teacher\Teacher_speciality;
use Maatwebsite\Excel\Facades\Excel;

class RoadmapCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {

        //get the last 5 article
        $articles = Article::skip(0)->take(4)->get();

        return view('website.homepage.index', compact('main_slider', 'weekly_slider', 'top_destination',  'random_destination_units', 'best_package', 'best_unit_first', 'best_unit_second', 'trip', 'visa', 'full_package', 'articles'));
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
         if ($last_roadmap_access == 19) {
            return redirect()->route('school_route.dashboard');
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

        $video_tutorial = Video_tutorial::where('type', 1)->first();

        return view('website.roadmap.roadmap', compact('roadmap', 'departments', 'first_school', 'students', 'teachers', 'administrators', 'first_school_grades', 'teacher_specialities', 'school_jobs', 'what_school_now', 'video_tutorial'));
    }

    // second roadmap
    public function second_roadmap()
    {

        $last_roadmap_access = Auth::guard('school')->user()->roadmap;
        $shared_school = Auth::guard('school')->user()->shared_school;

        if ($shared_school == 1 &&  $last_roadmap_access < 10) {
            return redirect()->route("school_route.roadmap");
        } elseif ($last_roadmap_access == 19) {
            return redirect()->route('school_route.dashboard');
        } elseif ($shared_school == 2 &&  $last_roadmap_access < 10) {
            return redirect()->route("school_route.roadmap");
        }

        $roadmap = Auth::guard('school')->user()->roadmap;
        $departments = Edu_department::get();

        $second_school_id = Auth::guard('school')->user()->second_school_id;
        $second_school = School::find($second_school_id);
        $students = Student::where('school_id', $second_school_id)->get();
        $teachers = Manager::where('belong_school_id', $second_school_id)->where('type', 3)->get();
        $administrators = Manager::where('belong_school_id', $second_school_id)->where('type', 2)->get();

        $second_school_grades = School_grade::where('school_id', $second_school_id)->get();

        $teacher_specialities = Teacher_speciality::get();
        $school_jobs = School_job::get();

        $what_school_now = "second";

        $video_tutorial = Video_tutorial::where('type', 1)->first();

        return view('website.roadmap.roadmap_second', compact('roadmap', 'departments', 'second_school', 'students', 'teachers', 'administrators', 'second_school_grades', 'teacher_specialities', 'school_jobs', 'what_school_now', 'video_tutorial'));
    }


    public function choose_school_store(Request $request)
    {
        $messages = [
            'required' => 'الحقل :attribute مطلوب',
            'string'    => 'The :attribute must be text format',
            'file'    => 'The :attribute must be a file',
            'mimes' => 'Supported file format for :attribute are :mimes',
            'max'      => 'الحقل :attribute يحب ان لا يتجاوز :max',
            'unique' => 'رقم الجوال مسجل في لام بالفعل',
            'numeric' => 'الحقل :attribute يجب ان يكون رقما',
            'digits_between' => ':attribute يجب ان يكون بين :min و :max',
        ];

        $this->validate($request, [
            'type' => 'required', Rule::in(['1', '2']),
        ]);

        $type = $request->input('type');

        $manager_id = Auth::guard('school')->id();
        $last_roadmap_access = Auth::guard('school')->user()->roadmap;
        $manager = Manager::find($manager_id);
        $manager->roadmap = 3;
        $manager->shared_school = $type;
        $manager->save();

        return response()->json([
            "status" => true,
            "msg" => "هيا بنا لبندء الرحلة سويا",
        ]);
    }


    // -------------- 3- general info --------------
    public function fetch_department_office($id)
    {
        return Edu_department_office::where('edu_department_id', $id)->get();
    }
    public function roadmap_general_info_store(Request $request)
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
            'school' => ['required', Rule::in(['fr1ksa', 'sec12saksa'])], //first or second school roadmap
            'school_gendar' => ['required', Rule::in(['1', '2'])],
            'school_level' => ['required', Rule::in(['1', '2', '3'])],
            'school_name' => ['required', 'min:2', 'max:100'],
            'ministerial_number' => ['required', 'min:4', 'max:40'],
            'school_type' => ['required', Rule::in(['1', '2'])],
            'school_department' => ['required', 'exists:edu_departments,id'],
            'school_department_office' => ['required', 'exists:edu_department_offices,id'],
            'established_date' => ['required', 'date', 'date_format:Y-m-d'],
            'school_period' => ['required', Rule::in(['1', '2', '3'])],
            'address' => ['required', 'min:5', 'max:255'],
        ], $messages);

        $first_second_roadmap = $request->input('school');

        $manager_id = Auth::guard('school')->id();
        $last_roadmap_access = Auth::guard('school')->user()->roadmap;

        $manager = Manager::find($manager_id);

        //validation
        if (in_array($last_roadmap_access, [1, 2])) {
            return response()->json([
                "status" => false,
                "msg" => "لم يتم اختيار نوع المدرسة بعد (0000014)",
            ]);
        } elseif ($first_second_roadmap === "sec12saksa" && $manager->shared_school == 1) {
            return response()->json([
                "status" => false,
                "msg" => "(0000015) تم الذهاب الي الرحلة الثانية برغم اختيار مدرسة غير مشتركة ",
            ]);
        } elseif (count($manager->schools) > 2 && $manager->second_school_id !== null) {
            return response()->json([
                "status" => false,
                "msg" => "(0000016) هناك اكثر من مدرستين تم تسجيلهم",
            ]);
        }

        $new_serial_number = serial_number('school');

        if ($first_second_roadmap === "fr1ksa") {

            if ($manager->first_school_id !== null) {
                $update_first_school = School::find($manager->first_school_id);
                $update_first_school->gendar = $request->input('school_gendar');
                $update_first_school->name = $request->input('school_name');
                $update_first_school->level = $request->input('school_level');
                $update_first_school->ministerial_number = $request->input('ministerial_number');
                $update_first_school->school_type = $request->input('school_type');
                $update_first_school->edu_department_id = $request->input('school_department');
                $update_first_school->edu_department_office_id = $request->input('school_department_office');
                $update_first_school->established_date = $request->input('established_date');
                $update_first_school->school_period = $request->input('school_period');
                $update_first_school->address = $request->input('address');
                $update_first_school->save();
                return response()->json([
                    "status" => true,
                    "msg" => "تم تحديث مدرستك بنجاح",
                    // "html" =>  view('website.roadmap.components.facilities')->render(),
                ]);
            } else {
                $school = School::create([
                    'new_id' => $new_serial_number,
                    'code' => "SCH-" . generateRandomString(6),
                    'first_second_school' => 1,
                    'manager_id' => $manager_id,
                    'gendar' => $request->input('school_gendar'),
                    'name' => $request->input('school_name'),
                    'level' => $request->input('school_level'),
                    'ministerial_number' => $request->input('ministerial_number'),
                    'school_type' => $request->input('school_type'),
                    'edu_department_id' => $request->input('school_department'),
                    'edu_department_office_id' => $request->input('school_department_office'),
                    'established_date' => $request->input('established_date'),
                    'school_period' => $request->input('school_period'),
                    'address' => $request->input('address'),
                ]);
                // Check if the school was successfully created
                if ($school) {
                    $this->addCommiteAndTeamsMainRecords($school->id,$manager->id);
                }
                $manager->roadmap = 4;
                $manager->first_school_id = $school->id;
                $manager->save();
                return response()->json([
                    "status" => true,
                    "msg" => "تم اضافة مدرستك بنجاح",
                ]);
            }
        } elseif ($first_second_roadmap === "sec12saksa") {

            if ($manager->second_school_id !== null) {
                $update_first_school = School::find($manager->second_school_id);
                $update_first_school->gendar = $request->input('school_gendar');
                $update_first_school->name = $request->input('school_name');
                $update_first_school->level = $request->input('school_level');
                $update_first_school->ministerial_number = $request->input('ministerial_number');
                $update_first_school->school_type = $request->input('school_type');
                $update_first_school->edu_department_id = $request->input('school_department');
                $update_first_school->edu_department_office_id = $request->input('school_department_office');
                $update_first_school->established_date = $request->input('established_date');
                $update_first_school->school_period = $request->input('school_period');
                $update_first_school->address = $request->input('address');
                $update_first_school->save();
                return response()->json([
                    "status" => true,
                    "msg" => "تم تحديث مدرستك بنجاح",
                    // "html" =>  view('website.roadmap.components.facilities')->render(),
                ]);
            } else {
                $school = School::create([
                    'new_id' => $new_serial_number,
                    'code' => "SCH-" . generateRandomString(6),
                    'first_second_school' => 2,
                    'manager_id' => $manager_id,
                    'gendar' => $request->input('school_gendar'),
                    'name' => $request->input('school_name'),
                    'level' => $request->input('school_level'),
                    'ministerial_number' => $request->input('ministerial_number'),
                    'school_type' => $request->input('school_type'),
                    'edu_department_id' => $request->input('school_department'),
                    'edu_department_office_id' => $request->input('school_department_office'),
                    'established_date' => $request->input('established_date'),
                    'school_period' => $request->input('school_period'),
                    'address' => $request->input('address'),
                ]);
                if ($school) {
                    $this->addCommiteAndTeamsMainRecords($school->id,$manager->id);
                }
                $manager->roadmap = 12;
                $manager->second_school_id = $school->id;
                $manager->save();
                return response()->json([
                    "status" => true,
                    "msg" => "تم اضافة مدرستك بنجاح",
                ]);
            }
        } else {
            return response()->json([
                "status" => false,
                "msg" => "(0000017) هناك خطا غير متوقع",
            ]);
        }
    }

    // ----------------------------

    // -------------- 4- facilities info --------------
    public function roadmap_facilities_store(Request $request)
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
            'school' => ['required', Rule::in(['fr1ksa', 'sec12saksa'])], //first or second school roadmap
            'building_type' => ['required', Rule::in(['1', '2'])],
            'building_status' => ['required', Rule::in(['1', '2', '3'])],
            'classes_number' => ['required', 'numeric', 'max:2000'],
            'bathroom_number' => ['required', 'numeric', 'max:2000'],
            'floors_number' => ['required', 'numeric', 'max:2000'],
            'teachers_room_number' => ['required', 'numeric', 'max:2000'],
            'management_room_number' => ['required', 'numeric', 'max:2000'],
            'computers_room_number' => ['required', 'numeric', 'max:2000'],
            'lab_room_number' => ['required', 'numeric', 'max:2000'],
            'stock_room_number' => ['required', 'numeric', 'max:2000'],
            'learning_resources_room_number' => ['required', 'numeric', 'max:2000'],
            'activities_room_number' => ['required', 'numeric', 'max:2000'],
            'meetings_room_number' => ['required', 'numeric', 'max:2000'],
            'sport_room_number' => ['required', 'numeric', 'max:2000'],
            'theaters_number' => ['required', 'numeric', 'max:2000'],
            'grounds_number' => ['required', 'numeric', 'max:2000'],
            'outdoor_room_number' => ['required', 'numeric', 'max:2000'],
            'indoor_room_number' => ['required', 'numeric', 'max:2000'],
        ], $messages);

        $first_second_roadmap = $request->input('school');
        $manager_id = Auth::guard('school')->id();
        $last_roadmap_access = Auth::guard('school')->user()->roadmap;
        $manager = Manager::find($manager_id);

        // sum totals
        $total = $request->input('classes_number') + $request->input('bathroom_number') + $request->input('floors_number') + $request->input('teachers_room_number') + $request->input('management_room_number') + $request->input('computers_room_number') + $request->input('lab_room_number') + $request->input('stock_room_number') + $request->input('learning_resources_room_number') + $request->input('activities_room_number') + $request->input('meetings_room_number') + $request->input('sport_room_number') + $request->input('theaters_number') + $request->input('grounds_number') + $request->input('outdoor_room_number') + $request->input('indoor_room_number');

        //validation
        if ($last_roadmap_access < 4) {
            return response()->json([
                "status" => false,
                "msg" => "(0000018) تم تخطي المراحل دون حفظ",
            ]);
        } elseif ($first_second_roadmap === "sec12saksa" && $manager->shared_school == 1) {
            return response()->json([
                "status" => false,
                "msg" => "(0000019) تم الذهاب الي الرحلة الثانية برغم اختيار مدرسة غير مشتركة ",
            ]);
        } elseif (count($manager->schools) > 2 && $manager->second_school_id !== null) {
            return response()->json([
                "status" => false,
                "msg" => "(0000020) هناك اكثر من مدرستين تم تسجيلهم",
            ]);
        }

        $new_serial_number = serial_number('school');

        if ($first_second_roadmap === "fr1ksa") {
            $update_first_school = School::find($manager->first_school_id);
            $manager->roadmap = 5;
            $manager->save();
        } elseif ($first_second_roadmap === "sec12saksa") {
            $update_first_school = School::find($manager->second_school_id);
            $manager->roadmap = 13;
            $manager->save();
        } else {
            return response()->json([
                "status" => false,
                "msg" => "(0000017) هناك خطا غير متوقع",
            ]);
        }
        $update_first_school->building_type = $request->input('building_type');
        $update_first_school->building_status = $request->input('building_status');
        $update_first_school->classes_number = $request->input('classes_number');
        $update_first_school->bathroom_number = $request->input('bathroom_number');
        $update_first_school->floors_number = $request->input('floors_number');
        $update_first_school->teachers_room_number = $request->input('teachers_room_number');
        $update_first_school->management_room_number = $request->input('management_room_number');
        $update_first_school->computers_room_number = $request->input('computers_room_number');
        $update_first_school->lab_room_number = $request->input('lab_room_number');
        $update_first_school->stock_room_number = $request->input('stock_room_number');
        $update_first_school->learning_resources_room_number = $request->input('learning_resources_room_number');
        $update_first_school->activities_room_number = $request->input('activities_room_number');
        $update_first_school->meetings_room_number = $request->input('meetings_room_number');
        $update_first_school->sport_room_number = $request->input('sport_room_number');
        $update_first_school->theaters_number = $request->input('theaters_number');
        $update_first_school->grounds_number = $request->input('grounds_number');
        $update_first_school->outdoor_room_number = $request->input('outdoor_room_number');
        $update_first_school->indoor_room_number = $request->input('indoor_room_number');
        $update_first_school->total_rooms = $total;
        $update_first_school->save();

        return response()->json([
            "status" => true,
            "msg" => "تم اضافة المرافق الي مدرستك بنجاح",
        ]);
    }

    // ----------------------------

    // -------------- 5- students --------------
    public function roadmap_students_store(Request $request)
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
            'school' => ['required', Rule::in(['fr1ksa', 'sec12saksa'])], //first or second school roadmap
            'students_file_upload' => 'required|mimes:xlx,xls,xlsx|max:2048',
        ], $messages);


        $first_second_roadmap = $request->input('school');
        $manager_id = Auth::guard('school')->id();
        $last_roadmap_access = Auth::guard('school')->user()->roadmap;
        $manager = Manager::find($manager_id);

        //validation
        if ($last_roadmap_access < 5) {
            return response()->json([
                "status" => false,
                "msg" => "(0000021) تم تخطي المراحل دون حفظ",
            ]);
        } elseif ($first_second_roadmap === "sec12saksa" && $manager->shared_school == 1) {
            return response()->json([
                "status" => false,
                "msg" => "(0000022) تم الذهاب الي الرحلة الثانية برغم اختيار مدرسة غير مشتركة ",
            ]);
        } elseif (count($manager->schools) > 2 && $manager->second_school_id !== null) {
            return response()->json([
                "status" => false,
                "msg" => "(0000023) هناك اكثر من مدرستين تم تسجيلهم",
            ]);
        }

        $new_serial_number = serial_number('school');

        if ($first_second_roadmap === "fr1ksa") {

            $first_school_id = $manager->first_school_id;

            // delete old students with their grades and classes
            if (count($manager->first_school_students) > 0) {
                $manager->first_school_students()->forceDelete();
                $manager->first_school_grades()->forceDelete();
                $manager->first_school_classes()->forceDelete();
            }

            $upload = Excel::import(new Student_sheetImport($manager_id, $first_school_id), $request->file('students_file_upload'));

            session()->flash('success', 'تم بنجاح رفع ملف الطلاب');
            return redirect()->back();
        } elseif ($first_second_roadmap === "sec12saksa") {

            $second_school_id = $manager->second_school_id;

            // delete old students with their grades and classes
            if (count($manager->second_school_students) > 0) {
                $manager->second_school_students()->forceDelete();
                $manager->second_school_grades()->forceDelete();
                $manager->second_school_classes()->forceDelete();
            }

            $upload = Excel::import(new Student_sheetImport($manager_id, $second_school_id), $request->file('students_file_upload'));

            session()->flash('success', 'تم بنجاح رفع ملف الطلاب');
            return redirect()->back();
        } else {
            return response()->json([
                "status" => false,
                "msg" => "(0000017) هناك خطا غير متوقع",
            ]);
        }
    }
    public function roadmap_students_next_store(Request $request)
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
            'school' => ['required', Rule::in(['fr1ksa', 'sec12saksa'])], //first or second school roadmap
        ], $messages);


        $first_second_roadmap = $request->input('school');
        $manager_id = Auth::guard('school')->id();
        $last_roadmap_access = Auth::guard('school')->user()->roadmap;
        $manager = Manager::find($manager_id);

        //validation
        if ($last_roadmap_access < 5) {
            return response()->json([
                "status" => false,
                "msg" => "(0000024) تم تخطي المراحل دون حفظ",
            ]);
        } elseif ($first_second_roadmap === "sec12saksa" && $manager->shared_school == 1) {
            return response()->json([
                "status" => false,
                "msg" => "(0000025) تم الذهاب الي الرحلة الثانية برغم اختيار مدرسة غير مشتركة ",
            ]);
        } elseif (count($manager->schools) > 2 && $manager->second_school_id !== null) {
            return response()->json([
                "status" => false,
                "msg" => "(0000026) هناك اكثر من مدرستين تم تسجيلهم",
            ]);
        } elseif (count($manager->first_school_students) == 0 && $first_second_roadmap === "fr1ksa") {
            return response()->json([
                "status" => false,
                "msg" => "(0000027) لم يتم استيراد الطلاب",
            ]);
        } elseif (count($manager->second_school_students) == 0 && $first_second_roadmap === "sec12saksa") {
            return response()->json([
                "status" => false,
                "msg" => "(0000028) لم يتم استيراد الطلاب",
            ]);
        }


        if ($first_second_roadmap === "fr1ksa") {
            //save the last access roadmap
            $manager->roadmap = 6;
            $manager->save();
        } elseif ($first_second_roadmap === "sec12saksa") {
            //save the last access roadmap
            $manager->roadmap = 14;
            $manager->save();
        }

        return response()->json([
            "status" => true,
            "msg" => "تم استيراد ملف الطلاب بنجاح",
        ]);
    }
    // ----------------------------

    // -------------- 6- entsab --------------
    public function roadmap_entsab_store(Request $request)
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
            'school' => ['required', Rule::in(['fr1ksa', 'sec12saksa'])], //first or second school roadmap
            'have_entsab' => ['required', Rule::in(['0', '1'])],
        ], $messages);

        $first_second_roadmap = $request->input('school');
        $manager_id = Auth::guard('school')->id();
        $last_roadmap_access = Auth::guard('school')->user()->roadmap;
        $manager = Manager::find($manager_id);

        //validation
        if ($last_roadmap_access < 6) {
            return response()->json([
                "status" => false,
                "msg" => "(0000029) تم تخطي المراحل دون حفظ",
            ]);
        } elseif ($first_second_roadmap === "sec12saksa" && $manager->shared_school == 1) {
            return response()->json([
                "status" => false,
                "msg" => "(0000030) تم الذهاب الي الرحلة الثانية برغم اختيار مدرسة غير مشتركة ",
            ]);
        } elseif (count($manager->schools) > 2 && $manager->second_school_id !== null) {
            return response()->json([
                "status" => false,
                "msg" => "(0000031) هناك اكثر من مدرستين تم تسجيلهم",
            ]);
        }

        if ($first_second_roadmap === "fr1ksa") {

            if ($request->input('have_entsab') == 1) {

                $first_school_id = $manager->first_school_id;

                $school = School::find($first_school_id);
                $school->has_entsab = 1;
                $school->save();

                foreach ($school->grades as $item) {
                    $input_name = "have_entsab_" . $item->id;
                    $grade_input = $request->input($input_name);

                    if ($grade_input == 1) {
                        $class = School_grade_class::where('school_grade_id', $item->id)->orderBy('name', 'desc')->first();
                        $class->is_entsab = 1;
                        $class->save();
                        $grade = School_grade::find($item->id);
                        $grade->entsab_class_id = $class->id;
                        $grade->save();
                    } else {
                        $class = School_grade_class::where('school_grade_id', $item->id)->orderBy('name', 'desc')->first();
                        $class->is_entsab = 0;
                        $class->save();
                        $grade = School_grade::find($item->id);
                        $grade->entsab_class_id = null;
                        $grade->save();
                    }
                }
            }

            //save the last access roadmap
            $manager->roadmap = 7;
            $manager->save();
        } elseif ($first_second_roadmap === "sec12saksa") {

            if ($request->input('have_entsab') == 1) {

                $second_school_id = $manager->second_school_id;

                $school = School::find($second_school_id);
                $school->has_entsab = 1;
                $school->save();

                foreach ($school->grades as $item) {
                    $input_name = "have_entsab_" . $item->id;
                    $grade_input = $request->input($input_name);

                    if ($grade_input == 1) {
                        $class = School_grade_class::where('school_grade_id', $item->id)->orderBy('name', 'desc')->first();
                        $class->is_entsab = 1;
                        $class->save();
                        $grade = School_grade::find($item->id);
                        $grade->entsab_class_id = $class->id;
                        $grade->save();
                    } else {
                        $class = School_grade_class::where('school_grade_id', $item->id)->orderBy('name', 'desc')->first();
                        $class->is_entsab = 0;
                        $class->save();
                        $grade = School_grade::find($item->id);
                        $grade->entsab_class_id = null;
                        $grade->save();
                    }
                }
            }

            //save the last access roadmap
            $manager->roadmap = 15;
            $manager->save();
        } else {
            return response()->json([
                "status" => false,
                "msg" => "(0000017) هناك خطا غير متوقع",
            ]);
        }


        return response()->json([
            "status" => true,
            "msg" => "تم الحفظ بنجاح",
        ]);
    }

    // -------------- 7- teachers --------------

    public function roadmap_teachers_store(Request $request)
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
            'school' => ['required', Rule::in(['fr1ksa', 'sec12saksa'])], //first or second school roadmap
            'teachers_file_upload' => 'required|mimes:xlx,xls,xlsx|max:2048',
        ], $messages);


        $first_second_roadmap = $request->input('school');
        $manager_id = Auth::guard('school')->id();
        $last_roadmap_access = Auth::guard('school')->user()->roadmap;
        $manager = Manager::find($manager_id);

        //validation
        if ($last_roadmap_access < 7) {
            return response()->json([
                "status" => false,
                "msg" => "(0000032) تم تخطي المراحل دون حفظ",
            ]);
        } elseif ($first_second_roadmap === "sec12saksa" && $manager->shared_school == 1) {
            return response()->json([
                "status" => false,
                "msg" => "(0000033) تم الذهاب الي الرحلة الثانية برغم اختيار مدرسة غير مشتركة ",
            ]);
        } elseif (count($manager->schools) > 2 && $manager->second_school_id !== null) {
            return response()->json([
                "status" => false,
                "msg" => "(0000034) هناك اكثر من مدرستين تم تسجيلهم",
            ]);
        }

        if ($first_second_roadmap === "fr1ksa") {

            $chosen_school_id = $manager->first_school_id;

            // delete old students with their grades and classes
            if (count($manager->first_school_teachers) > 0) {
                $manager->first_school_teachers()->forceDelete();
            }
        } elseif ($first_second_roadmap === "sec12saksa") {

            $chosen_school_id = $manager->second_school_id;
            // delete old students with their grades and classes
            if (count($manager->second_school_teachers) > 0) {
                $manager->second_school_teachers()->forceDelete();
            }
        } else {
            return response()->json([
                "status" => false,
                "msg" => "(0000017) هناك خطا غير متوقع",
            ]);
        }

        $upload = Excel::import(new Teacher_sheetImport($manager_id, $chosen_school_id), $request->file('teachers_file_upload'));

        session()->flash('success', 'تم بنجاح رفع ملف المعلمين');
        return redirect()->back();
    }

    public function roadmap_teachers_update_speciality(Request $request)
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
            'school' => ['required', Rule::in(['fr1ksa', 'sec12saksa'])], //first or second school roadmap
            'speciality' => ['required', 'exists:teacher_specialities,id'],
            'code' => ['required', 'exists:managers,code'],
        ], $messages);

        $first_second_roadmap = $request->input('school');
        $manager_id = Auth::guard('school')->id();
        $last_roadmap_access = Auth::guard('school')->user()->roadmap;
        $manager = Manager::find($manager_id);

        //validation
        if ($last_roadmap_access < 6) {
            return response()->json([
                "status" => false,
                "msg" => "(0000035) تم تخطي المراحل دون حفظ",
            ]);
        } elseif ($first_second_roadmap === "sec12saksa" && $manager->shared_school == 1) {
            return response()->json([
                "status" => false,
                "msg" => "(0000036) تم الذهاب الي الرحلة الثانية برغم اختيار مدرسة غير مشتركة ",
            ]);
        } elseif (count($manager->schools) > 2 && $manager->second_school_id !== null) {
            return response()->json([
                "status" => false,
                "msg" => "(0000037) هناك اكثر من مدرستين تم تسجيلهم",
            ]);
        }


        $code = $request->input('code');

        $teacher = Manager::where('code', $code)->where('belong_manager_id', $manager->id)->first();

        if ($teacher) {

            $teacher->teacher_speciality_id = $request->input('speciality');
            $teacher->save();

            return response()->json([
                "status" => true,
                "msg" => "تم تعديل التخصص للعمل بنجاح",
            ]);
        } else {
            return response()->json([
                "status" => false,
                "msg" => "لا يوجد معلم بهذا الاسم (0000038)",
            ]);
        }
    }

    public function roadmap_teachers_next_store(Request $request)
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
            'school' => ['required', Rule::in(['fr1ksa', 'sec12saksa'])], //first or second school roadmap
        ], $messages);


        $first_second_roadmap = $request->input('school');
        $manager_id = Auth::guard('school')->id();
        $last_roadmap_access = Auth::guard('school')->user()->roadmap;
        $manager = Manager::find($manager_id);

        //validation
        if ($last_roadmap_access < 7) {
            return response()->json([
                "status" => false,
                "msg" => "(0000039) تم تخطي المراحل دون حفظ",
            ]);
        } elseif ($first_second_roadmap === "sec12saksa" && $manager->shared_school == 1) {
            return response()->json([
                "status" => false,
                "msg" => "(0000040) تم الذهاب الي الرحلة الثانية برغم اختيار مدرسة غير مشتركة ",
            ]);
        } elseif (count($manager->schools) > 2 && $manager->second_school_id !== null) {
            return response()->json([
                "status" => false,
                "msg" => "(0000041) هناك اكثر من مدرستين تم تسجيلهم",
            ]);
        } elseif (count($manager->first_school_teachers) == 0 && $first_second_roadmap === "fr1ksa") {
            return response()->json([
                "status" => false,
                "msg" => "(0000042) لم يتم استيراد المعلمين",
            ]);
        } elseif (count($manager->second_school_teachers) == 0 && $first_second_roadmap === "sec12saksa") {
            return response()->json([
                "status" => false,
                "msg" => "(0000043) لم يتم استيراد المعلمين",
            ]);
        }


        if ($first_second_roadmap === "fr1ksa") {
            //save the last access roadmap
            $manager->roadmap = 8;
            $manager->save();
        } elseif ($first_second_roadmap === "sec12saksa") {
            //save the last access roadmap
            $manager->roadmap = 16;
            $manager->save();
        }

        return response()->json([
            "status" => true,
            "msg" => "تم استيراد ملف الطلاب بنجاح",
        ]);
    }
    // ----------------------------


    // -------------- 8- administrator --------------

    public function roadmap_administrator_store(Request $request)
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
            'school' => ['required', Rule::in(['fr1ksa', 'sec12saksa'])], //first or second school roadmap
            'admin_name' => ['required', 'min:2', 'max:100'],
            'admin_identification_number' => ['required', 'min:2', 'max:100', 'unique:managers,identification_number'],
            'admin_phone_number' => ['required', 'min:2', 'max:100', 'unique:managers,phone_number'],
            'admin_email' => ['required', 'min:4', 'max:40', 'email', 'unique:managers,email'],
            'admin_school_job' => ['required', 'exists:school_jobs,id'],
            'admin_speciality_id' => ['required', 'exists:teacher_specialities,id'],
        ], $messages);

        $first_second_roadmap = $request->input('school');

        $manager_id = Auth::guard('school')->id();
        $last_roadmap_access = Auth::guard('school')->user()->roadmap;

        $manager = Manager::find($manager_id);

        //validation
        if (in_array($last_roadmap_access, [1, 2])) {
            return response()->json([
                "status" => false,
                "msg" => "لم يتم اختيار نوع المدرسة بعد (0000044)",
            ]);
        } elseif ($first_second_roadmap === "sec12saksa" && $manager->shared_school == 1) {
            return response()->json([
                "status" => false,
                "msg" => "(0000045) تم الذهاب الي الرحلة الثانية برغم اختيار مدرسة غير مشتركة ",
            ]);
        } elseif (count($manager->schools) > 2 && $manager->second_school_id !== null) {
            return response()->json([
                "status" => false,
                "msg" => "(0000046) هناك اكثر من مدرستين تم تسجيلهم",
            ]);
        }

        $new_serial_number_patient = serial_number('managers');

        if ($first_second_roadmap === "fr1ksa") {
            $chosen_school_id = $manager->first_school_id;
        } elseif ($first_second_roadmap === "sec12saksa") {
            $chosen_school_id = $manager->second_school_id;
        } else {
            return response()->json([
                "status" => false,
                "msg" => "(0000017) هناك خطا غير متوقع",
            ]);
        }

        $teacher = Manager::create([
            'new_id' => $new_serial_number_patient,
            'code' => "ADS-" . generateRandomString(6),
            'type' => 2,
            'belong_school_id' => $chosen_school_id,
            'belong_manager_id' => $manager->id,
            'first_name' => $request->input('admin_name'),
            'password' => bcrypt($request->input('admin_phone_number') . "pass"),
            'email' => $request->input('admin_email'),
            'phone_number' => $request->input('admin_phone_number'),
            'identification_number' => $request->input('admin_identification_number'),
            'from_recourse_id' => 6,
            'school_job_id' => $request->input('admin_school_job'),
            'teacher_speciality_id' => $request->input('admin_speciality_id'),
        ]);

        return response()->json([
            "status" => true,
            "id" => $teacher->id,
            "code" => $teacher->code,
            "msg" => "تم تسجيل الاداري بنجاح",
        ]);
    }

    public function roadmap_administrator_update_speciality(Request $request)
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
            'code' => ['required', 'exists:managers,code'],
            'admin_name' => ['required', 'min:2', 'max:100'],
            'admin_identification_number' => ['required', 'min:2', 'max:100'],
            'admin_phone_number' => ['required', 'min:2', 'max:100'],
            'admin_email' => ['required', 'min:4', 'max:40', 'email'],
            'admin_school_job' => ['required', 'exists:school_jobs,id'],
            'admin_speciality_id' => ['required', 'exists:teacher_specialities,id'],
        ], $messages);

        $first_second_roadmap = $request->input('school');

        $manager_id = Auth::guard('school')->id();
        $last_roadmap_access = Auth::guard('school')->user()->roadmap;

        $manager = Manager::find($manager_id);

        //validation
        if (in_array($last_roadmap_access, [1, 2])) {
            return response()->json([
                "status" => false,
                "msg" => "لم يتم اختيار نوع المدرسة بعد (0000051)",
            ]);
        } elseif ($first_second_roadmap === "sec12saksa" && $manager->shared_school == 1) {
            return response()->json([
                "status" => false,
                "msg" => "(0000052) تم الذهاب الي الرحلة الثانية برغم اختيار مدرسة غير مشتركة ",
            ]);
        } elseif (count($manager->schools) > 2 && $manager->second_school_id !== null) {
            return response()->json([
                "status" => false,
                "msg" => "(0000053) هناك اكثر من مدرستين تم تسجيلهم",
            ]);
        }

        $code = $request->input('code');
        $administrator = Manager::where('code', $code)->where('belong_manager_id', $manager->id)->first();

        if ($administrator) {
            $administrator->first_name = $request->input('admin_name');
            $administrator->identification_number = $request->input('admin_identification_number');
            $administrator->phone_number = $request->input('admin_phone_number');
            $administrator->email = $request->input('admin_email');
            $administrator->school_job_id = $request->input('admin_school_job');
            $administrator->teacher_speciality_id = $request->input('admin_speciality_id');
            $administrator->save();

            return response()->json([
                "status" => true,
                "msg" => "تم تعديل الاداري بنجاح",
            ]);
        } else {
            return response()->json([
                "status" => false,
                "msg" => "(0000054) لا يوجد اسم الاداري في النظام",
            ]);
        }
    }

    public function roadmap_administrator_delete_speciality(Request $request)
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
            'code' => ['required', 'exists:managers,code'],
        ], $messages);

        $first_second_roadmap = $request->input('school');

        $manager_id = Auth::guard('school')->id();
        $last_roadmap_access = Auth::guard('school')->user()->roadmap;

        $manager = Manager::find($manager_id);

        //validation
        if (in_array($last_roadmap_access, [1, 2])) {
            return response()->json([
                "status" => false,
                "msg" => "لم يتم اختيار نوع المدرسة بعد (0000047)",
            ]);
        } elseif ($first_second_roadmap === "sec12saksa" && $manager->shared_school == 1) {
            return response()->json([
                "status" => false,
                "msg" => "(0000048) تم الذهاب الي الرحلة الثانية برغم اختيار مدرسة غير مشتركة ",
            ]);
        } elseif (count($manager->schools) > 2 && $manager->second_school_id !== null) {
            return response()->json([
                "status" => false,
                "msg" => "(0000049) هناك اكثر من مدرستين تم تسجيلهم",
            ]);
        }

        $code = $request->input('code');

        $administrator = Manager::where('code', $code)->where('belong_manager_id', $manager->id)->first();

        if ($administrator) {
            $administrator->forceDelete();

            return response()->json([
                "status" => true,
                "msg" => "تم حذف الاداري بنجاح",
            ]);
        } else {
            return response()->json([
                "status" => false,
                "msg" => "(0000050) لا يوجد اسم الاداري في النظام",
            ]);
        }
    }

    public function roadmap_administrator_next_store(Request $request)
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
            'school' => ['required', Rule::in(['fr1ksa', 'sec12saksa'])], //first or second school roadmap
        ], $messages);


        $first_second_roadmap = $request->input('school');
        $manager_id = Auth::guard('school')->id();
        $last_roadmap_access = Auth::guard('school')->user()->roadmap;
        $manager = Manager::find($manager_id);

        //validation
        if ($last_roadmap_access < 8) {
            return response()->json([
                "status" => false,
                "msg" => "(0000055) تم تخطي المراحل دون حفظ",
            ]);
        } elseif ($first_second_roadmap === "sec12saksa" && $manager->shared_school == 1) {
            return response()->json([
                "status" => false,
                "msg" => "(0000056) تم الذهاب الي الرحلة الثانية برغم اختيار مدرسة غير مشتركة ",
            ]);
        } elseif (count($manager->schools) > 2 && $manager->second_school_id !== null) {
            return response()->json([
                "status" => false,
                "msg" => "(0000057) هناك اكثر من مدرستين تم تسجيلهم",
            ]);
        } elseif (count($manager->first_school_administrators) == 0 && $first_second_roadmap === "fr1ksa") {
            return response()->json([
                "status" => false,
                "msg" => "(0000058) لم يتم استيراد الاداريين",
            ]);
        } elseif (count($manager->second_school_administrators) == 0 && $first_second_roadmap === "sec12saksa") {
            return response()->json([
                "status" => false,
                "msg" => "(0000059) لم يتم استيراد الاداريين",
            ]);
        }


        if ($first_second_roadmap === "fr1ksa") {
            //save the last access roadmap
            $manager->roadmap = 9;
            $manager->save();
        } elseif ($first_second_roadmap === "sec12saksa") {
            //save the last access roadmap
            $manager->roadmap = 17;
            $manager->save();
        }



        return response()->json([
            "status" => true,
            "msg" => "تم اضافة جميع الاداريين",
        ]);
    }


    // ----------------------------



    // -------------- 9- general info --------------
    public function roadmap_other_info_store(Request $request)
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
            'school' => ['required', Rule::in(['fr1ksa', 'sec12saksa'])], //first or second school roadmap
            'school_telephone' => ['nullable', 'min:2', 'max:20'],
            'school_phone_number' => ['required', 'min:2', 'max:20'],
            'school_whatsapp' => ['nullable', 'min:2', 'max:20'],
            'school_twitter' => ['required', 'min:2', 'max:20'],
            'school_website' => ['nullable', 'min:2', 'max:40'],
            'school_facebook' => ['nullable', 'min:2', 'max:20'],
            'school_snapchat' => ['nullable', 'min:2', 'max:20'],
            'school_tiktok' => ['nullable', 'min:2', 'max:20'],
            'school_telegram' => ['nullable', 'min:2', 'max:20'],
        ], $messages);

        $first_second_roadmap = $request->input('school');

        $manager_id = Auth::guard('school')->id();
        $last_roadmap_access = Auth::guard('school')->user()->roadmap;

        $manager = Manager::find($manager_id);

        //validation
        if (in_array($last_roadmap_access, [1, 2])) {
            return response()->json([
                "status" => false,
                "msg" => "لم يتم اختيار نوع المدرسة بعد (0000060)",
            ]);
        } elseif ($first_second_roadmap === "sec12saksa" && $manager->shared_school == 1) {
            return response()->json([
                "status" => false,
                "msg" => "(0000061) تم الذهاب الي الرحلة الثانية برغم اختيار مدرسة غير مشتركة ",
            ]);
        } elseif (count($manager->schools) > 2 && $manager->second_school_id !== null) {
            return response()->json([
                "status" => false,
                "msg" => "(0000062) هناك اكثر من مدرستين تم تسجيلهم",
            ]);
        }

        if ($first_second_roadmap === "fr1ksa") {

            $chosen_school_id = $manager->first_school_id;
            $manager->roadmap = 10;
            $manager->save();
        } elseif ($first_second_roadmap === "sec12saksa") {

            $chosen_school_id = $manager->second_school_id;
            $manager->roadmap = 18;
            $manager->save();
        } else {
            return response()->json([
                "status" => false,
                "msg" => "(0000017) هناك خطا غير متوقع",
            ]);
        }

        $update_first_school = School::find($chosen_school_id);
        $update_first_school->telephone = $request->input('school_telephone');
        $update_first_school->phone_number = $request->input('school_phone_number');
        $update_first_school->whatsapp = $request->input('school_whatsapp');
        $update_first_school->twitter = $request->input('school_twitter');
        $update_first_school->website = $request->input('school_website');
        $update_first_school->facebook = $request->input('school_facebook');
        $update_first_school->snapchat = $request->input('school_snapchat');
        $update_first_school->tiktok = $request->input('school_tiktok');
        $update_first_school->telegram = $request->input('school_telegram');
        $update_first_school->save();

        return response()->json([
            "status" => true,
            "msg" => "تم تحديث بيانات مدرستك بنجاح",
            // "html" =>  view('website.roadmap.components.facilities')->render(),
        ]);
    }
    // ----------------------------


    // -------------- 10- finish --------------
    public function roadmap_finish_store(Request $request)
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
            'school' => ['required', Rule::in(['fr1ksa', 'sec12saksa'])], //first or second school roadmap
            'type' => ['required', Rule::in(['1', '2'])], //first or second school roadmap
        ], $messages);

        $first_second_roadmap = $request->input('school');
        $which_school = $request->input('type');

        $manager_id = Auth::guard('school')->id();
        $last_roadmap_access = Auth::guard('school')->user()->roadmap;

        $manager = Manager::find($manager_id);

        //validation
        if (in_array($last_roadmap_access, [1, 2])) {
            return response()->json([
                "status" => false,
                "msg" => "لم يتم اختيار نوع المدرسة بعد (0000063)",
            ]);
        } elseif ($first_second_roadmap === "sec12saksa" && $manager->shared_school == 1) {
            return response()->json([
                "status" => false,
                "msg" => "(0000064) تم الذهاب الي الرحلة الثانية برغم اختيار مدرسة غير مشتركة ",
            ]);
        } elseif (count($manager->schools) > 2 && $manager->second_school_id !== null) {
            return response()->json([
                "status" => false,
                "msg" => "(0000065) هناك اكثر من مدرستين تم تسجيلهم",
            ]);
        } elseif ($first_second_roadmap === "fr1ksa" && $manager->shared_school == 1 && $last_roadmap_access == 10) {

            $manager->roadmap = 19; //done roadmap and go to the dashboard

            // save the current working school in dashboard
            $manager->current_working_school_id = $manager->first_school_id;
            $manager->save();

            return response()->json([
                "status" => true,
                "type" => "done",
                "msg" => "تم الانتهاء من الرحلة بنجاح",
                "url" => route('school_route.dashboard'),
            ]);
        } elseif ($first_second_roadmap === "fr1ksa" && $manager->shared_school == 2 && $last_roadmap_access == 10) {
            $manager->roadmap = 11; //done roadmap and go to the next school roadmap
            $manager->save();
            return response()->json([
                "status" => true,
                "type" => "to_second_school",
                "msg" => "الانتقال الي الرحلة الثانية",
                "url" => route('school_route.second_roadmap'),
            ]);
        } elseif ($first_second_roadmap === "sec12saksa" && $manager->shared_school == 2 && $last_roadmap_access == 18) {
            $manager->roadmap = 19; //done roadmap and go to the dashboard

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
                "msg" => "اهلا بك في منصة نور",
                "url" => route('school_route.dashboard'),
            ]);
        } else {
            return response()->json([
                "status" => false,
                "msg" => "(0000066) هناك مشكلة غير متوقعه",
            ]);
        }
    }
    // ----------------------------


}
