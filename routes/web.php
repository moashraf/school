<?php

use App\Http\Controllers\admins\RoleController;
use App\Http\Controllers\admins\UsersController;
use App\Http\Controllers\admins\DestinationsController;
use App\Http\Controllers\admins\OrderController;
use App\Http\Controllers\Basic\Video_tutorialCont;
use App\Http\Controllers\Branch\Appointment\Rate_appointment;
use App\Http\Controllers\Branch\AppointmentController;
use App\Http\Controllers\Branch\Accounting\Acc_accountCont;
use App\Http\Controllers\Branch\Accounting\Acc_cost_centerCont;
use App\Http\Controllers\Branch\Accounting\Acc_taxCont;
use App\Http\Controllers\Branch\Accounting\Acc_treasuryCont;
use App\Http\Controllers\Branch\Accounting\Acc_entryCont;
use App\Http\Controllers\Branch\Accounting\Acc_paymentCont;
use App\Http\Controllers\Branch\Accounting\Financial_yearCont;
use App\Http\Controllers\Branch\Accounting\Pos\Acc_posCont;
use App\Http\Controllers\Branch\Accounting\Pos\Acc_pos_machineCont;
use App\Http\Controllers\Branch\Accounting\Pos\Acc_pos_sessionCont;
use App\Http\Controllers\Branch\Accounting\QuotationCont;
use App\Http\Controllers\Branch\Accounting\WorkOrderCont;
use App\Http\Controllers\Branch\Cats\Airport;
use App\Http\Controllers\Branch\Cats\Branch_cat;
use App\Http\Controllers\Branch\Cats\Vehicle_companyController;
use App\Http\Controllers\Branch\Cats\Vehicle_tripController;
use App\Http\Controllers\Branch\Cats\VehicleController;
use App\Http\Controllers\Branch\Cats\Vehicle_trackingController;
use App\Http\Controllers\Branch\Cats\Vehicle_operationController;
use App\Http\Controllers\Branch\Cats\Cost_cats;
use App\Http\Controllers\Branch\Cats\Coupon_cat;
use App\Http\Controllers\Branch\Cats\CurrencyCont;
use App\Http\Controllers\Branch\Cats\Debtor_cat;
use App\Http\Controllers\Branch\Cats\Expenses_item;
use App\Http\Controllers\Branch\Cats\Oper_placecat;
use App\Http\Controllers\Branch\Cats\Package_offerController;
use App\Http\Controllers\Branch\Cats\PackageController;
use App\Http\Controllers\Branch\Cats\SliderController;
use App\Http\Controllers\Branch\Cats\Specialty_cat;
use App\Http\Controllers\Branch\Cats\TagController;
use App\Http\Controllers\Branch\Cats\Trip_offerController;
use App\Http\Controllers\Branch\Cats\TripController;
use App\Http\Controllers\Branch\Cats\Unit_cat;
use App\Http\Controllers\Branch\Cats\Unit_chainController;
use App\Http\Controllers\Branch\Cats\Unit_offer;
use App\Http\Controllers\Branch\Cats\VisaController;
use App\Http\Controllers\Branch\ComplaintController;
use App\Http\Controllers\Branch\Inventory\Inventory_item;
use App\Http\Controllers\Branch\Inventory\Inventory_warehouseCont;
use App\Http\Controllers\Branch\Inventory\InventoryController;
use App\Http\Controllers\Branch\InvoiceController;
use App\Http\Controllers\Branch\LabController;
use App\Http\Controllers\Branch\Operation\Op_fileController;
use App\Http\Controllers\Branch\OperationController;
use App\Http\Controllers\Branch\RateController;
use App\Http\Controllers\Cat\ArticleController;
use App\Http\Controllers\Cat\Room\Meal_catCont;
use App\Http\Controllers\Cat\Room\Room_catCont;
use App\Http\Controllers\Cat\Room\Room_view_catCont;
use App\Http\Controllers\Cat\Room\unit_featureCont;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Public_controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\School\HomepageController;
use App\Http\Controllers\School\ClientAuthCont;
use App\Http\Controllers\Location\RegionController;
use App\Http\Controllers\On_request\On_requestController;
use App\Http\Controllers\On_request\Client_formController;
use App\Http\Controllers\OutsideReports\SocialReports;
use App\Http\Controllers\Package\Include_exclude;
use App\Http\Controllers\Patient\Cats\Ask_for_cat;
use App\Http\Controllers\School\Management\Edu_departmentCont;
use App\Http\Controllers\School\Management\Edu_department_officeCont;
use App\Http\Controllers\School\Management\School_eventCont;
use App\Http\Controllers\Patient\Cats\Cancel_reason;
use App\Http\Controllers\Patient\Cats\Examination_cat;
use App\Http\Controllers\Patient\Cats\Market_priceCont;
use App\Http\Controllers\Patient\Cats\Medicine_cat;
use App\Http\Controllers\Patient\Cats\Pulses_machine;
use App\Http\Controllers\Patient\Cats\Resource_cat;
use App\Http\Controllers\Patient\Cats\Service_inv_cat;
use App\Http\Controllers\Branch\Product\ProductCont;
use App\Http\Controllers\Branch\Product\Product_unitCont;
use App\Http\Controllers\Hr\User_edu_qualificationCont;
use App\Http\Controllers\Hr\User_job_titleCont;
use App\Http\Controllers\Patient\Cats\Treatment_cat;
use App\Http\Controllers\Patient\Disease_drawsController;
use App\Http\Controllers\Patient\DiseaseController;
use App\Http\Controllers\Patient\MedicineController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\PulseController;
use App\Http\Controllers\Patient\Service_package;
use App\Http\Controllers\Patient\SessionController;
use App\Http\Controllers\Patient\TreatmentController;
use App\Http\Controllers\Prox_setting;
use App\Http\Controllers\Vehicle\Vehicle_catController;
use App\Http\Controllers\Vehicle\Vehicle_featureCont;
use App\Http\Controllers\School\DestinationController;
use App\Http\Controllers\School\PackageWebController;
use App\Http\Controllers\School\OrderWebController;
use App\Http\Controllers\School\ProfileController;
use App\Http\Controllers\School\TagWebController;
use App\Http\Controllers\School\TranspWebController;
use App\Http\Controllers\School\TripWebController;
use App\Http\Controllers\School\AirlineWebController;
use App\Http\Controllers\School\DashboardCont;
use App\Http\Controllers\CommitteesAndTeamsMeetingsController;
use App\Http\Controllers\MeetingRecommendationsController;
use App\Http\Controllers\MeetingAgendaController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\School\RoadmapCont;
use App\Http\Controllers\School\Teacher\School_jobsCont;
use App\Http\Controllers\School\Teacher\Teacher_specialityCont;
use App\Http\Controllers\School\UnitWebController;
use App\Http\Controllers\School\VisaWebController;
use App\Http\Controllers\School\AssignmentClassificationController;
use App\Http\Controllers\School\AssignmentUsersController;
use App\Http\Controllers\School\AssignmentItemsController;
use App\Http\Controllers\School\CommitteTeamTasksController;
use App\Http\Controllers\School\CommitteTeamMembersController;
use App\Http\Controllers\School\SemestersController;
use App\Http\Controllers\School\SingleAssignmentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




