<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Http\Services\smsGateways\Whysms;
use App\Imports\ClientImport;
use App\Imports\StudentImport;
use App\Models\Branch\Appointment;
use App\Models\Branch\Branch;
use App\Models\Invoice\Acc_account;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\Invoice_item;
use App\Models\Invoice\Wallet;
use App\Models\location\City;
use App\Models\location\Country;
use App\Models\location\Region;
use App\Models\Patient\Ask_for_cat;
use App\Models\Patient\Ask_for_main_cat;
use App\Models\Patient\From_recourse;
use App\Models\Patient\Pat_company_worker;
use App\Models\Patient\Patient;
use App\Models\Patient\Service_item;
use App\Models\Patient\Session_pat;
use App\Models\Patient\Specialty_cat;
use App\Models\School\Manager;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Mpdf\Mpdf;
use Mpdf\Tag\Input;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
use Image;
use Maatwebsite\Excel\Facades\Excel;


class PatientController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:Super-admin|Branch-manager|Receptionist|Call-center|Monitor|Marketing|Data-entry|Hotel-worker|Hotel-manager|Transport-manager|Transport-worker|Driver|Airline-manager|Airline-worker|Visa-manager|Visa-worker|Trip-manager|Trip-worker|Package-manager|Package-worker|Sales-manager|Sales-worker|Operation-manager|Operation-worker')->only('index');
        $this->middleware('role:Super-admin|Branch-manager|Receptionist|Call-center|Monitor|Marketing|Data-entry|Hotel-worker|Hotel-manager|Transport-manager|Transport-worker|Driver|Airline-manager|Airline-worker|Visa-manager|Visa-worker|Trip-manager|Trip-worker|Package-manager|Package-worker|Sales-manager|Sales-worker|Operation-manager|Operation-worker')->only('show');
        $this->middleware('role:Super-admin|Branch-manager|Marketing|Data-entry|Hotel-manager|Transport-manager|Driver|Airline-manager|Visa-manager|Trip-manager|Package-manager|Operation-manager')->only('create');
        $this->middleware('role:Super-admin|Branch-manager|Marketing|Data-entry|Hotel-manager|Transport-manager|Driver|Airline-manager|Visa-manager|Trip-manager|Package-manager|Operation-manager')->only('store');
        $this->middleware('role:Super-admin|Branch-manager|Marketing|Data-entry|Hotel-manager|Transport-manager|Driver|Airline-manager|Visa-manager|Trip-manager|Package-manager|Operation-manager')->only('update');
        $this->middleware('role:Super-admin|Branch-manager|Marketing|Data-entry|Hotel-manager|Transport-manager|Driver|Airline-manager|Visa-manager|Trip-manager|Package-manager|Operation-manager')->only('edit');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('patient.index');
    }

    public function new_patients_index()
    {
        $branch = request()->branch;
        $patient = Manager::select('id', 'first_name', 'second_name', 'code', 'avatar', 'birthday', 'country_id', 'city_id', 'phone_number', 'created_at')
            ->with(['country' => function ($q) {
                $q->select('id', 'name');
            }])
            ->with(['city' => function ($q) {
                $q->select('id', 'name');
            }])
            ->where('type', 1)
            ->orderBy('id', 'DESC')
            ->limit(8)
            ->get();
        return $patient;
    }

    //search all patients depends on filters
    public function show_all_patients(request $request)
    {

        $patients = Manager::select('id', 'code', 'first_name', 'second_name', 'type', 'avatar', 'birthday', 'country_id', 'city_id', 'phone_number', 'from_recourse_id', 'created_at')
            ->where('type', 1)
            ->with(['country' => function ($q) {
                $q->select('id', 'name');
            }])
            ->with(['city' => function ($q) {
                $q->select('id', 'name');
            }])
            ->with(['recourse' => function ($q) {
                $q->select('id', 'name');
            }])
            ->orderBy('id', 'DESC');

        if ($request->input('type_srch')) {
            $patients = $patients->where('type', $request->input('type_srch'));
        }

        if ($request->input('reco_srch')) {
            $patients = $patients->where('recommendation', $request->input('reco_srch'));
        }

        if ($request->input('askfor_srch')) {
            $patients = $patients->where('ask_for_id', $request->input('askfor_srch'));
        }

        if ($request->input('branch_srch')) {
            $patients = $patients->where('first_branch_id', $request->input('branch_srch'));
        }

        if ($request->input('resource_srch')) {
            $patients = $patients->where('from_recourse_id', $request->input('resource_srch'));
        }

        if ($request->input('country_srch')) {
            $patients = $patients->where('country_id', $request->input('country_srch'));
        }

        if ($request->input('city_srch')) {
            $patients = $patients->where('city_id', $request->input('city_srch'));
        }

        if ($request->input('gendar_srch')) {
            $patients = $patients->where('gendar', $request->input('gendar_srch'));
        }

        if ($request->input('date_srch')) {
            $date_serc = explode('to', $request->input('date_srch'));
            $date_1_serc = $date_serc[0];

            if (isset($date_serc[1])) {
                $date_2_serc = $date_serc[1];
            } else {
                $date_2_serc = $date_serc[0];
            }
            $patients = $patients->whereBetween('created_at', [
                Carbon::createFromFormat('m-Y', $date_1_serc)->startOfMonth(), //2022-10-01 00:00:00.0
                Carbon::createFromFormat('m-Y', $date_2_serc)->endOfMonth() // 2022-10-31 23:59:59.999999
            ]);
        }

        $patients = $patients->paginate(10);


        //for sending SMS message to the specific group
        if ($request->input('sms_content')) {

            $this->validate($request, [
                'sms_content' => ['sometimes', 'required', 'max:70'],
            ]);

            $sms_content = $request->input('sms_content');

            $patients_sms = Manager::select('id', 'first_name', 'phone_number', DB::raw('CONCAT(first_Name, " ", second_Name) AS name'))
                ->orderBy('id', 'DESC');

            if ($request->input('type_srch')) {
                $patients_sms = $patients_sms->where('type', $request->input('type_srch'));
            }

            if ($request->input('reco_srch')) {
                $patients_sms = $patients_sms->where('recommendation', $request->input('reco_srch'));
            }

            if ($request->input('askfor_srch')) {
                $patients_sms = $patients_sms->where('ask_for_id', $request->input('askfor_srch'))
                    ->where('status', 1);
            }

            if ($request->input('resource_srch')) {
                $patients_sms = $patients_sms->where('from_recourse_id', $request->input('resource_srch'));
            }


            if ($request->input('country_srch')) {
                $patients_sms = $patients_sms->where('country_id', $request->input('country_srch'));
            }

            if ($request->input('city_srch')) {
                $patients_sms = $patients_sms->where('city_id', $request->input('city_srch'));
            }

            if ($request->input('gendar_srch')) {
                $patients_sms = $patients_sms->where('gendar', $request->input('gendar_srch'));
            }

            if ($request->input('date_srch')) {
                $date_serc = explode('to', $request->input('date_srch'));
                $date_1_serc = $date_serc[0];

                if (isset($date_serc[1])) {
                    $date_2_serc = $date_serc[1];
                } else {
                    $date_2_serc = $date_serc[0];
                }

                $patients_sms = $patients_sms->whereBetween('created_at', [
                    Carbon::createFromFormat('m-Y', $date_1_serc)->startOfMonth(), //2022-10-01 00:00:00.0
                    Carbon::createFromFormat('m-Y', $date_2_serc)->endOfMonth() // 2022-10-31 23:59:59.999999
                ]);
            }

            $patients_sms = $patients_sms->get();

            foreach ($patients_sms as $item) {
                //app(Victorylink::class)->sendSms($item->phone_number, $sms_content, 'ar');
                // app(Whysms::class)->sendSms($item->phone_number, $sms_content);
            }
        }

        $resources = From_recourse::all();

        $country = Manager::select('country_id', DB::raw('count(country_id) as total'))
            ->with(['country' => function ($q) {
                $q->select('id', 'name');
            }])
            ->groupBy('country_id')
            ->orderBy('total', 'DESC')
            ->limit(7)
            ->get();

        $city = Manager::select('city_id', DB::raw('count(city_id) as total'))
            ->with(['country' => function ($q) {
                $q->select('id', 'name');
            }])
            ->groupBy('city_id')
            ->orderBy('total', 'DESC')
            ->limit(7)
            ->get();

        return view('patient.show_all', compact('patients', 'resources', 'country', 'city'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $countries = Country::orderBy('fav', 'DESC')->get();
        $from_recourses = From_recourse::all();
        $ask_for_main = Ask_for_main_cat::all();

        return view('patient.create', compact('countries', 'from_recourses', 'ask_for_main'));
    }

    //for select input ajax to send the cities beasd on the given country
    public function createcityajax($id)
    {
        return City::where('country_id', $id)->get();
    }
    public function createregionajax($id)
    {
        return Region::where('city_id', $id)->get();
    }

    //for select input ajax to send the cities beasd on the given country
    public function create_askfor_ajax($id)
    {
        return Ask_for_cat::where('ask_for_main_cat_id', $id)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientRequest $request)
    {
        //insert img
        if ($request->hasFile('avatar')) {
            $file_extension = request()->avatar->getClientOriginalExtension();
            $file_name = $request->input('first_name') . time() . '.' . $file_extension;
            $path = 'img/useravatar';
            $request->avatar->move($path, $file_name);
        } else {
            $file_name = 'default-pp.png';
        };

        //create the new serial code 000001
        $new_serial_number_patient = serial_number('patient', $request->input('first_branch_id'));

        $user = Manager::create([
            'new_id' => $new_serial_number_patient,
            'cat' => $request->input('client_type'),
            'type' => $request->input('status'),
            'ask_for_main_id' => $request->input('ask_for_main_id'),
            'ask_for_id' => $request->input('ask_for_id'),
            'ask_for_id' => $request->input('ask_for_id'),
            'traveler_cat' => $request->input('traveler_cat'),
            'traveler_class' => $request->input('traveler_class'),
            'code' => "DTR" . $this->generateRandomString(6),
            'passport_number' => $request->input('passport_number'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'first_branch_id' => $request->input('first_branch_id'),
            'first_name' => $request->input('first_name'),
            'second_name' => $request->input('second_name'),
            'avatar' => $file_name,
            'religion' => $request->input('religion'),
            'birthday' => $request->input('birthday'),
            'gendar' => $request->input('gendar'),
            'country_id' => $request->input('country_id'),
            'city_id' => $request->input('city_id'),
            'region_id' => $request->input('region_id'),
            'phone_number' => $request->input('phone_number'),
            'sec_phone_number' => $request->input('sec_phone_number'),
            'insurance' => $request->input('insurance'),
            'from_recourse_id' => $request->input('from_recourse_id'),
            'commercial_register' => $request->input('commercial_register'),
            'tax_number' => $request->input('tax_number'),
            'creator_id' => Auth::id(),
        ]);

        // add workers to the company

        if ($request->input('worker_name')) {
            foreach ($request->input('worker_name') as $key => $worker_name) {

                $worker_phone = $request->input('worker_phone')[$key];
                $worker_email = $request->input('worker_email')[$key];
                $worker_position = $request->input('worker_position')[$key];

                $workers = Pat_company_worker::create([
                    'patient_id' => $user->id,
                    'name' => $worker_name,
                    'phone_number' => $worker_phone,
                    'email' => $worker_email,
                    'position' => $worker_position
                ]);
            }
        }


        $parent_account = Acc_account::select('code')->where('parent_account_id', 65)
            ->get();

        //if it is not the first recored in the parent
        if (count($parent_account) > 0) {
            $account_code = $parent_account->last()->code + 1;
        } else {
            $account_code = 11311;
        }

        // record a account in accointing chart
        $patient_account = Acc_account::create([
            'system_code' => "ACC" . $this->generateRandomString(6),
            'code' => $account_code,
            'acc_account_type_id' => 6,
            'origin' => 1,
            'cat' => 2,
            'main_account_id' => 1,
            'parent_account_id' => 65,
            'belong_to' => 4,
            'name' => $request->input('first_name') . " " . $request->input('second_name'),
            'level' => 5,
            'description' => "A customer " . $request->input('debtor_company_name'),
        ]);

        $user->acc_account_id = $patient_account->id;
        $user->save();

        session()->flash('success', 'The patient has been created successfully');
        return redirect()->route('sett.managers.show', $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //select the searched patients via ajax
    public function patient_search($search_query)
    {

        $search_query = request()->search_query;

        $patient = Manager::select('id', 'first_name', 'second_name')
            ->where(function ($query) use ($search_query) {
                $query->orWhereRaw("concat(first_name, ' ', second_name) like '%$search_query%' ")
                    ->orWhere('first_name', 'like', "%{$search_query}%")
                    ->orWhere('second_name', 'like', "%{$search_query}%")
                    ->orWhere('code', 'like', "%{$search_query}%")
                    ->orWhere('phone_number', 'like', "%{$search_query}%");
            })
            ->where('type', 1)
            ->limit(10);

        if (Auth::user()->branch_id !== 0) {
            $patient = $patient->where('first_branch_id', Auth::user()->branch_id);
        }

        $patient = $patient->get();

        return $patient;
    }

    public function show($id)
    {

        $patient = Manager::find($id);

        return view('patient.show', compact('patient'));
    }


    public function sms_form_profile(Request $request, $id)
    {

        $this->validate($request, [
            'sms_content' => ['required', 'max:70'],
        ]);

        $sms_content = $request->input('sms_content');

        $patient = Manager::select('id', 'first_name', 'phone_number')->find($id);

        app(Whysms::class)->sendSms($patient->phone_number, $sms_content);

        session()->flash('success', 'The SMS has been Sent');
        return redirect()->back();
    }

    public function allstatcs(Request $request)
    {


        if (!empty($request->input('branch'))) {
            $branch = $request->input('branch');
        } else {
            $branch = 'all';
        }
        if (!empty($request->input('from'))) {
            $from = $request->input('from');
        } else {
            $from = 'all';
        }
        if (!empty($request->input('to'))) {
            $to = $request->input('to');
        } else {
            $to = 'all';
        }

        if (!empty($request->input('status'))) {
            $status = $request->input('status');
        } else {
            $status = 'all';
        }

        $specialty_cat = Specialty_cat::all();

        //-----
        $each_branches = Manager::select('first_branch_id', DB::raw('count(*) as total'))
            ->groupBy('first_branch_id')
            ->with(['branch' => function ($q) {
                $q->select('id', 'name');
            }])
            ->limit(11)
            ->where('type', 1)
            ->orderBy('total', 'DESC');

        if ($from !== "all") {
            $each_branches = $each_branches->whereBetween('created_at', [
                Carbon::createFromFormat('m-Y', $from)->startOfMonth(), //2022-10-01 00:00:00.0
                Carbon::createFromFormat('m-Y', $to)->endOfMonth() // 2022-10-31 23:59:59.999999
            ]);
        }

        if ($status !== "all") {
            $each_branches = $each_branches->where('type', $status);
        }

        $each_branches = $each_branches->get();


        //-----
        $gendar = Manager::select('gendar', DB::raw('count(*) as total'))
            ->groupBy('gendar')
            ->where('type', 1)
            ->limit(11);

        if ($branch !== "all") {
            $gendar = $gendar->where('first_branch_id', $branch);
        }

        if ($from !== "all") {
            $gendar = $gendar->whereBetween('created_at', [
                Carbon::createFromFormat('m-Y', $from)->startOfMonth(), //2022-10-01 00:00:00.0
                Carbon::createFromFormat('m-Y', $to)->endOfMonth() // 2022-10-31 23:59:59.999999
            ]);
        }

        if ($status !== "all") {
            $gendar = $gendar->where('type', $status);
        }

        $gendar = $gendar->get();

        //-----
        $resource = Manager::select('from_recourse_id', DB::raw('count(*) as total'))
            ->groupBy('from_recourse_id')
            ->with(['recourse' => function ($q) {
                $q->select('id', 'name');
            }])
            ->limit(11)
            ->where('type', 1)
            ->orderBy('total', 'DESC');

        if ($branch !== "all") {
            $resource = $resource->where('first_branch_id', $branch);
        }

        if ($from !== "all") {
            $resource = $resource->whereBetween('created_at', [
                Carbon::createFromFormat('m-Y', $from)->startOfMonth(), //2022-10-01 00:00:00.0
                Carbon::createFromFormat('m-Y', $to)->endOfMonth() // 2022-10-31 23:59:59.999999
            ]);
        }

        if ($status !== "all") {
            $resource = $resource->where('type', $status);
        }

        $resource = $resource->get();

        //-----
        $country = Manager::select('country_id', DB::raw('count(*) as total'))
            ->groupBy('country_id')
            ->with(['country' => function ($q) {
                $q->select('id', 'name');
            }])
            ->limit(11)
            ->where('type', 1)
            ->orderBy('total', 'DESC');

        if ($branch !== "all") {
            $country = $country->where('first_branch_id', $branch);
        }

        if ($branch !== "all") {
            $resource = $resource->where('first_branch_id', $branch);
        }

        if ($from !== "all") {
            $country = $country->whereBetween('created_at', [
                Carbon::createFromFormat('m-Y', $from)->startOfMonth(), //2022-10-01 00:00:00.0
                Carbon::createFromFormat('m-Y', $to)->endOfMonth() // 2022-10-31 23:59:59.999999
            ]);
        }

        if ($status !== "all") {
            $country = $country->where('type', $status);
        }

        $country = $country->get();

        //-----
        $city = Manager::select('city_id', DB::raw('count(*) as total'))
            ->groupBy('city_id')
            ->with(['country' => function ($q) {
                $q->select('id', 'name');
            }])
            ->limit(11)
            ->where('type', 1)
            ->orderBy('total', 'DESC');

        if ($branch !== "all") {
            $city = $city->where('first_branch_id', $branch);
        }

        if ($from !== "all") {
            $city = $city->whereBetween('created_at', [
                Carbon::createFromFormat('m-Y', $from)->startOfMonth(), //2022-10-01 00:00:00.0
                Carbon::createFromFormat('m-Y', $to)->endOfMonth() // 2022-10-31 23:59:59.999999
            ]);
        }

        if ($status !== "all") {
            $city = $city->where('type', $status);
        }

        $city = $city->get();

        //-----
        $region = Manager::select('region_id', DB::raw('count(*) as total'))
            ->groupBy('region_id')
            ->with(['region' => function ($q) {
                $q->select('id', 'name');
            }])
            ->limit(11)
            ->where('type', 1)
            ->orderBy('total', 'DESC');

        if ($branch !== "all") {
            $region = $region->where('first_branch_id', $branch);
        }

        if ($from !== "all") {
            $region = $region->whereBetween('created_at', [
                Carbon::createFromFormat('m-Y', $from)->startOfMonth(), //2022-10-01 00:00:00.0
                Carbon::createFromFormat('m-Y', $to)->endOfMonth() // 2022-10-31 23:59:59.999999
            ]);
        }

        if ($status !== "all") {
            $region = $region->where('type', $status);
        }

        $region = $region->get();

        //-----
        $patient = Manager::select(
            DB::raw('count(id) as counts'),
            DB::raw("DATE_FORMAT(created_at,'%m') as monthKey")
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('monthKey')
            ->where('type', 1)
            ->orderBy('created_at', 'ASC');

        if ($branch !== "all") {
            $patient = $patient->where('first_branch_id', $branch);
        }

        if ($status !== "all") {
            $patient = $patient->where('type', $status);
        }

        $patient = $patient->get();

        $patient_date = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($patient as $order) {
            $patient_date[$order->monthKey - 1] = $order->counts;
        }

        //-----
        $patient_total = Manager::select('id')
            ->where('type', 1);

        if ($branch !== "all") {
            $patient_total = $patient_total->where('first_branch_id', $branch);
        }

        if ($from !== "all") {
            $patient_total = $patient_total->whereBetween('created_at', [
                Carbon::createFromFormat('m-Y', $from)->startOfMonth(), //2022-10-01 00:00:00.0
                Carbon::createFromFormat('m-Y', $to)->endOfMonth() // 2022-10-31 23:59:59.999999
            ]);
        }

        if ($status !== "all") {
            $patient_total = $patient_total->where('type', $status);
        }

        $patient_total = $patient_total->count();

        //-----

        $relgion = Manager::select('religion', DB::raw('count(*) as total'))
            ->groupBy('religion')
            ->limit(11)
            ->where('type', 1)
            ->orderBy('total', 'DESC');

        if ($branch !== "all") {
            $relgion = $relgion->where('first_branch_id', $branch);
        }

        if ($branch !== "all") {
            $relgion = $relgion->where('first_branch_id', $branch);
        }

        if ($from !== "all") {
            $relgion = $relgion->whereBetween('created_at', [
                Carbon::createFromFormat('m-Y', $from)->startOfMonth(), //2022-10-01 00:00:00.0
                Carbon::createFromFormat('m-Y', $to)->endOfMonth() // 2022-10-31 23:59:59.999999
            ]);
        }

        if ($status !== "all") {
            $relgion = $relgion->where('type', $status);
        }

        $relgion = $relgion->get();


        //-----

        $traveler_cat = Manager::select('traveler_cat', DB::raw('count(*) as total'))
            ->groupBy('traveler_cat')
            ->limit(11)
            ->where('type', 1)
            ->orderBy('total', 'DESC');

        if ($branch !== "all") {
            $traveler_cat = $traveler_cat->where('first_branch_id', $branch);
        }

        if ($from !== "all") {
            $traveler_cat = $traveler_cat->whereBetween('created_at', [
                Carbon::createFromFormat('m-Y', $from)->startOfMonth(), //2022-10-01 00:00:00.0
                Carbon::createFromFormat('m-Y', $to)->endOfMonth() // 2022-10-31 23:59:59.999999
            ]);
        }

        if ($status !== "all") {
            $traveler_cat = $traveler_cat->where('type', $status);
        }

        $traveler_cat = $traveler_cat->get();

        //-----

        $traveler_class = Manager::select('traveler_class', DB::raw('count(*) as total'))
            ->groupBy('traveler_class')
            ->limit(11)
            ->where('type', 1)
            ->orderBy('total', 'DESC');

        if ($branch !== "all") {
            $traveler_class = $traveler_class->where('first_branch_id', $branch);
        }

        if ($from !== "all") {
            $traveler_class = $traveler_class->whereBetween('created_at', [
                Carbon::createFromFormat('m-Y', $from)->startOfMonth(), //2022-10-01 00:00:00.0
                Carbon::createFromFormat('m-Y', $to)->endOfMonth() // 2022-10-31 23:59:59.999999
            ]);
        }

        if ($status !== "all") {
            $traveler_class = $traveler_class->where('type', $status);
        }

        $traveler_class = $traveler_class->get();


        return view('patient/allstatcs', compact('patient_date', 'patient_total', 'patient_branches', 'gendar', 'resource', 'country', 'city', 'region', 'branch', 'relgion', 'traveler_cat', 'traveler_class', 'from', 'to'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {

        $patient = Manager::find($id);
        $countries = Country::orderBy('fav', 'DESC')->get();
        $from_recourses = From_recourse::all();

        return view('patient.edit', compact('patient', 'countries', 'from_recourses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatientRequest $request, $id)
    {

        $patient = Manager::find($id);

        $patient->email = $request->input('email');
        $patient->first_name = $request->input('first_name');
        $patient->second_name = $request->input('second_name');
        $patient->gendar = $request->input('gendar');
        $patient->birthday = $request->input('birthday');
        $patient->country_id = $request->input('country_id');
        $patient->city_id = $request->input('city_id');
        $patient->from_recourse_id = $request->input('from_recourse_id');
        $patient->phone_number = $request->input('phone_number');
        $patient->sec_phone_number = $request->input('sec_phone_number');
        $patient->inactive = $request->input('inactive');
        $patient->note = $request->input('note');


        if (!empty($request->input('newpassword'))) {
            $patient->password = bcrypt($request->input('newpassword'));
        }

        //insert img
        if ($request->hasFile('avatar')) {

            if ($patient->avatar !== "default-pp.png") {
                //to remove the old avatar and also keep the default img
                $imagePath = public_path('img/useravatar/' . $patient->avatar);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $file_extension = request()->avatar->getClientOriginalExtension();
            $file_name = $request->input('first_name') . time() . '.' . $file_extension;
            $path = 'img/useravatar';
            $request->avatar->move($path, $file_name);

            $patient->avatar = $file_name; //new img file name
        } else {
            $file_name = request()->avatar;
        }

        $patient->save();

        session()->flash('success', 'The user has been updated');
        return redirect()->route('sett.managers.show', $patient->id);
    }

    public function pat_slight_edit(Request $request)
    {

        $this->validate($request, [
            'patient_id' => ['required', 'exists:patients,id'],
            'edit_type_status' => ['required', Rule::in([1, 2])],
            'edit_recom_status' => ['required', Rule::in([1, 2, 3])],
            'wallet_recom' => ['sometimes', 'required'],
        ]);

        $patient = Manager::find($request->input('patient_id'));

        $patient->inactive = $request->input('edit_type_status');
        $patient->recommendation = $request->input('edit_recom_status');
        $patient->wallet = $request->input('wallet_recom');
        $patient->save();

        session()->flash('success', 'The patient has been updated');
        return redirect()->route('sett.managers.show', $patient->id);
    }


    public function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function note_ajax(Request $request, $id)
    {

        $patient = Manager::find($id);

        $patient->note = $request->input('query');

        $patient->save();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->validate($request, [
            'patient_id' => ['required', 'exists:patients,id'],
        ]);

        $id = $request->input('patient_id');

        $patient = Manager::find($id);

        $patient->delete();

        session()->flash('success', 'The patient has been deleted successfully');
        return redirect()->route('sett.managers.index');
    }

    //add balance to the wallet
    public function add_wallet_balance(Request $request, $id)
    {

        $this->validate($request, [
            'branch_wallet' => ['required', 'exists:branches,id'],
            'wallet_date' => ['required', 'date'],
            'wallet_price' => ['required'],
        ]);

        $invoice = Invoice::create([
            'code' => "IN" . $this->generateRandomString(6),
            'type' => $request->input('type_wallet'),
            'service_inv_cat_id' => 9,
            'specialty_id' => Auth::user()->specialty_id,
            'receivable_id' => $id,
            'receivable_type' => "App\Models\Patient\Patient",
            'branch_id' => $request->input('branch_wallet'),
            'items_price' => $request->input('wallet_price'),
            'final_price' => $request->input('wallet_price'),
            'note' => $request->input('balance_note'),
        ]);

        if ($request->input('type_wallet') == 0) {
            $categorizable_id = 4;
            $categorizable_type = "App\Models\Patient\Service_item";
        } else {
            $categorizable_id = 1;
            $categorizable_type = "App\Models\Invoice\Expenses_item";
        }

        $invoice_item = Invoice_item::create([
            'invoice_id' => $invoice->id,
            'categorizable_id' => $categorizable_id,
            'categorizable_type' => $categorizable_type,
            'price' => $request->input('wallet_price'),
            'final_price' => $request->input('wallet_price'),
            'final_price' => $request->input('wallet_price'),
        ]);


        $patient = Manager::select('id', 'wallet')->find($request->input('patient_id'));
        $wallet_reco = Wallet::create([
            'type' => 0,
            'branch_id' => $request->input('branch_wallet'),
            'wallet_receivable_id' => $id,
            'wallet_receivable_type' => 'App\Models\Patient\Patient',
            'invoice_id' => $invoice->id,
            'balance_before_tran' =>  $patient->wallet,
            'amount' =>  $request->input('wallet_price'),
            'date' => $request->input('wallet_date'),
            'note' => $request->input('balance_note'),
        ]);
        $patient->increment('wallet', $request->input('wallet_price'));
        $patient->save();

        session()->flash('success', 'The balance has been added successfully');
        return redirect()->back();
    }
    public function getUsersByType(Request $request, $type = null): \Illuminate\Http\JsonResponse
    {

        $query = Manager::query();
        if ($type !== null) {
            $query->where('type', $type);
        }
        $users = $query->paginate(10);
        return response()->json(['users' => $users]);
    }

}
