@extends('website.school.layouts.master', ['no_header' => true, 'no_transparent_header' => false])
@php

    $initialTab = 'pills-home'; // Replace 'pills-home' with the actual tab ID you want to set from the backend
    $tabs = [
        [
            'id' => 'pills-home',        // Unique ID for the tab
            'label' => 'بيانات الاجتماع',    // Tab label
        ],
        [
            'id' => 'pills-profile',
            'label' => 'محضر الاجتماع',
        ],
    ];

    $action = isset($item_val['id']) ? route('school_route.meetings.update', $item_val['id']) : route('school_route.meetings.store');
    $method = isset($item_val['id']) ? 'PUT' : 'POST';
    $text = isset($item_val['id']) ? 'تعديل' : 'إنشاء';
@endphp
@section('title', $text .' ' .$Committees_and_teams['title'])
@section('topbar', $text .' ' .$Committees_and_teams['title'])

<!-- css insert -->
@section('css')
    <link rel="stylesheet" href="https://fastly.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css"
          integrity="sha512-aD9ophpFQ61nFZP6hXYu4Q/b/USW7rpLCQLX6Bi0WJHXNO7Js/fUENpBQf/+P4NtpzNX0jSgR5zVvPOJp+W2Kg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{ URL::asset('css/hijry/bootstrap-datetimepicker.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/new_meeting.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/time_picker_custom_style.css') }}" />

@endsection

@section('fixedcontent')
    <!-- Your fixed content here -->
@endsection

