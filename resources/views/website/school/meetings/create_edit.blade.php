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

        <div class="page_top_nevg">
            <a href="#">اجتماعات اللجان و الفرق</a> <i class="fas fa-caret-left"></i>
            <a href="#">اللجان</a>  <i class="fas fa-caret-left"></i>
            <a href="#">   {{$text}} {{$Committees_and_teams['title']}}  </a>
        </div>

        <div style="height: 60px;"></div>


        <div class="sprint5_container">
            <!-- <h1>sprint 5</h1> -->
            <div class="nav_tabs nav-tabs-main  ">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    @foreach ($tabs as $index => $tab)
                        <li class="nav-item" role="presentation  ">
                            <button class="nav-link  <?= ($index + 0) === 0 ? 'active' : ''; ?>"
                                    id="pills-tab<?= $index ?>" data-bs-toggle="pill"
                                    data-bs-target="#pills-content<?= $index + 0 ?>"
                                    type="button"
                                    role="tab"
                                    aria-controls="pills-content<?= $index ?>"
                                    aria-selected="<?= ($index + 0) === 0 ? 'true' : 'false'; ?>">
                                {{ $tab['label']  }}
                            </button>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content tab-content-main  " id="pills-tabContent">
                    @foreach ($tabs as $index => $classification)

                        <div class="tab-pane fade <?= ($index + 0) === 0 ? 'show active' : ''; ?>" id="pills-content<?= $index + 0 ?>" role="tabpanel"
                             aria-labelledby="pills-tab<?= $index ?>">
                            @if ($classification['id']  == 'pills-home')

                                    <div >
                                        <div class="container-fluid px-4 px-md-5">
                                            <div class="container d-flex flex-column gap-4 justify-content-center align-items-center">
                                                <div style="font-weight: 700; font-size: 22px; line-height: 24.55px; color:#000000; padding:50px;">
                                                    {{$text}} {{$Committees_and_teams['title']}}
                                                </div>
                                                <form id="myform" class="myform" style="width: 100%;" method="POST" action="{{ $action }}"
                                                      enctype="multipart/form-data" novalidate="novalidate"   data-select2-id="select2-data-myform">
                                                    @csrf
                                                    @if(isset($item_val['id']))
                                                        @method($method)
                                                        <!-- Laravel's method spoofing for PUT request -->
                                                    @endif
                                                    @csrf <!-- CSRF Token for Laravel protection -->

                                                    <input type="hidden" id="committees_and_teams_id" name="committees_and_teams_id" value="{{ request('Committees_id') ?? (  isset($item_val)  ?$item_val['committees_and_teams_id']:'')}}" class="  form-control">
                                                    <input type="hidden" id="status" name="status" value="@if(isset($item_val) && $item_val['status'] ){{$item_val['status']}} @endif" class="  form-control">

                                                    <div data-select2-id="select2-data-49-ixb3">
                                                        <div class="d-flex flex-column">
                                                            <div class="row mb-4" data-select2-id="select2-data-23-4h1t">
                                                                <div class="col-12 col-md-2 col-xl-2">
                                                                    <label class="form-label mb-2 mt-3 mb-xl-0" style="color:#000000; font-size:17px; line-height:16px; font-weight:700;">نوع الاجتماع <span class=" text-red fs-6">*</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-12 mb-4 col-md-4 col-xl-4" data-select2-id="select2-data-22-2tyf">
                                                                    <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="type"  required="required" tabindex="-1" aria-hidden="true" data-select2-id="select2-data-9-r77p">
                                                                        <option value="" disabled="" selected="selected" data-select2-id="select2-data-11-bi6e" selected >نوع الاجتماع</option>

                                                                         @foreach ([1=>'طارئ', 0=>'دوري'] as $index=>$value)
                                                                            <option value="{{ $index }}"
                                                                                    @isset($item_val)
                                                                                        @if($item_val['type'] == $index) selected @endif
                                                                                @endisset>
                                                                                {{ $value }}</option>
                                                                        @endforeach


                                                                    </select>
                                                                    <div id="school_level-js_error_valid"></div>
                                                                </div>
                                                            </div>
                                                            <div class="row" style="margin-bottom: 3rem;">
                                                                <div class="col-12 col-md-2 col-xl-2 align-self-center">
                                                                    <label class="form-label mb-2 mb-xl-0" style="font-weight: 700; font-size:17px; line-height:16px; color:#000000;">تاريخ الاجتماع <span class=" text-red fs-6">*</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-12 col-md-4 col-xl-4">
                                                                    <div class=" input-group">
                                                                        <input name="start_date" type="text" class="hijri-date-input form-control border-left-0 clickable-item-pointer "
                                                                               placeholder="تاريخ الاجتماع" value="" required="required" required autocomplete="off" date-text="  تاريخ الاجتماع">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <img class="platform_icon" alt="school" src="https://factoryfiy.com/img/icons/calendar.svg">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row" style="margin-bottom: 3rem;">
                                                                <div class="col-12 col-md-2 col-xl-2 align-self-center">
                                                                    <label class="form-label mb-2 mb-xl-0" style="font-weight: 700; font-size:17px; line-height:16px; color:#000000;">موعد الاجتماع <span class=" text-red fs-6">*</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-12 col-md-4 col-xl-4">
                                                                    <div class=" input-group">
                                                                        <input name="start_time" type="text" class="form-control timepicker border-left-0 clickable-item-pointer" placeholder=" وقت الاجتماع" value="" required="" autocomplete="off" date-text=" وقت الاجتماع">
                                                                        <div class="timepicker__wrapper timepicker__wrapper-full" id="tp_36" style="width: 546px; z-index: 1;">
                                                                            <div class="timepicker__hour">
                                                                                <p class="display_up_hour  timepicker__button timepicker__button__up ">10</p>
                                                                                <div class="timepicker__button timepicker__button__up">
                                                                                    <div></div>
                                                                                </div>
                                                                                <p class="display">9 <span class="bg_dot_data_timepicker" id="my-id">
                          <svg width="9" height="31" viewBox="0 0 9 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="4.5" cy="4.5" r="4.5" fill="#0A3A81"></circle>
                            <circle cx="4.5" cy="26.5" r="4.5" fill="#0A3A81"></circle>
                          </svg>
                        </span>
                                                                                </p>
                                                                                <div class="timepicker__button timepicker__button__down">
                                                                                    <div></div>
                                                                                </div>
                                                                                <p class="display_down_hour timepicker__button timepicker__button__down">8</p>
                                                                            </div>
                                                                            <div class="timepicker__minute">
                                                                                <p class="display_up_minute  timepicker__button timepicker__button__up ">55</p>
                                                                                <div class="timepicker__button timepicker__button__up">
                                                                                    <div></div>
                                                                                </div>
                                                                                <p class="display">54</p>
                                                                                <div class="timepicker__button timepicker__button__down">
                                                                                    <div></div>
                                                                                </div>
                                                                                <p class="display_down_minute timepicker__button timepicker__button__down">53</p>
                                                                            </div>
                                                                            <div class="timepicker__meridiem">
                                                                                <p class="display_up_meridiem  timepicker__button timepicker__button__up ">AM</p>
                                                                                <div class="timepicker__button timepicker__button__up">
                                                                                    <div></div>
                                                                                </div>
                                                                                <p class="display">am</p>
                                                                                <div class="timepicker__button timepicker__button__down">
                                                                                    <div></div>
                                                                                </div>
                                                                                <p class="display_down_meridiem timepicker__button timepicker__button__down">PM</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <img class="platform_icon" alt="school" src="https://factoryfiy.com/img/icons/clock.svg">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row" style="margin-bottom: 3rem;">
                                                                <div class="col-12 col-md-2 col-xl-2 align-self-center">
                                                                    <label class="form-label mb-2 mb-xl-0" style="font-weight: 700; font-size:17px; line-height:16px; color:#000000;">مكان الاجتماع <span class=" text-red fs-6">*</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-12 col-md-4 col-xl-4">
                                                                    <div class=" input-group">
                                                                        <input name="location" type="text" class="form-control border-left-0 clickable-item-pointer " placeholder="مكان الاجتماع" value="" required="" autocomplete="off" date-text="  تاريخ الاجتماع">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="d-flex justify-content-around mt-5">
                                                <button type="submit" class="end_btn mt-5 px-5 border_radius_5" style="width:15%; background-color: unset; border: 1px solid #EAB977; color:#0A3A81; font-size:14px; font-weight:700;">إنهاء</button>
                                                <button type="button" class="main_btn mt-5 px-5 border_radius_5" style="width:15%;" onclick="goToMeetingForm()">التالي</button>
                                            </div>
                                        </div>
                                        <script>

                                            function goToMeetingForm() {
                                                $('#pills-tab1').tab('show');
                                            }
                                        </script>
                                    </div>
                            @endif
                                @if ($classification['id']  == 'pills-profile')

                                    <div class="container-fluid px-4 px-md-5">
                                        <div class="container d-flex flex-column justify-content-center align-items-center gap-5">
                                            <div style="font-weight: 700; font-size: 22px; line-height: 24.55px; color:#000000; padding:50px;">
                                                {{$text}} {{$Committees_and_teams['title']}}
                                                <input type="hidden" name="meeting_id" id="meeting_id" value="{{ isset($item_val)  ?$item_val['id']:''}}">

                                            </div>
                                            <div class="d-flex flex-column gap-2" style="width: 100%;">
                                                <div class="row" data-select2-id="select2-data-23-4h1t">
                                                    <div class="col-12 col-md-2 col-xl-2">
                                                        <label class="form-label mb-2 mt-3 mb-xl-0"
                                                               style="color:#000000; font-size:17px; line-height:16px; font-weight:700;">الفئة المستهدفة
                                                        </label>
                                                    </div>
                                                    <div class="col-12 mb-4 col-md-4 col-xl-4" data-select2-id="select2-data-22-2tyf">
                                                        <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="Target_group" required=""
                                                                tabindex="-1" aria-hidden="true" data-select2-id="select2-data-9-r77p">
                                                            <option value="" disabled="" selected="" data-select2-id="select2-data-11-bi6e">الفئة المستهدفة</option>

                                                            @foreach ([1=>'المصريين', 2=>'الاجانب'] as $index=>$value)
                                                                <option value="{{ $index }}"
                                                                        @isset($item_val)
                                                                            @if($item_val['Target_group'] == $index) selected @endif
                                                                    @endisset >
                                                                    {{ $value }}</option>
                                                            @endforeach

                                                        </select>
                                                        <div id="school_level-js_error_valid"></div>
                                                    </div>
                                                </div>
                                                <div class="row" data-select2-id="select2-data-23-4h1t">
                                                    <div class="col-12 col-md-2 col-xl-2">
                                                        <label class="form-label mb-2 mt-3 mb-xl-0"
                                                               style="color:#000000; font-size:17px; line-height:16px; font-weight:700;">عدد الحاضرون
                                                        </label>
                                                    </div>
                                                    <div class="col-12 mb-4 col-md-4 col-xl-4" data-select2-id="select2-data-22-2tyf">
                                                        <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="Number_of_attendees"
                                                                required="" tabindex="-1" aria-hidden="true" data-select2-id="select2-data-9-r77p">
                                                            <option value="" disabled="" selected="" data-select2-id="select2-data-11-bi6e">عدد الحاضرون</option>
                                                            @foreach ([5, 10, 15, 20, 30,40,50] as $value)
                                                                <option value="{{ $value }}"
                                                                        @isset($item_val)
                                                                            @if($item_val['Number_of_attendees'] == $value) selected @endif @endisset >
                                                                    {{ $value }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div id="school_level-js_error_valid"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column gap-2" style="width: 100%;">
                                                <div style="font-size: 18px; line-height: 16px; font-weight:700;">جدول أعمال الاجتماع
                                                </div>
                                                <div id="dynamicFieldsContainer" class=" py-5 d-flex justify-content-start align-items-start"
                                                     style="width: 75%; transform: translateX(-10px);">
                                                    <div class="row gap-3" style="width:100%;">


                        @if((is_array($item_val['meeting_agenda']) && !empty($item_val['meeting_agenda'])))
                            @foreach  ($item_val['meeting_agenda'] as $key => $agenda)

                                <div class="col-12">
                                    <div class="row gap-0 align-items-center">
                                        <div class="col-1 number" style="width: 45px; font-size: 20px; font-weight: 400; line-height: 23px;"> {{ $key+1 }} </div>
                                        <div class="col-9">
                                            <input style="width: 100%; background: #F1F1F1;" name="meeting_agenda_item[]" type="text" class="form-control"
                                                   maxlength="100" value="" required="" autocomplete="off" value="{{ $agenda['Item'] }}"  >

                                             <input type="hidden" name="meeting_agenda_id[]" class="form-control" value="{{ $agenda['id'] }}">


                                        </div>
                                        <div class="col-2 d-flex gap-3">
                                            <i class="fa fa-minus-circle" style="color: #FF6347; font-size: 24px;" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @else
                            <div class="col-12">
                                <div class="row gap-0 align-items-center">
                                    <div class="col-1 number" style="width: 45px; font-size: 20px; font-weight: 400; line-height: 23px;">1</div>
                                    <div class="col-9">
                                        <input style="width: 100%; background: #F1F1F1;"  name="meeting_agenda_item[]" type="text" class="form-control"
                                               maxlength="100" value="" required="">
                                    </div>
                                    <div class="col-2 d-flex gap-3">
                                        <i class="fa fa-minus-circle" style="color: #FF6347; font-size: 24px;" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row g-4 align-items-center">
                                    <div class="col-1 number" style="width: 45px; font-size: 20px; font-weight: 400; line-height: 23px;">2</div>
                                    <div class="col-9">
                                        <input style="width: 100%; background: #F1F1F1;" name="meeting_agenda_item[]" type="text" class="form-control"
                                               maxlength="100" value="" required="">
                                    </div>
                                    <div class="col-2 d-flex gap-3">
                                        <i class="fa fa-minus-circle" style="color: #FF6347; font-size: 24px;" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row g-4 align-items-center">
                                    <div class="col-1 number" style="width: 45px; font-size: 20px; font-weight: 400; line-height: 23px;">3</div>
                                    <div class="col-9">
                                        <input style="width: 100%; background: #F1F1F1;" name="meeting_agenda_item[]" type="text" class="form-control"
                                               maxlength="100" value="" required="">
                                    </div>
                                    <div class="col-2 d-flex gap-3">
                                        <i class="fa fa-minus-circle" style="color: #FF6347; font-size: 24px;" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row g-4 align-items-center">
                                    <div class="col-1 number" style="width: 45px; font-size: 20px; font-weight: 400; line-height: 23px;">4</div>
                                    <div class="col-9">
                                        <input style="width: 100%; background: #F1F1F1;" name="meeting_agenda_item[]"  type="text" class="form-control"
                                               maxlength="100" value="" required="">
                                    </div>
                                    <div class="col-2 d-flex gap-3">
                                        <i class="fa fa-minus-circle" style="color: #FF6347; font-size: 24px;" aria-hidden="true"></i>
                                        <i class="fa fa-plus-circle" style="color: #1DAE6D; font-size: 24px;" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>

                        @endif



                                                    </div>
                                                </div>
                                                <script>
                                                    // Add this script to handle minus and plus icon clicks
                                                    document.getElementById('dynamicFieldsContainer').addEventListener('click', function (event) {
                                                        if (event.target.classList.contains('fa-minus-circle')) {
                                                            // Handle minus icon click
                                                            handleMinusIconClick(event.target);
                                                        } else if (event.target.classList.contains('fa-plus-circle')) {
                                                            // Handle plus icon click
                                                            handlePlusIconClick(event.target);
                                                        }
                                                    });

                                                    function handleMinusIconClick(minusIcon) {
                                                        // Find the corresponding row and remove it
                                                        var row = minusIcon.closest('.col-12');
                                                        var allRows = document.querySelectorAll('#dynamicFieldsContainer .row .col-12');
                                                        var isLastRow = row === document.querySelector('#dynamicFieldsContainer .row:last-child .col-12:last-child');

                                                        // Check if it's the only row
                                                        if (allRows.length > 1) {
                                                            row.remove();

                                                            // Renumber the remaining fields
                                                            renumberFields();

                                                            // Add plus circle to the new last row
                                                            if (isLastRow) {
                                                                addPlusCircleToLastRow();
                                                            }

                                                        } else {
                                                            // Optionally, you can add some feedback to the user that the last row cannot be removed.
                                                            console.log('Cannot remove the only row.');
                                                        }
                                                    }

                                                    function handlePlusIconClick(plusIcon) {
                                                        // Clone the last row
                                                        var lastRow = document.querySelector('#dynamicFieldsContainer .row:last-child .col-12:last-child');
                                                        var newRow = lastRow.cloneNode(true);

                                                        // Remove the plus circle from the cloned row
                                                        var clonedPlusIcon = lastRow.querySelector('.fa-plus-circle');
                                                        if (clonedPlusIcon) {
                                                            clonedPlusIcon.remove();
                                                        }

                                                        // Append the cloned row to the container
                                                        document.querySelector('#dynamicFieldsContainer .row').appendChild(newRow);

                                                        // Increment the number in the new row
                                                        var numberElement = newRow.querySelector('.number');
                                                        var number = parseInt(numberElement.textContent) + 1;
                                                        numberElement.textContent = number;

                                                    }

                                                    function renumberFields() {
                                                        // Get all rows and renumber them
                                                        var rows = document.querySelectorAll('#dynamicFieldsContainer .row');
                                                        rows.forEach(function (row, index) {
                                                            var numberElement = row.querySelector('.number');
                                                            numberElement.textContent = index;
                                                        });
                                                    }

                                                    function addPlusCircleToLastRow() {
                                                        var lastRow = document.querySelector('#dynamicFieldsContainer .row:last-child .col-12:last-child');
                                                        var plusCircle = document.createElement('i');
                                                        plusCircle.className = 'fa fa-plus-circle';
                                                        plusCircle.style = 'color: #1DAE6D; font-size: 24px;';
                                                        lastRow.querySelector('.d-flex.gap-3').appendChild(plusCircle);
                                                    }
                                                </script>
                                                <div id="dynamicTableContainer" class="mt-3">
                                                    <!-- Start Header of table -->
                                                    <div class="mt-2" style="width: 100%;">
                                                        <!-- Start Header of table -->
                                                        <div class="row" style="color:#0A3A81; font-weight: 700; background-color: #EAB977; border-radius: 10px 10px 0px 0px; vertical-align:middle; text-align: center; align-items: center; min-height: 53px;">
                                                            <p class="col-1Point2" style="margin: 0px;"></p>
                                                            <p class="col-2Point4" style="margin: 0px;">التوصية</p>
                                                            <p class="col-2Point4" style="margin: 0px;">الجهة المكلفة بالتنفيذ</p>
                                                            <p class="col-2Point4" style="margin: 0px;">مدة التنفيذ</p>
                                                            <p class="col-2Point4" style="margin: 0px;">الجهة التابعة للتنفيذ</p>
                                                            <p class="col-1Point2" style="margin: 0px;"></p>
                                                        </div>
                                                        <!-- End Header of table -->

                                                        <!-- Start of Data Table -->
                                                        <div id="dynamicTableRow" class="lam_accordion_row row" style="overflow:hidden; border-bottom:0px !important;">
                                                            <div class="col-12">

                                                                @if((is_array($item_val['meeting_recommendations']) && !empty($item_val['meeting_recommendations'])))
                                                                    @foreach ($item_val['meeting_recommendations']   as $key => $recommendation)
                                                                        @if ($recommendation['status'] ==1)

                                                                            <input type="hidden" name="recommendation_id[]" class="form-control" value="{{ $recommendation['id'] }}">

                                                                            <div class="row py-3" style="text-align: center; align-items: center; min-height: 53px; border-bottom:1px solid #DEDEDE;">
                                                                                <p class="col-1Point2" style="margin: 0px; font-size:20px; line-height:16px; font-weight: 700;">  {{ $key+1 }} </p>
                                                                                <p class="col-2Point4" style="margin: 0px;">
                                                                                    <input style="width: 100%; background: #F1F1F1;"  name="recommendation_item[]" type="text" class="form-control" maxlength="100"  value="{{ $recommendation['Item'] }}" required=""></p>
                                                                                <p class="col-2Point4" style="margin: 0px;">
                                                                                    <input style="width: 100%; background: #F1F1F1;" name="entity_responsible_implementation[]" type="text" class="form-control" maxlength="100"  value="{{ $recommendation['entity_responsible_implementation'] }}" required=""></p>
                                                                                <p class="col-2Point4" style="margin: 0px;">
                                                                                    <input style="width: 100%; background: #F1F1F1;"  name="Implementation_period[]" type="text" class="form-control" maxlength="100" value="{{ $recommendation['Implementation_period'] }}"  required=""></p>
                                                                                <p class="col-2Point4" style="margin: 0px;">
                                                                                    <input style="width: 100%; background: #F1F1F1;"  name="entity_responsible_implementation_related[]" type="text" class="form-control" maxlength="100"   value="{{ $recommendation['entity_responsible_implementation_related'] }}" required=""></p>
                                                                                <p class="col-1Point2" style="margin: 0px; width:auto;">
                                                                                    <i class="fa fa-minus-circle" style="color: #FF6347; font-size: 24px;" aria-hidden="true"></i>
                                                                                </p>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <div class="row py-3" style="text-align: center; align-items: center; min-height: 53px; border-bottom:1px solid #DEDEDE;">
                                                                        <p class="col-1Point2" style="margin: 0px; font-size:20px; line-height:16px; font-weight: 700;">1</p>
                                                                        <p class="col-2Point4" style="margin: 0px;"><input style="width: 100%; background: #F1F1F1;" name="recommendation_item[]"  type="text" class="form-control" maxlength="100" value="" required=""></p>
                                                                        <p class="col-2Point4" style="margin: 0px;"><input style="width: 100%; background: #F1F1F1;" name="entity_responsible_implementation[]"  type="text" class="form-control" maxlength="100" value="" required=""></p>
                                                                        <p class="col-2Point4" style="margin: 0px;"><input style="width: 100%; background: #F1F1F1;" name="Implementation_period[]"  type="text" class="form-control" maxlength="100" value="" required=""></p>
                                                                        <p class="col-2Point4" style="margin: 0px;"><input style="width: 100%; background: #F1F1F1;" name="entity_responsible_implementation_related[]"  type="text" class="form-control" maxlength="100" value="" required=""></p>
                                                                        <p class="col-1Point2" style="margin: 0px; width:auto;">
                                                                            <i class="fa fa-minus-circle" style="color: #FF6347; font-size: 24px;" aria-hidden="true"></i>
                                                                        </p>
                                                                    </div>
                                                                    <div class="row py-3" style="text-align: center; align-items: center; min-height: 53px; border-bottom:1px solid #DEDEDE;">
                                                                        <p class="col-1Point2" style="margin: 0px; font-size:20px; line-height:16px; font-weight: 700;">2</p>
                                                                        <p class="col-2Point4" style="margin: 0px;"><input style="width: 100%; background: #F1F1F1;" name="recommendation_item[]" type="text" class="form-control" maxlength="100" value="" required=""></p>
                                                                        <p class="col-2Point4" style="margin: 0px;"><input style="width: 100%; background: #F1F1F1;" name="entity_responsible_implementation[]" type="text" class="form-control" maxlength="100" value="" required=""></p>
                                                                        <p class="col-2Point4" style="margin: 0px;"><input style="width: 100%; background: #F1F1F1;" name="Implementation_period[]" type="text" class="form-control" maxlength="100" value="" required=""></p>
                                                                        <p class="col-2Point4" style="margin: 0px;"><input style="width: 100%; background: #F1F1F1;" name="entity_responsible_implementation_related[]" type="text" class="form-control" maxlength="100" value="" required=""></p>
                                                                        <p class="col-1Point2" style="margin: 0px; width:auto;">
                                                                            <i class="fa fa-minus-circle" style="color: #FF6347; font-size: 24px;" aria-hidden="true"></i>
                                                                        </p>
                                                                    </div>
                                                                    <div class="row py-3" style="text-align: center; align-items: center; min-height: 53px; border-bottom:1px solid #DEDEDE;">
                                                                        <p class="col-1Point2" style="margin: 0px; font-size:20px; line-height:16px; font-weight: 700;">3</p>
                                                                        <p class="col-2Point4" style="margin: 0px;"><input style="width: 100%; background: #F1F1F1;" name="recommendation_item[]" type="text" class="form-control" maxlength="100" value="" required=""></p>
                                                                        <p class="col-2Point4" style="margin: 0px;"><input style="width: 100%; background: #F1F1F1;" name="entity_responsible_implementation[]" type="text" class="form-control" maxlength="100" value="" required=""></p>
                                                                        <p class="col-2Point4" style="margin: 0px;"><input style="width: 100%; background: #F1F1F1;" name="Implementation_period[]" type="text" class="form-control" maxlength="100" value="" required=""></p>
                                                                        <p class="col-2Point4" style="margin: 0px;"><input style="width: 100%; background: #F1F1F1;" name="entity_responsible_implementation_related[]" type="text" class="form-control" maxlength="100" value="" required=""></p>
                                                                        <p class="col-1Point2" style="margin: 0px; width:auto;">
                                                                            <i class="fa fa-minus-circle" style="color: #FF6347; font-size: 24px;" aria-hidden="true"></i>
                                                                        </p>
                                                                    </div>
                                                                    <div class="row py-3" style="text-align: center; align-items: center; min-height: 53px; border-bottom:1px solid #DEDEDE;">
                                                                        <p class="col-1Point2" style="margin: 0px; font-size:20px; line-height:16px; font-weight: 700;">4</p>
                                                                        <p class="col-2Point4" style="margin: 0px;"><input style="width: 100%; background: #F1F1F1;" name="recommendation_item[]" type="text" class="form-control" maxlength="100" value="" required=""></p>
                                                                        <p class="col-2Point4" style="margin: 0px;"><input style="width: 100%; background: #F1F1F1;" name="entity_responsible_implementation[]" type="text" class="form-control" maxlength="100" value="" required=""></p>
                                                                        <p class="col-2Point4" style="margin: 0px;"><input style="width: 100%; background: #F1F1F1;" name="Implementation_period[]" type="text" class="form-control" maxlength="100" value="" required=""></p>
                                                                        <p class="col-2Point4" style="margin: 0px;"><input style="width: 100%; background: #F1F1F1;" name="entity_responsible_implementation_related[]" type="text" class="form-control" maxlength="100" value="" required=""></p>
                                                                        <p class="col-1Point2 d-flex gap-3" style="margin: 0px; width:auto;">
                                                                            <i class="fa fa-minus-circle" style="color: #FF6347; font-size: 24px;" aria-hidden="true"></i>
                                                                            <i class="fa fa-plus-circle" style="color: #1DAE6D; font-size: 24px;" aria-hidden="true"></i>
                                                                        </p>
                                                                    </div>
                                                                @endif

                                                            </div>
                                                        </div>
                                                        <!-- End of Data Table -->
                                                    </div>
                                                    <!-- End of Data Table -->
                                                </div>
                                                <script>
                                                    document.getElementById('dynamicTableContainer').addEventListener('click', function (event) {
                                                        if (event.target.classList.contains('fa-minus-circle')) {
                                                            handleTableMinusIconClick(event.target);
                                                        } else if (event.target.classList.contains('fa-plus-circle')) {
                                                            handleTablePlusIconClick(event.target);
                                                        }
                                                    });

                                                    function handleTableMinusIconClick(minusIcon) {
                                                        var row = minusIcon.closest('.row .py-3');
                                                        var allRows = document.querySelectorAll('#dynamicTableContainer .row .py-3');
                                                        var isLastRow = row === document.querySelector('#dynamicTableContainer .row:last-child .py-3:last-child');

                                                        if (allRows.length > 1) {
                                                            row.remove();
                                                            renumberTableRows();

                                                            if (isLastRow) {
                                                                addTablePlusCircleToLastRow();
                                                            }

                                                        } else {
                                                            console.log('Cannot remove the only row.');
                                                        }
                                                    }

                                                    function handleTablePlusIconClick(plusIcon) {
                                                        var lastRow = document.querySelector('#dynamicTableContainer .row:last-child .col-12:last-child .py-3:last-child');
                                                        console.log(lastRow);
                                                        var newRow = lastRow.cloneNode(true);

                                                        var clonedPlusIcon = lastRow.querySelector('.fa-plus-circle');
                                                        if (clonedPlusIcon) {
                                                            clonedPlusIcon.remove();
                                                        }

                                                        document.querySelector('#dynamicTableContainer #dynamicTableRow .col-12').appendChild(newRow);
                                                        incrementTableNumberInRow(newRow);
                                                    }

                                                    function renumberTableRows() {
                                                        var rows = document.querySelectorAll('#dynamicTableContainer .row.py-3');
                                                        rows.forEach(function (row, index) {
                                                            var numberElement = row.querySelector('.col-1Point2');
                                                            numberElement.textContent = index + 1;
                                                        });
                                                    }

                                                    function addTablePlusCircleToLastRow() {
                                                        var lastRow = document.querySelector('#dynamicTableContainer .row:last-child .col-12:last-child .py-3:last-child');
                                                        var plusCircle = document.createElement('i');
                                                        plusCircle.className = 'fa fa-plus-circle';
                                                        plusCircle.style = 'color: #1DAE6D; font-size: 24px;';
                                                        lastChildInLastRow = lastRow.querySelector('.col-1Point2:last-child');
                                                        lastChildInLastRow.classList.add('d-flex', 'gap-3');
                                                        lastChildInLastRow.appendChild(plusCircle);
                                                    }

                                                    function incrementTableNumberInRow(row) {
                                                        var numberElement = row.querySelector('.col-1Point2');
                                                        var number = parseInt(numberElement.textContent) + 1;
                                                        numberElement.textContent = number;
                                                    }
                                                </script>
                                            </div>
                                            <div class="d-flex justify-content-center align-items-center mt-5" style="width:100%; min-height:190px;">
                                                <div class="d-flex justify-content-center align-items-center"
                                                     style="min-height:190px; border-top-right-radius:5px; border-bottom-right-radius:5px; width: 20%; padding:28px; text-align: center; background-color: #EAB977; color:#0A3A81; font-weight:700; font-size:20px; align-self:stretch;">ما لم ينفذ من التوصيات
                                                    و أسباب عدم التنفيذ</div>

                                                <div id="dynamicUnfinishedData" class="d-flex gap-3 flex-column justify-content-center align-items-center" style="width: 80%;">

                                                    @if((is_array($item_val['meeting_recommendations']) && !empty($item_val['meeting_recommendations'])))
                                                        @foreach  ($item_val['meeting_recommendations'] as $key => $recommendation_val)
                                                            @if ($recommendation_val['status'] == 0)
                                                                <div class="row gap-0 align-items-center" style="width:100%;">
                                                                    <div class="col-11">
                                                                        <input style="width: 100%; background: #F1F1F1;" name="meeting_recommendations_not_completed[]" type="text" class="form-control"
                                                                               maxlength="100"  value="{{ $recommendation_val['Item'] }}" required="">
                                                                    </div>
                                                                    <div class="col-1 d-flex gap-3">
                                                                        <i class="fa fa-minus-circle" style="color: #FF6347; font-size: 24px;" aria-hidden="true"></i>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @else


                                                    <div class="row gap-0 align-items-center" style="width:100%;">
                                                        <div class="col-11">
                                                            <input style="width: 100%; background: #F1F1F1;"  name="meeting_recommendations_not_completed[]" type="text" class="form-control" maxlength="100" value="" required="">
                                                        </div>
                                                        <div class="col-1 d-flex gap-3">
                                                            <i class="fa fa-minus-circle" style="color: #FF6347; font-size: 24px;" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row gap-0 align-items-center" style="width:100%;">
                                                        <div class="col-11">
                                                            <input style="width: 100%; background: #F1F1F1;"  name="meeting_recommendations_not_completed[]"  type="text" class="form-control" maxlength="100" value="" required="">
                                                        </div>
                                                        <div class="col-1 d-flex gap-3">
                                                            <i class="fa fa-minus-circle" style="color: #FF6347; font-size: 24px;" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row gap-0 align-items-center" style="width:100%;">
                                                        <div class="col-11">
                                                            <input style="width: 100%; background: #F1F1F1;"  name="meeting_recommendations_not_completed[]" type="text" class="form-control" maxlength="100" value="" required="">
                                                        </div>
                                                        <div class="col-1 d-flex gap-3">
                                                            <i class="fa fa-minus-circle" style="color: #FF6347; font-size: 24px;" aria-hidden="true"></i>
                                                            <i class="fa fa-plus-circle" style="color: #1DAE6D; font-size: 24px;" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    @endif

                                                </div>
                                                <script>
                                                    document.getElementById('dynamicUnfinishedData').addEventListener('click', function (event) {
                                                        if (event.target.classList.contains('fa-minus-circle')) {
                                                            handleUnfinishedDataMinusIconClick(event.target);
                                                        } else if (event.target.classList.contains('fa-plus-circle')) {
                                                            handleUnfinishedDataPlusIconClick(event.target);
                                                        }
                                                    });

                                                    function handleUnfinishedDataMinusIconClick(minusIcon) {
                                                        var row = minusIcon.closest('.row.gap-0.align-items-center');
                                                        var allRows = document.querySelectorAll('#dynamicUnfinishedData .row.gap-0.align-items-center');
                                                        var isLastRow = row === document.querySelector('#dynamicUnfinishedData .row:last-child.gap-0.align-items-center');

                                                        if (allRows.length > 1) {
                                                            row.remove();

                                                            if (isLastRow) {
                                                                addUnfinishedDataPlusCircleToLastRow();
                                                            }

                                                        } else {
                                                            console.log('Cannot remove the only row.');
                                                        }
                                                    }

                                                    function handleUnfinishedDataPlusIconClick(plusIcon) {
                                                        var lastRow = document.querySelector('#dynamicUnfinishedData .row:last-child.gap-0.align-items-center');
                                                        var newRow = lastRow.cloneNode(true);

                                                        var clonedPlusIcon = lastRow.querySelector('.fa-plus-circle');
                                                        if (clonedPlusIcon) {
                                                            clonedPlusIcon.remove();
                                                        }

                                                        document.querySelector('#dynamicUnfinishedData').appendChild(newRow);
                                                    }

                                                    function addUnfinishedDataPlusCircleToLastRow() {
                                                        var lastRow = document.querySelector('#dynamicUnfinishedData .row:last-child.gap-0.align-items-center');
                                                        var plusCircle = document.createElement('i');
                                                        plusCircle.className = 'fa fa-plus-circle';
                                                        plusCircle.style = 'color: #1DAE6D; font-size: 24px;';
                                                        lastRow.querySelector('.col-1.d-flex.gap-3').appendChild(plusCircle);
                                                    }
                                                </script>
                                            </div>

                                            <div class="row mt-4" style="width: 100%;" data-select2-id="select2-data-23-4h1t">
                                                <div class="col-12 col-md-2 col-xl-2">
                                                    <label class="form-label mb-2 mt-3 mb-xl-0" style="color:#000000; font-size:17px; line-height:16px; font-weight:700;">موعد انتهاء الاجتماع
                                                    </label>
                                                </div>

                                                <div class="col-12 col-md-4 col-xl-4">
                                                    <div class=" input-group">
                                                        <input name="end_time" type="text" class="form-control timepicker border-left-0 clickable-item-pointer  "
                                                               placeholder=" وقت الاجتماع" value="{{ isset($item_val) ? $item_val['end_time']: ''}}"  required="" autocomplete="off" date-text=" وقت الاجتماع">
                                                        <div class="timepicker__wrapper timepicker__wrapper-full" id="tp_36" style="width: 546px; z-index: 1;">
                                                            <div class="timepicker__hour">
                                                                <p class="display_up_hour  timepicker__button timepicker__button__up ">10</p>
                                                                <div class="timepicker__button timepicker__button__up">
                                                                    <div></div>
                                                                </div>
                                                                <p class="display">9
                                                                    <span class="bg_dot_data_timepicker" id="my-id">
                          <svg width="9" height="31" viewBox="0 0 9 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="4.5" cy="4.5" r="4.5" fill="#0A3A81"></circle>
                            <circle cx="4.5" cy="26.5" r="4.5" fill="#0A3A81"></circle>
                          </svg>
                        </span>
                                                                </p>
                                                                <div class="timepicker__button timepicker__button__down">
                                                                    <div></div>
                                                                </div>
                                                                <p class="display_down_hour timepicker__button timepicker__button__down">8</p>
                                                            </div>
                                                            <div class="timepicker__minute">
                                                                <p class="display_up_minute  timepicker__button timepicker__button__up ">55</p>
                                                                <div class="timepicker__button timepicker__button__up">
                                                                    <div></div>
                                                                </div>
                                                                <p class="display">54</p>
                                                                <div class="timepicker__button timepicker__button__down">
                                                                    <div></div>
                                                                </div>
                                                                <p class="display_down_minute timepicker__button timepicker__button__down">53</p>
                                                            </div>
                                                            <div class="timepicker__meridiem">
                                                                <p class="display_up_meridiem  timepicker__button timepicker__button__up ">AM</p>
                                                                <div class="timepicker__button timepicker__button__up">
                                                                    <div></div>
                                                                </div>
                                                                <p class="display">am</p>
                                                                <div class="timepicker__button timepicker__button__down">
                                                                    <div></div>
                                                                </div>
                                                                <p class="display_down_meridiem timepicker__button timepicker__button__down">PM</p>
                                                            </div>
                                                        </div>
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <img class="platform_icon" alt="school" src="https://factoryfiy.com/img/icons/clock.svg">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="d-flex justify-content-around mt-1" style="width: 100%;">
                                                <button type="button" class="next_btn mt-5 px-5 border_radius_5"
                                                        style="width:15%; background-color: unset; border: 1px solid #0A3A81; color:#0A3A81; font-size:14px; font-weight:700;" onclick="goToMeetingDataForm()">السابق</button>
                                                <button type="submit" class="main_btn mt-5 px-5 border_radius_5" style="width:15%;">حفظ وإنهاء</button>
                                            </div>
                                        </div>
                                        <script>
                                            function goToMeetingDataForm() {
                                                $('#pills-tab0').tab('show');
                                            }
                                        </script>
                                    </div>

                                @endif
                                </form>
                        </div>
                    @endforeach
                </div>
            </div>


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