//Website Homepahe
Route::get('/', [HomepageController::class, 'index'])->name('website_homepage');

//----- important if we want to show the webview -----
/* Route::get('/', function () {
     return view('auth.login');
 })->name('landing'); */


Route::get('/test', [Controller::class, 'test']);

/*
|--------------------------------------------------------------------------
| User interface (landing, login, register, profile)
|--------------------------------------------------------------------------
*/

// Route::prefix('land')->name('school_route.')->group(function () {

Route::name('school_route.')->group(function () {

     Route::middleware(['guest:school'])->group(function () {

          // ------------- Client Auth -------------
          // ---- login ----
          Route::get('/login', [ClientAuthCont::class, 'login'])->name('login')->middleware("throttle:10,2"); //it will send 10 request per 2 minute
          Route::post('/login_otp', [ClientAuthCont::class, 'login_otp'])->name('login_otp')->middleware("throttle:10,2");
          Route::get('/enter_otp', [ClientAuthCont::class, 'enter_otp'])->name('enter_otp')->middleware("throttle:10,2");;
          Route::post('/login_sub', [ClientAuthCont::class, 'login_sub'])->name('login_sub')->middleware("throttle:10,2");
          Route::post('/check_otp_login', [ClientAuthCont::class, 'check_otp_login'])->name('check_otp_login')->middleware("throttle:10,2");

          // ---- register ----
          Route::get('/register', [ClientAuthCont::class, 'register'])->name('register')->middleware("throttle:10,2");
          Route::post('/register_store', [ClientAuthCont::class, 'register_store'])->name('register_store')->middleware("throttle:10,2");
          Route::post('/check_otp', [ClientAuthCont::class, 'check_otp'])->name('check_otp')->middleware("throttle:10,2");

          // ---- forget password ----
          Route::get('/forget_password', [ClientAuthCont::class, 'forget_password'])->name('forget_password');
          Route::post('/check_email_forget_password', [ClientAuthCont::class, 'check_email_forget_password'])->name('check_email_forget_password')->middleware("throttle:10,2");
          Route::post('/check_phone_forget_password', [ClientAuthCont::class, 'check_phone_forget_password'])->name('check_phone_forget_password')->middleware("throttle:10,2");
          Route::post('/check_otp_forget_password', [ClientAuthCont::class, 'check_otp_forget_password'])->name('check_otp_forget_password')->middleware("throttle:10,2");
          Route::get('/new_page_forget_password', [ClientAuthCont::class, 'new_page_forget_password'])->name('new_page_forget_password')->middleware("throttle:10,2");
          Route::post('/new_page_forget_password_store', [ClientAuthCont::class, 'new_page_forget_password_store'])->name('new_page_forget_password_store')->middleware("throttle:10,2");

          //----------------------


     });

     //-------------- authictaction routes --------------

     Route::middleware(['auth:school', 'activeclientotp'])->group(function () {

          // ------- roadmap  ---------
          Route::group(
               [
                    'prefix' => 'roadmap',
               ],
               function () {

                    Route::get('first/{type?}', [RoadmapCont::class, 'roadmap'])->name('roadmap');

                    Route::get('/second/{type?}', [RoadmapCont::class, 'second_roadmap'])->name('second_roadmap');

                    Route::post('/choose_school', [RoadmapCont::class, 'choose_school_store'])->name('choose_school_store');

                    // -------- 3- general information --------
                    Route::post('/roadmap_general_info_store', [RoadmapCont::class, 'roadmap_general_info_store'])->name('roadmap_general_info_store');
                    Route::get('/fetch_department_office/{id}', [RoadmapCont::class, 'fetch_department_office'])->name('fetch_department_office');

                    // -------- 4- facilities --------
                    Route::post('/roadmap_facilities_store', [RoadmapCont::class, 'roadmap_facilities_store'])->name('roadmap_facilities_store');

                    // -------- 5- students --------
                    Route::post('/roadmap_students_store', [RoadmapCont::class, 'roadmap_students_store'])->name('roadmap_students_store');
                    Route::post('/roadmap_students_next_store', [RoadmapCont::class, 'roadmap_students_next_store'])->name('roadmap_students_next_store');

                    // -------- 6- entsab --------
                    Route::post('/roadmap_entsab_store', [RoadmapCont::class, 'roadmap_entsab_store'])->name('roadmap_entsab_store');

                    // -------- 7- students --------
                    Route::post('/roadmap_teachers_store', [RoadmapCont::class, 'roadmap_teachers_store'])->name('roadmap_teachers_store');
                    Route::post('/roadmap_teachers_update_speciality', [RoadmapCont::class, 'roadmap_teachers_update_speciality'])->name('roadmap_teachers_update_speciality');
                    Route::post('/roadmap_teachers_next_store', [RoadmapCont::class, 'roadmap_teachers_next_store'])->name('roadmap_teachers_next_store');


                    // -------- 8- Administrator --------
                    Route::post('/roadmap_administrator_store', [RoadmapCont::class, 'roadmap_administrator_store'])->name('roadmap_administrator_store');
                    Route::post('/roadmap_administrator_update_speciality', [RoadmapCont::class, 'roadmap_administrator_update_speciality'])->name('roadmap_administrator_update_speciality');
                    Route::post('/roadmap_administrator_delete_speciality', [RoadmapCont::class, 'roadmap_administrator_delete_speciality'])->name('roadmap_administrator_delete_speciality');
                    Route::post('/roadmap_administrator_next_store', [RoadmapCont::class, 'roadmap_administrator_next_store'])->name('roadmap_administrator_next_store');


                    // -------- 9- general information --------
                    Route::post('/roadmap_other_info_store', [RoadmapCont::class, 'roadmap_other_info_store'])->name('roadmap_other_info_store');

                    // -------- 10- finish --------
                    Route::post('/roadmap_finish_store', [RoadmapCont::class, 'roadmap_finish_store'])->name('roadmap_finish_store');
               }
          );



          // ------ school ------
          Route::group(
               [
                    'prefix' => 'school',
                    'middleware' => ['RoadMapScool']
               ],
               function () {

                    // ---------- basic ---------

                    // Choose a school at first
                    Route::get('/choose_school', [DashboardCont::class, 'choose_school'])->name('choose_school');
                    Route::post('/choose_school_start_store', [DashboardCont::class, 'choose_school_start_store'])->name('choose_school_start_store');
                    Route::resource('/Committees_and_teams_meetings',CommitteesAndTeamsMeetingsController::class);
                    Route::resource('/meeting_recommendations',MeetingRecommendationsController::class);
                    Route::resource('/meeting_agenda',MeetingAgendaController::class);
                    Route::resource('/meetings',MeetingController::class);
                    Route::resource('/assignment_classifications', AssignmentClassificationController::class);
                    Route::resource('/assignment_items', AssignmentItemsController::class);
                    Route::resource('/assignment_users', AssignmentUsersController::class);
                    Route::resource('/committe_team_tasks', CommitteTeamTasksController::class);
                    Route::resource('/committe_team_members', CommitteTeamMembersController::class);
                    Route::resource('/semesters', SemestersController::class);
                    Route::resource('/single_assignment', SingleAssignmentController::class);

                   Route::get('/meetings/{id}/download-pdf', [MeetingController::class,'downloadPDF'])->name('meetings_downloadPDF');
                    Route::get('/meetings/{id}/print-pdf', [MeetingController::class,'PrintPDF'])->name('meetings_PrintPDF');

                    // Change school
                    Route::post('/change_school_sidebar', [DashboardCont::class, 'change_school_sidebar'])->name('change_school_sidebar');

                    // Dashboard
                    Route::get('/dashboard', [DashboardCont::class, 'dashboard'])->name('dashboard');

                 //  Route::get('/new_meeting', [DashboardCont::class, 'new_meeting'])->name('new_meeting');

                    //ajax for calander
                    Route::get('/calander_tasks_ajax/{month}/{year}', [DashboardCont::class, 'calander_tasks_ajax'])->name('calander_tasks_ajax');
               }
          );

          Route::post('logout', [ClientAuthCont::class, 'logout'])->name('logout');
     });

     //-------------- other non authictaction routes --------------

     // send email form
     Route::post('send_email_from', [HomepageController::class, 'send_email_from'])->name('send_email_from')->middleware("throttle:10,2");
     // articales
     Route::get('articles', [HomepageController::class, 'articles'])->name('articles');
     Route::get('article/{slug}', [HomepageController::class, 'article_show'])->name('article_show');
});



