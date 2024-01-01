<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\Models\Admin\Attendance;
use App\Models\Admin\Worker_record;
use App\Models\Branch\Appointment;
use App\Models\Branch\Branch;
use App\Models\Invoice\Invoice;
use App\Models\location\City;
use App\Models\location\Country;
use App\Models\Patient\Specialty_cat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Models\Branch\Booking;
use App\Models\Hr\User_edu_qualification;
use App\Models\Hr\User_image;
use App\Models\Hr\User_job_title;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users = User::select('id', 'name', 'email')->get();

        $users = User::select(['id', 'first_name', 'second_name', 'avatar', 'started_work', 'deactivate'])->get();

        return view('admins.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::orderBy('fav', 'DESC')->get();
        $roles = Role::all();
        $job_titles = User_job_title::all();
        $edu_qualifications = User_edu_qualification::all();

        return view('admins.create', compact('countries', 'roles', 'job_titles', 'edu_qualifications'));
    }

    //for select input ajax to send the cities beasd on the given country
    public function createcityajax($id)
    {
        return City::where('country_id', $id)->get();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        // the valdiation is in (app/requests/UsersRequest)

        //insert img
        if ($request->hasFile('avatar')) {
            $file_extension = request()->avatar->getClientOriginalExtension();
            $file_name = $request->input('first_name') . time() . '.' . $file_extension;
            $path = 'img/useravatar';
            $request->avatar->move($path, $file_name);
        } else {
            $file_name = 'default-pp.png';
        }

        $code = generateRandomString(6);

        $user = User::create([
            'code' => "WOK-" . $code,
            'avatar' => $file_name,
            'first_name' => $request->input('first_name'),
            'second_name' => $request->input('second_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'gendar' => $request->input('gendar'),
            'birthday' => $request->input('birthday'),
            'country' => $request->input('country'),
            'city' => $request->input('city'),
            'phone_number' => $request->input('phone_number'),
            'sec_phone_number' => $request->input('sec_phone_number'),
            'started_work' => $request->input('started_work'),
            'note' => $request->input('note'),

            'job_title_id' => $request->input('job_title_id'),
            'user_edu_qualification_id' => $request->input('user_edu_qualification_id'),
            'identity_doc_number' => $request->input('identity_doc_number'),
            'address' => $request->input('address'),
            'marital_status' => $request->input('marital_status'),
            'religion' => $request->input('religion'),
            'driving_license' => $request->input('driving_license'),
        ]);


        // insert in table Image user
        if ($request->hasFile('all_imgs')) {
            $images = $request->file('all_imgs');
            foreach ($images as $key => $image) {
                $file_extension = $image->getClientOriginalExtension();
                $file_name = $code . $key . 'user' . time() . '.' . $file_extension;
                $path = 'img/useravatar/attachments';
                $image->move($path, $file_name);
                User_image::create([
                    'user_id' => $user->id,
                    'img' => $file_name,
                ]);
            }
        }

        //for inserting the role
        foreach ($request->input('role') as $item) {
            $user->assignRole($item);
        }

        session()->flash('success', 'The user has been created');
        return redirect()->route('sett.admin.index');
    }

    //doctor records
    public function create_doctor_record(Request $request)
    {

        $this->validate($request, [
            'doctor_id' => ['required', 'exists:users,id'],
            'start' => ['required', 'date', 'date_format:Y-m-d'],
            'note' => 'max:250',
        ]);

        $worker_record = Worker_record::create([
            'doctor_id' => $request->input('doctor_id'),
            'type' => $request->input('type'),
            'start' => $request->input('start'),
            'amount' => $request->input('amount'),
            'note' => $request->input('note'),
        ]);

        session()->flash('success', 'The record has been created');
        return redirect()->back();
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


    public function allstatcs(Request $request)
    {

        if (!empty($request->input('specialty'))) {
            $specialty = $request->input('specialty');
        } else {
            $specialty = 'all';
        }
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


        // ----------------------

        $worker_total = User::select('id');

        if ($specialty !== "all") {
            $worker_total = $worker_total->where('specialty_id', $specialty);
        }

        if ($branch !== "all") {
            $worker_total = $worker_total->where('branch_id', $branch);
        }

        $worker_total = $worker_total->count();

        // ----------------------

        return view('admins/allstatcs', compact('worker_total', 'branch_worker', 'specialty_cat', 'specialty', 'branches', 'branch', 'creator', 'doctor', 'creator_month', 'doctor_month', 'confirmation', 'confirmation_month', 'accountant', 'accountant_month', 'from', 'to'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $user = User::with(['cityuser' => function ($q) {
            $q->select('id', 'name');
        }])->find($id);

        $roles = Role::select('id', 'name')->get();
        $userRole = $user->roles->pluck('id')->all();
        $countries = Country::orderBy('fav', 'DESC')->get();
        $job_titles = User_job_title::all();
        $edu_qualifications = User_edu_qualification::all();

        return view('admins.edit', compact('user', 'roles', 'userRole', 'countries', 'job_titles', 'edu_qualifications'));
    }


    public function edit_profile_user()
    {
        $user_id = Auth::id();
        $user = User::with(['cityuser' => function ($q) {
            $q->select('id', 'name');
        }])->find($user_id);

        $countries = Country::orderBy('fav', 'DESC')->get();

        return view('admins.edit_profile', compact('user', 'countries'));
    }


    public function edit_profile_user_store(UsersRequest $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);

        $user->first_name = $request->input('first_name');
        $user->second_name = $request->input('second_name');
        $user->gendar = $request->input('gendar');
        $user->birthday = $request->input('birthday');
        $user->country = $request->input('country');
        $user->city = $request->input('city');
        $user->phone_number = $request->input('phone_number');
        $user->sec_phone_number = $request->input('sec_phone_number');
        $user->started_work = $request->input('started_work');
        $user->note = $request->input('note');

        if (!empty($request->input('newpassword'))) {
            $user->password = bcrypt($request->input('newpassword'));
        }

        //insert img
        if ($request->hasFile('avatar')) {

            if ($user->avatar !== "default-pp.png") {
                //to remove the old avatar and also keep the default img
                $imagePath = public_path('img/useravatar/' . $user->avatar);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $file_extension = request()->avatar->getClientOriginalExtension();
            $file_name = $request->input('first_name') . time() . '.' . $file_extension;
            $path = 'img/useravatar';
            $request->avatar->move($path, $file_name);

            $user->avatar = $file_name; //new img file name
        } else {
            $file_name = request()->avatar;
        }

        $user->save();

        session()->flash('success', 'The user has been updated');
        return redirect()->back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(UsersRequest $request, $id)
    {
        $user = User::find($id);

        $user->first_name = $request->input('first_name');
        $user->second_name = $request->input('second_name');
        $user->email = $request->input('email');
        $user->gendar = $request->input('gendar');
        $user->birthday = $request->input('birthday');
        $user->country = $request->input('country');
        $user->city = $request->input('city');
        $user->phone_number = $request->input('phone_number');
        $user->sec_phone_number = $request->input('sec_phone_number');
        $user->started_work = $request->input('started_work');
        $user->deactivate = $request->input('deactivate');
        $user->note = $request->input('note');

        $user->job_title_id = $request->input('job_title_id');
        $user->user_edu_qualification_id = $request->input('user_edu_qualification_id');
        $user->identity_doc_number = $request->input('identity_doc_number');
        $user->address = $request->input('address');
        $user->marital_status = $request->input('marital_status');
        $user->religion = $request->input('religion');
        $user->driving_license = $request->input('driving_license');

        if (!empty($request->input('newpassword'))) {
            $user->password = bcrypt($request->input('newpassword'));
        }

        //insert img
        if ($request->hasFile('avatar')) {

            if ($user->avatar !== "default-pp.png") {
                //to remove the old avatar and also keep the default img
                $imagePath = public_path('img/useravatar/' . $user->avatar);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $file_extension = request()->avatar->getClientOriginalExtension();
            $file_name = $request->input('first_name') . time() . '.' . $file_extension;
            $path = 'img/useravatar';
            $request->avatar->move($path, $file_name);

            $user->avatar = $file_name; //new img file name
        } else {
            $file_name = request()->avatar;
        }

        $user->save();


        // insert in table Image user
        if ($request->hasFile('all_imgs')) {
            $images = $request->file('all_imgs');
            foreach ($images as $key => $image) {
                $file_extension = $image->getClientOriginalExtension();
                $file_name = $user->code . $key . 'user' . time() . '.' . $file_extension;
                $path = 'img/useravatar/attachments';
                $image->move($path, $file_name);
                User_image::create([
                    'user_id' => $user->id,
                    'img' => $file_name,
                ]);
            }
        }

        //for inserting the role
        $user->roles()->detach();
        foreach ($request->input('role') as $item) {
            $user->assignRole($item);
        }

        session()->flash('success', 'The user has been updated');
        return redirect()->route('sett.admin.index');
    }


    public function note_ajax(Request $request)
    {

        $id = Auth::id();

        $user = User::find($id);
        $user->note = $request->input('query');

        $user->save();
    }

    public function deleteImage($id)
    {
        $img = User_image::find($id);
        $imagePath = public_path('img/useravatar/attachments' . $img->destination_images);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $img->delete();
        session()->flash('success', 'The image has been deleted ');
        return back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::find($request->user_id)->delete();

        session()->flash('success', 'The user has been deleted');
        return redirect()->route('sett.admin.index');
    }

    //------------

}