<!-- content insert -->
@section('content')
    <div class="container-fluid px-4 px-md-5 py-3 py-md-4">
        <div class="row">
            <div class="row main_cot_bg p-2 align-items-center mb-4 main-color-bg text-s">
                <div class="col-12 col-xl-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-s2 padding-left-20 default-blue-bg-color"   aria-current="page">المدرسه</li>
                            <li class="breadcrumb-item text-s2 padding-left-20 default-blue-bg-color" >اللجان</li>
                            <li class="breadcrumb-item text-s2 padding-left-20 default-blue-bg-color" >{{$text}} {{$Committees_and_teams['title']}}</li>
                        </ol>
                    </nav>

                </div>
            </div>
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="custom-form">
                @csrf
                @if(isset($item_val['id']))
                    @method($method) <!-- Laravel's method spoofing for PUT request -->
                @endif
                @csrf <!-- CSRF Token for Laravel protection -->
                <div class="col-12 mb-3 mb-md-0">
                    <div class="main_cot_bg p-3 py-3 h-100">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            @foreach ($tabs as $tab)
                                <li class="nav-item tab-item" role="presentation">
                                    <button class="nav-link {{ $tab['id'] === $initialTab ? ' active tabcontent_active' : '' }}" id="{{ $tab['id'] }}-tab" data-bs-toggle="pill" data-bs-target="#{{ $tab['id'] }}" type="button" role="tab" aria-controls="{{ $tab['id'] }}" aria-selected="{{ $tab['id'] === $initialTab ? 'true' : 'false' }}">
                                        {{ $tab['label'] }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active  " id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="container form-container">
                                    <div class="card custom-card">
                                        <div class="Committees_and_teams_meetings_create_title">
                                            {{$text}} {{$Committees_and_teams['title']}}
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="card-body custom-card-body">

                                                    <input type="hidden" id="committees_and_teams_id" name="committees_and_teams_id" value="{{ request('Committees_id') ?? (  isset($item_val)  ?$item_val['committees_and_teams_id']:'')}}" class="  form-control">
                                                    <input type="hidden" id="status" name="status" value="@if(isset($item_val) && $item_val['status'] ){{$item_val['status']}} @endif" class="  form-control">

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3 align-self-center">
                                                                <label for="type" class="form-label bold_form_label "> نوع الاجتماع <span class="required-asterisk">*</span></label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select required  name="type" id="type" class="form-control custom-select js-example-basic-single  select2-hidden-accessible">
                                                                    <option value="">اختر نوع الاجتماع</option>
                                                                    @foreach ([1=>'طارئ', 0=>'دوري'] as $index=>$value)
                                                                        <option value="{{ $index }}"
                                                                                @isset($item_val)
                                                                                    @if($item_val['type'] == $index) selected @endif
                                                                            @endisset>
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                    <!-- Other options -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3 align-self-center ">
                                                                <label  for="committee" class="form-label bold_form_label "> تاريخ الاجتماع<span class="required-asterisk">*</span> </label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class=" input-group">

                                                                    <input name="start_date" type="text"
                                                                           class="hijri-date-input form-control border-left-0 clickable-item-pointer @error('start_date') is-invalid @enderror"
                                                                           placeholder="  تاريخ الاجتماع"   value="{{ isset($item_val) ? $item_val['start_date']: ''}}" required>
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text"> <img class="platform_icon" alt="school"
                                                                                                            src="{{ URL::asset('img/icons/calendar.svg') }}"> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3 align-self-center ">
                                                                <label  for="committee" class="form-label bold_form_label " >عنوان  الاجتماع <span class="required-asterisk">*</span> </label>
                                                            </div>
                                                            <div class="col-md-9">

                                                                <input   required type="text" id="title"  name="title" value="{{ isset($item_val)  ?$item_val['title']:''}}" class="form-control">

                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="  form-group">
                                                        <div class="row">
                                                            <div class="col-md-3 align-self-center ">
                                                                <label  for="committee" class="form-label bold_form_label ">موعد الاجتماع<span class="required-asterisk">*</span> </label>
                                                            </div>
                                                            <div class="col-md-9">


                                                                <div class=" input-group">

                                                                    <input name="start_time" type="text"
                                                                           class="form-control timepicker border-left-0 clickable-item-pointer @error('start_time') is-invalid @enderror"
                                                                           placeholder=" وقت الاجتماع"  value="{{ isset($item_val) ? $item_val['start_time']: ''}}" required>
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <img class="platform_icon" alt="school"   src="{{ URL::asset('img/icons/clock.svg') }}">
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                    </div>


                                                        </div>
                                                    </div>


                                                    <div class="  form-group">
                                                        <div class="row">
                                                            <div class="col-md-3 align-self-center ">
                                                                <label  for="committee" class="form-label bold_form_label ">مكان  الاجتماع<span class="required-asterisk">*</span> </label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" name="location" class="form-control" required  value="{{ isset($item_val) ?$item_val['location']:''}}">
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="  form-group">
                                                        <div class="row">
                                                            <div class="col-md-3 align-self-center ">
                                                                <label  for="committee" class="form-label bold_form_label "> الفصل الدراسي <span class="required-asterisk">*</span>   </label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text"  required name="Semester" value="{{ isset($item_val) ? $item_val['Semester']: ''}}" class="  form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Add more form fields here -->

                                                    <div class=" form-group padding-top-50" >
                                                        <div class="row">
                                                            <div class=" col col-md-6">
                                                                <button  type="submit" class=" meetings_button_next_wi   btn btn-default custom-reset-button">إنهاء</button>
                                                            </div>
                                                            <div class=" col col-md-6">
                                                                <button id="nextButton" type="button" class=" meetings_button_next btn btn-primary custom-submit-button">التالي</button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade  " id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <!-- Second tab content goes here -->
                                <div class="container form-container">
                                    <div class="card custom-card">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div  class="Committees_and_teams_meetings_create_title ">
                                                    {{$text}} {{$Committees_and_teams['title']}}
                                                </div>
                                            </div>
                                            <div class="col-md-3 float-end">
                                                <button  type="submit" class=" Save_as_draft col-md-3 float-end btn btn-primary custom-submit-button">

                                                    <img class="me-3" width="24px" src="{{ URL::asset('img/icons/save.svg') }}"
                                                         alt="" />
                                                    <span>حفظ كمسوده</span>
                                                </button>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12" >
                                                <div class="card-body custom-card-body">

                                                    <div class="  form-group">
                                                        <div class="row">
                                                            <div class="col-md-2 align-self-center ">
                                                                <label  for="committee" class="form-label bold_form_label ">   الفئه المستهدفه </label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <select  name="Target_group" id="Target_group" class="form-control custom-select js-example-basic-single  select2-hidden-accessible ">
                                                                    <option value="">اختر نوع الفئه</option>
                                                                    @foreach ([1=>'المصريين', 2=>'الاجانب'] as $index=>$value)
                                                                        <option value="{{ $index }}"
                                                                                @isset($item_val)
                                                                                    @if($item_val['Target_group'] == $index) selected @endif
                                                                            @endisset >
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                    <!-- Other options -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="meeting_id" id="meeting_id" value="{{ isset($item_val)  ?$item_val['id']:''}}">


                                                    <div class="  form-group Number_of_attendees22">
                                                        <div class="row">
                                                            <div class="col-md-2 align-self-center ">
                                                                <label  for="committee" class="form-label bold_form_label "> عدد الحاضرين    </label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <select  id="Number_of_attendees" name="Number_of_attendees" class="form-control custom-select js-example-basic-single  select2-hidden-accessible">
                                                                    <option value="">عدد الحاضرين</option>
                                                                    @foreach ([5, 10, 15, 20, 30,40,50] as $value)
                                                                        <option value="{{ $value }}"
                                                                                @isset($item_val)
                                                                                    @if($item_val['Number_of_attendees'] == $value) selected @endif @endisset >
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                    <!-- Other options -->
                                                                </select>

                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="  form-group meeting_agenda">
                                                        <div class="row" id="container_of_all_meeting_agenda" >
                                                            <label  for="committee" class="form-label bold_form_label ">    جدول اعمال الاجتماع  </label>
                                                            @if((is_array($item_val['meeting_agenda']) && !empty($item_val['meeting_agenda'])))
                                                                @foreach  ($item_val['meeting_agenda'] as $key => $agenda)

                                                                    <div class="row add_meeting_agenda_div "   >
                                                                        <div class="col-md-9 add-padding-bottom ">
                                                                            <div class="input-group">
                                                                                <label for="name1" class="add_meeting_agenda_span_num align-self-center  side_number_div ">  {{ $key+1 }} </label>
                                                                                <input type="text" autocomplete="off"  name="meeting_agenda_item[]" class="form-control" value="{{ $agenda['Item'] }}">
                                                                                <input type="hidden" name="meeting_agenda_id[]" class="form-control" value="{{ $agenda['id'] }}">

                                                                            </div>

                                                                        </div>
                                                                        <div class="col-md-3  align-self-center  add_or_delete_button_meeting"  >
                                                                            @if(!$loop->first)
                                                                            <a href="#" onclick="delete_parentElement(this,'add_meeting_agenda_div')"  >
                                                                                <img    class="  plus_minus_class " alt="school" src="{{ URL::asset('img/website/data/delete.PNG') }}">
                                                                            </a>
                                                                            @endif
                                                                            <a href="#" onclick="add_meeting_agenda()" class="add_meeting_agenda_class_add"  >
                                                                                <img    class="  plus_minus_class " alt="school" src="{{ URL::asset('img/website/data/add.PNG') }}">
                                                                            </a>


                                                                        </div>

                                                                    </div>

                                                                @endforeach
                                                            @else

                                                                <div  id="container_of_all_meeting_agenda">    </div>
                                                            @endif

                                                        </div>
                                                    </div>


                                                    <div class="  form-group meeting_recommendations ">
                                                        <div class="row meeting_recommendations_header_div ">
                                                            <div class="col-md-2 meeting_recommendations_table"  >التوصيه</div>
                                                            <div class="col-md-2 meeting_recommendations_table"    >الجهه المكلفه بالتنفيذ</div>
                                                            <div class="col-md-2 meeting_recommendations_table "    >مده التنفيذ</div>
                                                            <div class="col-md-2 meeting_recommendations_table "     >الجهه التابعه للتنفيذ</div>
                                                        </div>
                                                        <div class="row" id="container_of_all_add_meeting_recommendations_finished"  >
                                                            @if((is_array($item_val['meeting_recommendations']) && !empty($item_val['meeting_recommendations'])))
                                                                @foreach ($item_val['meeting_recommendations']   as $key => $recommendation)
                                                                    @if ($recommendation['status'] ==1)


                                                                        <div class="row add_meeting_recommendations_finished_div ">
                                                                            <input type="hidden" name="recommendation_id[]" class="form-control" value="{{ $recommendation['id'] }}">

                                                                            <div class="input-group">
                                                                                <label for="name1" class="align-self-center add-padding-bottom side_number_div "> {{ $key+1 }} </label>

                                                                                <div class="col-md-2 add-padding-bottom meeting_recommendations_table  "  >
                                                                                    <input type="text" autocomplete="off" name="recommendation_item[]" class="form-control"  value="{{ $recommendation['Item'] }}">
                                                                                </div>
                                                                                <div class="col-md-2 add-padding-bottom   meeting_recommendations_table "  >
                                                                                    <input type="text" autocomplete="off" name="entity_responsible_implementation[]" class="form-control"  value="{{ $recommendation['entity_responsible_implementation'] }}">
                                                                                </div>
                                                                                <div class="col-md-2 add-padding-bottom meeting_recommendations_table "  >
                                                                                    <input type="text" autocomplete="off" name="Implementation_period[]" class="form-control"  value="{{ $recommendation['Implementation_period'] }}">
                                                                                </div>
                                                                                <div class="col-md-2 add-padding-bottom meeting_recommendations_table "  >
                                                                                    <input type="text" autocomplete="off" name="entity_responsible_implementation_related[]" class="form-control"  value="{{ $recommendation['entity_responsible_implementation_related'] }}" >
                                                                                </div>
                                                                                <div class="col-md-2  align-self-center add_or_delete_button_meeting ">
                                                                                    <a href="#" onclick=" delete_parentElement(this,'add_meeting_recommendations_finished_div')"  >
                                                                                        <img    class="  plus_minus_class " alt="school" src="{{ URL::asset('img/website/data/delete.PNG') }}">
                                                                                    </a>
                                                                                    <a href="#" onclick="add_meeting_recommendations_finished()" class="add_meeting_recommendations_finished_class_add"  >
                                                                                        <img    class="  plus_minus_class " alt="school" src="{{ URL::asset('img/website/data/add.PNG') }}">
                                                                                    </a>


                                                                                </div>


                                                                            </div>
                                                                        </div>



                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <div  id="container_of_all_add_meeting_recommendations_finished">    </div>


                                                            @endif
                                                        </div>
                                                    </div>



                                                    <div class="  form-group meeting_recommendations_not ">
                                                        <div class="row"  >
                                                            <div class="col-md-3 add-padding-bottom meeting_recommendations_not_side_div ">
                                                                <label  for="committee" class="form-label  meeting_recommendations_not_side_title  ">    ما  لم ينفذ من  التوصيات واسباب عدم التنفيذ  </label>
                                                            </div>
                                                            <div class="col-md-9 add-padding-bottom " id="container_of_all_meeting_recommendations_not" >

                                                                @if((is_array($item_val['meeting_recommendations']) && !empty($item_val['meeting_recommendations'])))
                                                                    @foreach  ($item_val['meeting_recommendations'] as $key => $recommendation_val)
                                                                        @if ($recommendation_val['status'] == 0)
                                                                            <div class="row add_meeting_recommendations_not_div "   >
                                                                                <div class="col-md-9 add-padding-bottom">
                                                                                    <input type="text" autocomplete="off"  name="meeting_recommendations_not_completed[]" class="form-control"
                                                                                           value="{{ $recommendation_val['Item'] }}">
                                                                                </div>
                                                                                <div class="col-md-3  align-self-center add_or_delete_button_meeting  ">
                                                                                    <a href="#" onclick=" delete_parentElement(this,'add_meeting_recommendations_not_div')"  >
                                                                                        <img    class="  plus_minus_class " alt="school" src="{{ URL::asset('img/website/data/delete.PNG') }}">
                                                                                    </a>
                                                                                    <a href="#" onclick="add_meeting_recommendations_not()" class="add_meeting_recommendations_not_class_add"  >
                                                                                        <img    class="  plus_minus_class " alt="school" src="{{ URL::asset('img/website/data/add.PNG') }}">
                                                                                    </a>


                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                @else

                                                                    <div  id="container_of_all_meeting_recommendations_not">    </div>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="  form-group end_time ">
                                                        <div class="row">
                                                            <div class="col-md-3 align-self-center ">
                                                                <label  for="committee" class="form-label bold_form_label ">  موعد انتهاء الاجتماع  </label>
                                                            </div>
                                                            <div class=" input-group">

                                                                <input name="end_time" type="text"
                                                                       class="form-control  timepicker border-left-0 clickable-item-pointer @error('end_time') is-invalid @enderror"
                                                                       placeholder=" وقت انتهاء الاجتماع"  value="{{ isset($item_val) ? $item_val['end_time']: ''}}"  >
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text"> <img class="platform_icon" alt="school"
                                                                                                        src="{{ URL::asset('img/icons/clock.svg') }}"> </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <!-- Repeat for other fields with appropriate classes -->

                                                    <div class="row form-group padding-top-50"  >
                                                        <div class="col col-md-6">
                                                            <button id="prevButton"  type="button" class=" meetings_button_next_wi btn btn-default custom-reset-button">السابق</button>
                                                        </div>
                                                        <div class=" col col-md-6">
                                                            <button   type="submit" class=" meetings_button_next   float-end btn btn-primary custom-submit-button">حفظ وانهاء </button>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>


@endsection

<!-- js insert -->
@section('js')
    <script src="{{ URL::asset('js/hijry/bootstrap-hijri-datepicker.js') }}"></script>

    {{-- swiper --}}
    <script src="https://fastly.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <!-- select 2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"
            integrity="sha512-4MvcHwcbqXKUHB6Lx3Zb5CEAVoE9u84qN+ZSMM6s7z8IeJriExrV3ND5zRze9mxNlABJ6k864P/Vl8m0Sd3DtQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- jquery ui datepicker -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <script>

        $(function() {
            $(".hijri-date-input").hijriDatePicker({
                locale: "ar-sa",
                format: "YYYY-MM-DD",
                hijriFormat:"iYYYY-iMM-iDD",
                dayViewHeaderFormat: "MMMM YYYY",
                hijriDayViewHeaderFormat: "iMMMM iYYYY",
                showSwitcher: true,
                allowInputToggle: true,
                showTodayButton: false,
                useCurrent: true,
                isRTL: true,
                keepOpen: false,
                debug: false,
                showClear: false,
                showClose: false
            });
        });
        /** indicator on hijri date **/
        var indicator_on_hijri_date =  new Date(document.getElementsByClassName("hijri-date-input")[0].value).getFullYear();
        if (indicator_on_hijri_date < 2000 ){
            $(".hijri-date-input").hijriDatePicker({
                hijri: true
            });
        }

         $(document).ready(function() {
            $('.js-example-basic-single').select2();
            // //hide search
            // $('.select2-no-search').select2({
            //     minimumResultsForSearch: -1
            // });
            $('#pills-profile-tab').on('click', function(e) {
                var isValid = true;
                $('#pills-home input').each(function() {
                    if (!this.checkValidity()) {
                        isValid = false;
                        $(this).addClass('is-invalid'); // Add error class for styling
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault(); // Prevent switching to tab2
                    e.stopPropagation();
                $('#pills-home-tab').tab('show');
                    return false;
                }
            });
            // Remove the 'is-invalid' class when the user corrects the input
            $('#pills-home input').on('input change', function() {
                if (this.checkValidity()) {
                    $(this).removeClass('is-invalid');
                }
            });
            // Function to go to the next tab
            $('#nextButton').click(function() {
                $('.nav-pills .active').parent().next('li').find('button').trigger('click');
            });

             // Function to go to the previous tab
            $('#prevButton').click(function() {
                $('.nav-pills .active').parent().prev('li').find('button').trigger('click');
            });
        });

        $(document).ready(function() {
            add_meeting_agenda_first_element();
            add_meeting_agenda();
            add_meeting_recommendations_not();
            add_meeting_recommendations_finished();
        });

        function add_meeting_agenda(){
            if(typeof event != "undefined")
            {
                event.preventDefault();
            }
            var datacount=  $(".add_meeting_agenda_div").length+1
            var newElement=   `
                                <div   class=" row add_meeting_agenda_div"  >
                                   <div class="col-md-9 add-padding-bottom">
                                   <div class="input-group">
                                       <label for="name1" class="add_meeting_agenda_span_num align-self-center  side_number_div ">   ${datacount} </label>
                                       <input type="text"  autocomplete="off" name="meeting_agenda_item[]" class="form-control input_meeting_agenda_item " value="">
                                   </div>
                                   </div>
                                   <div class="col-md-3  align-self-center   add_or_delete_button_meeting "   >
                                       <a href="#" onclick="delete_parentElement(this,'add_meeting_agenda_div')"  >
                                           <img    class="  plus_minus_class " alt="school" src="{{ URL::asset('img/website/data/delete.PNG') }}">
                                       </a>
                                       <a href="#" onclick="add_meeting_agenda()" class="add_meeting_agenda_class_add"   >
                                           <img    class="  plus_minus_class " alt="school" src="{{ URL::asset('img/website/data/add.PNG') }}">
                                       </a>
                                   </div>
                               </div>` ;


            $('#container_of_all_meeting_agenda').append(newElement);
            let add_meeting_agenda_class_add_elements = document.querySelectorAll('.add_meeting_agenda_class_add');

            Remove_all_but_the_last_element(add_meeting_agenda_class_add_elements);

        }


        function add_meeting_agenda_first_element(){
            if(typeof event != "undefined")
            {
                event.preventDefault();
            }
            var datacount=  $(".add_meeting_agenda_div").length+1
            var newElement=   `<div   class=" row add_meeting_agenda_div"  >
                                   <div class="col-md-9 add-padding-bottom">
                                   <div class="input-group">
                                       <label for="name1" class="add_meeting_agenda_span_num align-self-center  side_number_div ">   ${datacount} </label>
                                       <input type="text"  autocomplete="off" name="meeting_agenda_item[]" class="form-control input_meeting_agenda_item " value="">
                                   </div>
                                   </div>  </div>` ;


            $('#container_of_all_meeting_agenda').append(newElement);
            let add_meeting_agenda_class_add_elements = document.querySelectorAll('.add_meeting_agenda_class_add');

            Remove_all_but_the_last_element(add_meeting_agenda_class_add_elements);

        }


        function add_meeting_recommendations_not(){
            if(typeof event != "undefined")
            {
                event.preventDefault();
            }
            var datacount=  $(".add_meeting_recommendations_not_div").length+1
            var newElement=   ` <div   class=" row add_meeting_recommendations_not_div"  >

                <div class="col-md-9 add-padding-bottom">
                <input type="text"  autocomplete="off" name="meeting_recommendations_not_completed[]" class="form-control meeting_recommendations_not_completed " value="">
                </div>

                <div class="col-md-3  align-self-center   add_or_delete_button_meeting "  >
                <a href="#" onclick="delete_parentElement(this,'add_meeting_recommendations_not_div')"  >
                   <img    class="  plus_minus_class " alt="school" src="{{ URL::asset('img/website/data/delete.PNG') }}">
                </a>

                <a href="#" onclick="add_meeting_recommendations_not()" class="add_meeting_recommendations_not_class_add"   >
                   <img    class="  plus_minus_class " alt="school" src="{{ URL::asset('img/website/data/add.PNG') }}">
                </a>
                </div>
                </div>` ;


            $('#container_of_all_meeting_recommendations_not').append(newElement);
            let meeting_recommendations_not_elements = document.querySelectorAll('.add_meeting_recommendations_not_class_add');

            Remove_all_but_the_last_element(meeting_recommendations_not_elements);

        }

        function add_meeting_recommendations_finished(){

            if(typeof event != "undefined")
            {
                event.preventDefault();
            }
            var datacount=  $(".add_meeting_recommendations_finished_div").length+1
            var newElement=   `
    <div class="row add_meeting_recommendations_finished_div ">

                                <div class="input-group">
                                           <label for="name1" class="align-self-center add-padding-bottom side_number_div "> ${datacount} </label>

                                           <div class="col-md-2 add-padding-bottom meeting_recommendations_table  "  >
                                               <input type="text" autocomplete="off" name="recommendation_item[]" class="form-control" value="">
                                           </div>
                                           <div class="col-md-2 add-padding-bottom   meeting_recommendations_table "  >
                                               <input type="text" autocomplete="off" name="entity_responsible_implementation[]" class="form-control" value="">
                                           </div>
                                           <div class="col-md-2 add-padding-bottom meeting_recommendations_table "  >
                                               <input type="text" autocomplete="off" name="Implementation_period[]" class="form-control" value="">
                                           </div>
                                           <div class="col-md-2 add-padding-bottom meeting_recommendations_table "  >
                                               <input type="text" autocomplete="off" name="entity_responsible_implementation_related[]" class="form-control" value="">
                                           </div>
                                            <div class="col-md-2  align-self-center  add_or_delete_button_meeting "   >
                                                <a href="#" onclick=" delete_parentElement(this,'add_meeting_recommendations_finished_div')"  >
                                                    <img    class="  plus_minus_class " alt="school" src="{{ URL::asset('img/website/data/delete.PNG') }}">
                                                </a>
                                                <a href="#" onclick="add_meeting_recommendations_finished()" class="add_meeting_recommendations_finished_class_add"  >
                                                    <img    class="  plus_minus_class " alt="school" src="{{ URL::asset('img/website/data/add.PNG') }}">
                                                </a>


                                            </div>


                                </div>
                           </div>` ;


            $('#container_of_all_add_meeting_recommendations_finished').append(newElement);
            let meeting_recommendations_finished_class_add_elements = document.querySelectorAll('.add_meeting_recommendations_finished_class_add');

            Remove_all_but_the_last_element(meeting_recommendations_finished_class_add_elements);

        }

        function Remove_all_but_the_last_element(vla){
            // Remove all but the last element
            if (vla.length > 1) {
                for (let i = 0; i < vla.length - 1; i++) {
                    vla[i].remove();
                }
            }
        }

        function delete_parentElement(this_this,div_class){
             event.preventDefault();

            var datacount=  $("."+div_class).length
            let vale="."+div_class+" .add_or_delete_button_meeting";
           let add_or_delete_button_meeting = document.querySelectorAll(vale);
             if (add_or_delete_button_meeting.length > 1) {
                if (datacount > 1){
                    this_this.parentElement.parentElement.remove();
                }

            } else {
                console.log('No elements found with the class . ');
            }





        }

        // Call saveInputValues() before switching tabs
        // Call restoreInputValues() after switching back to the tab

        var full_height_width_slider_swiper_weekly = new Swiper(".full_height_width_slider_swiper_weekly", {
            pagination: {
                el: ".swiper-pagination",
            },
            autoplay: {
                delay: 5000,
            },
            loop: true,
            touchEventsTarget: 'container',
        });


    </script>

    <script src="{{ URL::asset('js/meetings/meetings_custom_js.js') }}"></script>

@endsection