// -----------------------------------------
//for Tripo system
//multi languages
Route::group(
     [
          'prefix' => LaravelLocalization::setLocale(),
          'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
     ],
     function () {

          Route::prefix('prox')->name('sett.')->group(function () {

               //for the guest
               Route::get('/', function () {
                    return view('auth.login');
               })->middleware('guest');

               Auth::routes();

               //for the auth user
               Route::middleware('auth', 'activeuser')->group(function () {

                    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
                    Route::get('/chatboat/{query}', [HomeController::class, 'chatboat'])->name('chatboat');

                    Route::resource('/admin', UsersController::class);
                    Route::get('/edit_profile_user', [UsersController::class, 'edit_profile_user'])->name('edit_profile_user');
                    Route::PUT('/edit_profile_user_store', [UsersController::class, 'edit_profile_user_store'])->name('edit_profile_user_store');

                    //note for the user in the dashboard
                    Route::PATCH('/note_ajax', [UsersController::class, 'note_ajax'])->name('ad_note_ajax');

                    Route::get('/createcityajax/{id}', [UsersController::class, 'createcityajax'])->name('createcityajax');

                    /*
          |--------------------------------------------------------------------------
          | settings (users, roles, perimsstion) {{ route('sett.createcityajax') }}
          |--------------------------------------------------------------------------
          */
                    Route::group(['prefix' => 'hr', 'middleware' => ['role:Super-admin|Hr-manager|Hr-worker']], function () {
                         Route::resource('/admin', UsersController::class);
                         Route::get('/allstatcs', [UsersController::class, 'allstatcs'])->name('user_allstatcs');
                         Route::resource('/role', RoleController::class);
                         Route::get('/attendance/{worker_id}/{date?}', [UsersController::class, 'attendance'])->name('hr_attendance');
                         Route::get('/edit_attendance/{id}', [UsersController::class, 'edit_attendance'])->name('hr_edit_attendance');
                         Route::PUT('/edit_attendance_insert/{id}', [UsersController::class, 'edit_attendance_insert'])->name('hr_edit_attendance_insert');

                         Route::get('/user/deleteImage/{id}', [UsersController::class, 'deleteImage'])->name('user_deleteImage');

                         Route::resource('/user_edu_qualification', User_edu_qualificationCont::class);
                         Route::resource('/user_job_title', User_job_titleCont::class);
                    });

                    /*
          |--------------------------------------------------------------------------
          | settings (users, roles, perimsstion) {{ route('sett.createcityajax') }}
          |--------------------------------------------------------------------------
          */
                    Route::group(['prefix' => 'ad'], function () {
                         Route::resource('/options', Prox_setting::class);

                         Route::resource('/slider', SliderController::class);
                         Route::resource('/video_tutorial', Video_tutorialCont::class);

                         Route::resource('/tag', TagController::class);

                         Route::resource('/on_request', On_requestController::class);
                         Route::PUT('/on_request_change_status/{id}', [On_requestController::class, 'on_request_change_status'])->name('on_request_change_status');
                         Route::post('/update_request_item/{id}', [On_requestController::class, 'update_request_item'])->name('update_request_item');

                         Route::resource('/client_form', Client_formController::class);
                         Route::post('/client_form_status/{id}', [Client_formController::class, 'client_form_status'])->name('client_form_status');


                         Route::resource('/resourcecat', Resource_cat::class);

                         // school
                         Route::resource('/edu_department', Edu_departmentCont::class);
                         Route::resource('/edu_department_office', Edu_department_officeCont::class);
                         Route::resource('/school_event', School_EventCont::class);

                         // teacher
                         Route::resource('/teacher_speciality', Teacher_specialityCont::class);
                         Route::resource('/school_job', School_jobsCont::class);


                         Route::resource('/couponcat', Coupon_cat::class);
                         Route::get('/google', [SocialReports::class, 'google'])->name('google');
                         Route::get('/livereport', [Prox_setting::class, 'livereport'])->name('livereport');
                         Route::get('/service_report', [Prox_setting::class, 'service_report'])->name('service_report');
                    });





                    //destinations cont
                    Route::resource('/destinations', DestinationsController::class);
                    Route::get('/destinations/deleteImage/{id}', [DestinationsController::class, 'deleteImage'])->name('deleteImage_des');

                    Route::get('/fetch_destination_country/{id}', [DestinationsController::class, 'fetch_destination_country'])->name('fetch_destination_country');



                    Route::get('/unit/deleteImage/{id}', [Unit_cat::class, 'deleteImage'])->name('deleteImage');


                    Route::resource('/article', ArticleController::class);
                    Route::get('/articles/deleteImage/{id}', [ArticleController::class, 'deleteImage'])->name('deleteImage_article');


                    /*

          |--------------------------------------------------------------------------
          | Patient operations
          |--------------------------------------------------------------------------
          */

                    Route::prefix('pat')->group(function () {

                         //fetch city depends on country
                         Route::get('/patient/create_askfor_ajax/{id}', [PatientController::class, 'create_askfor_ajax'])->name('pat_create_askfor_ajax')->middleware(['role:Super-admin|Doctor|Branch-manager|Receptionist|Call-center']);

                         //fetch city depends on country
                         Route::get('/patient/createcityajax/{id}', [PatientController::class, 'createcityajax'])->name('pat_createcityajax');

                         Route::get('/patient/createregionajax/{id}', [PatientController::class, 'createregionajax'])->name('pat_createregionajax');

                         //search engine for patients
                         Route::get('/users/users_search/{search_query}', [PatientController::class, 'patient_search'])->name('pat_patient_search');

                         //update note ajax
                         Route::PATCH('/users/note_ajax/{id}', [PatientController::class, 'note_ajax'])->name('pat_note_ajax')->middleware(['role:Super-admin|Branch-manager|Receptionist|Call-center|Monitor|Marketing|Data-entry|Hotel-worker|Hotel-manager|Transport-manager|Transport-worker|Driver|Airline-manager|Airline-worker|Visa-manager|Visa-worker|Trip-manager|Trip-worker|Package-manager|Package-worker|Sales-manager|Sales-worker|Operation-manager']);

                         //total patient statistics
                         Route::get('/users/allstatcs/{branch?}/{from?}/{to?}', [PatientController::class, 'allstatcs'])->name('pat_allstatcs')->middleware(['role:Super-admin']);

                         //send sms to the pattient
                         Route::get('/sms_form_profile/{id}', [PatientController::class, 'sms_form_profile'])->name('pat_sms_form_profile')->middleware(['role:Super-admin|Branch-manager|Receptionist|Call-center|Monitor|Marketing|Data-entry|Hotel-manager|Transport-manager|Driver|Airline-manager|Visa-manager|Trip-manager|Package-manager|Sales-manager|Operation-manager']);

                         //Patient
                         Route::resource('/managers', PatientController::class);


                         //slight edit
                         Route::PATCH('/pat_slight_edit', [PatientController::class, 'pat_slight_edit'])->name('pat_slight_edit')->middleware(['role:Super-admin|Branch-manager|Receptionist|Call-center|Monitor|Marketing|Data-entry|Hotel-manager|Transport-manager|Driver|Airline-manager|Visa-manager|Trip-manager|Package-manager|Sales-manager|Operation-manage']);

                         //get all patients by filters
                         Route::get('/my_patients', [PatientController::class, 'my_patients'])->name('pat_my_patients')->middleware(['role:Super-admin|Branch-manager|Receptionist|Doctor|Call-center|Monitor|Marketing|Data-entry|Call-center|Hotel-worker|Hotel-manager|Transport-manager|Transport-worker|Driver|Airline-manager|Airline-worker|Visa-manager|Visa-worker|Trip-manager|Package-manager|Operation-manager|Operation-worker']);

                         //get all patients by filters
                         Route::get('/show_all', [PatientController::class, 'show_all_patients'])->name('pat_show_all_patients')->middleware(['role:Super-admin|Branch-manager|Receptionist|Call-center|Monitor|Marketing|Data-entry|Hotel-worker|Hotel-manager|Transport-manager|Transport-worker|Driver|Airline-manager|Airline-worker|Visa-manager|Visa-worker|Trip-manager|Trip-worker|Package-manager|Package-worker|Sales-manager|Sales-worker|Operation-manager|Operation-worker']);

                         Route::get('/sms_done', [PatientController::class, 'sms_done'])->name('pat_sms_done')->middleware(['role:Super-admin|Branch-manager|Receptionist|Call-center|Monitor|Marketing|Data-entry|Hotel-manager|Transport-manager|Driver|Airline-manager|Visa-manager|Trip-manager|Package-manager|Sales-manager|Operation-manager']);

                         //slight edit
                         Route::PATCH('/machine_rec_edit/{id}', [PulseController::class, 'machine_rec_edit'])->name('pul_machine_rec_edit')->middleware(['role:Super-admin|Branch-manager|Doctor']);
                         Route::get('/pulses_machines_ajax/{branch_id?}', [PulseController::class, 'pulses_machines_ajax'])->name('pulses_machines_ajax')->middleware(['role:Super-admin|Doctor|Branch-manager|Receptionist']);
                    });

                    Route::prefix('rate')->group(function () {
                         // send sms
                         Route::get('/marketing/send_sms', [Rate_appointment::class, 'send_sms'])->name('send_sms');
                         Route::post('/marketing/send_sms_store', [Rate_appointment::class, 'send_sms_store'])->name('send_sms_store');

                         // send email
                         Route::get('/marketing/send_email', [Rate_appointment::class, 'send_email'])->name('send_email');
                         Route::post('/marketing/send_email_store', [Rate_appointment::class, 'send_email_store'])->name('send_email_store');
                    });
               });
          });
     }
);
