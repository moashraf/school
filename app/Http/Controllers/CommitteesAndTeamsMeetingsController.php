<?php

namespace App\Http\Controllers;

use App\Models\Basic\Video_tutorial;
use App\Models\Branch\Slider;
use App\Models\CommitteTeamMembers;
use App\Models\CommitteTeamTasks;
use App\Models\School\Meetings\Committees_and_teams;
use App\Models\School\Meetings\meeting_recommendations;
use App\Models\School\Meetings\meetings;
use App\Models\School\School;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommitteesAndTeamsMeetingsController extends Controller
{
    use HasFactory, SoftDeletes;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $current_school = Auth::guard('school')->user()->current_working_school_id;
        $school = School::find($current_school);
        $Committees_and_teams = Committees_and_teams::where('school_id', $school->id)
            ->with(['get_meetings' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->get();
            Carbon::setLocale('ar');
        //Carbon::now()->translatedFormat('l j F Y H:i:s');
        $today_date_ar = Carbon::now()->translatedFormat('j F Y');


        $video_tutorial = Video_tutorial::where('type', 2)->first();



        return view('website.school.Committees_and_teams_meetings',
            compact('current_school', 'school', 'today_date_ar','Committees_and_teams','video_tutorial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {


        $current_school = Auth::guard('school')->user()->current_working_school_id;
        $current_user_id = Auth::guard('school')->user()->id;
        $school = School::find($current_school);
        $Committees_and_teams = Committees_and_teams::where('school_id',$school->id)->with('get_meetings')->get();
        Carbon::setLocale('ar');
        //Carbon::now()->translatedFormat('l j F Y H:i:s');
        $today_date_ar = Carbon::now()->translatedFormat('j F Y');
        $video_tutorial = Video_tutorial::where('type', 2)->first();


        return view('website.school.new_committee',
            compact('current_school', 'school','current_user_id', 'today_date_ar','Committees_and_teams','video_tutorial'));



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
            'title' => 'required',
            'classification' => 'required',
        ]);

        $form = Committees_and_teams::create([
            'author'=>$request->input('author'),
            'title'=>$request->input('title'),
            'school_id'=>$request->input('school_id'),
            'goals'=>$request->input('school_id'),
            'committe_formation_rules'=>$request->input('school_id'),
            'classification'=>$request->input('classification'),
        ]);
        $this->addCommiteAndTeamMembers($form->id,$request);
        $this->addCommiteAndTeamTasks($form->id,$request);
        return redirect()->route('school_route.Committees_and_teams_meetings.index')->with('success', 'تم انشاء اللجنة/ الفرقه بنجاح');
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $current_school = Auth::guard('school')->user()->current_working_school_id;
        $current_user_id = Auth::guard('school')->user()->id;
        $Committees_and_teams = Committees_and_teams::where('school_id',$school->id)->with('get_meetings')->get();

        $school = School::find($current_school);


        $sliders = Slider::where('type', 1)->get();
        $item_val = Committees_and_teams::find($id);
        $item_val = $item_val->toArray();
        // video tutorial
        $video_tutorial = Video_tutorial::where('type', 2)->first();
        return view('website.school.new_committee',
            compact('current_school', 'school','current_user_id','Committees_and_teams','item_val', 'sliders', 'video_tutorial'));
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
            'title' => 'required',
            'classification' => 'required',
        ]);

        $commite_and_team = Committees_and_teams::findOrFail($id);
        $commite_and_team->author = $request->input('author');
        $commite_and_team->title = $request->input('title');
        $commite_and_team->school_id = $request->input('school_id');
        $commite_and_team->classification = $request->input('classification');
        $commite_and_team->committe_formation_rules = $request->input('committe_formation_rules');
        $commite_and_team->goals = $request->input('goals');
        $commite_and_team->save();
        CommitteTeamMembers::where('committe_team_id', $id)->delete();
        CommitteTeamTasks::where('committe_team_id', $id)->delete();
        $this->addCommiteAndTeamMembers($id,$request);
        $this->addCommiteAndTeamTasks($id,$request);
        return redirect()->route('school_route.Committees_and_teams_meetings.index')->with('success', 'تم تعديل اللجنه/الفرقه بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $committee_and_team = Committees_and_teams::find($id);

        if ($committee_and_team) {
            $committee_and_team->delete();
            return redirect()->back()->with('success', 'لقد تم حذف اللجنة/الفرقه بتجاح');
        }
        return redirect()->back()->with('error', 'عذرا نواجه مشكله في حذف هذا اللجنة/الفرقه');
    }
    public function addCommiteAndTeamTasks($committe_id,$request)
    {
        if ($request->input('user_id') !=null) {
            foreach ($request->input('user_id') as $index=>$item) {
                if ($item){
                    $committeTeamMember = new CommitteTeamMembers();
                    $committeTeamMember->committe_team_id = $committe_id;
                    $committeTeamMember->user_id =$item;
                    $committeTeamMember->assigned_role =$request->input('assigned_role')[$index];
                    $committeTeamMember->save();
                }
            }
        }

    }
    public function addCommiteAndTeamMembers($commite_id,$request)
    {
        if ($request->input('task_description') !=null) {
            foreach ($request->input('task_description') as $index=>$item) {
                if ($item){
                    $committeTeamTask = new CommitteTeamTasks();
                    $committeTeamTask->committe_team_id = $commite_id;
                    $committeTeamTask->task_description =$item;
                    $committeTeamTask->save();
                }
            }
        }
    }
}
