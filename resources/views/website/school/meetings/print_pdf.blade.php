@php
    $hasStatusZero = false;
    foreach ($item_val['meeting_recommendations'] as $recommendation) {
        if ($recommendation['status'] == 0) {
            $hasStatusZero = true;
            break;
        }
    }

@endphp
    <!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Meeting Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" crossorigin="anonymous">
    <link href="{{ URL::asset('css/website_minified.css') }}" rel="stylesheet">
    <style>
        @media print {
            @page { size: landscape; }
            * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            #container_of_all_meeting_recommendations_not { padding-left: 0; padding-right: 10%; }
        }
        body {font-family: 'DejaVu Sans', sans-serif;}
        /* Additional custom styles can be added here */
    </style>
</head>
<body>
<div class="print-section" style=" direction: rtl; text-align: right;">
<div class="container-fluid px-4 px-md-5 py-3 py-md-4">
    <div class="row">
            <div class="col-12 mb-3 mb-md-0">
                <div class="main_cot_bg p-3 py-3 h-100">


                            <div class="container form-container">
                                <div class="card custom-card">
                                    <div class="Committees_and_teams_meetings_create_title">
                                         {{$Committees_and_teams['title']}}
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="card-body custom-card-body">


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

                                                                <input name="start_date" type="text" style="border-left: 0px;"
                                                                       class="  hijri-date-input   form-control   clickable-item-pointer @error('start_date') is-invalid @enderror"
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

                                                                <input name="start_time" type="text" style="border-left: 0px;"
                                                                       class="form-control   clickable-item-pointer @error('start_time') is-invalid @enderror"
                                                                       placeholder=" وقت الاجتماع"  value="{{ isset($item_val) ? $item_val['start_time']: ''}}" required>
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text"> <img class="platform_icon" alt="school"
                                                                                                        src="{{ URL::asset('img/icons/clock.svg') }}"> </div>
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


                                                <div class="  form-group">
                                                    <div class="row">
                                                        <div class="col-md-3 align-self-center ">
                                                            <label  for="committee" class="form-label bold_form_label ">   الفئه المستهدفه </label>
                                                        </div>
                                                        <div class="col-md-9">
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


                                                <div class="  form-group Number_of_attendees">
                                                    <div class="row">
                                                        <div class="col-md-3 align-self-center ">
                                                            <label  for="committee" class="form-label bold_form_label "> عدد الحاضرين    </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select  id="Number_of_attendees" name="Number_of_attendees" class="form-control custom-select js-example-basic-single  select2-hidden-accessible">
                                                                <option value="">عدد الحاضرين</option>
                                                                @foreach ([5, 10, 15, 20, 30] as $value)
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
                                                        <label  for="committee" class="form-label bold_form_label "  style="padding-bottom: 10px;">    جدول اعمال الاجتماع  </label>
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



                                                                        </div>
                                                                    </div>



                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <div  id="container_of_all_add_meeting_recommendations_finished">    </div>


                                                        @endif
                                                    </div>
                                                </div>



                                                <div class="  form-group meeting_recommendations_not " style="padding-top: 25px;">
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

                                                            <input name="start_time" type="text" style="border-left: 0px;"
                                                                   class="form-control   clickable-item-pointer @error('end_time') is-invalid @enderror"
                                                                   placeholder=" وقت الاجتماع"  value="{{ isset($item_val) ? $item_val['end_time']: ''}}" required>
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"> <img class="platform_icon" alt="school"
                                                                                                    src="{{URL::asset('img/icons/clock.svg') }}"> </div>
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
            </div>

    </div>
</div>
</body>
</html>


