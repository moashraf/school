@extends('website.roadmap.layouts.master', ['no_header' => true, 'no_transparent_header' => false])

@section('title', 'ابدا رحلة مدرستك الان مع منصة لام | منصة لام')

@section('title-topbar', 'ابدا رحلة مدرستك الان مع منصة لام | منصة لام')

<!-- css insert -->
@section('css')

<!-- select 2 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css"
    integrity="sha512-aD9ophpFQ61nFZP6hXYu4Q/b/USW7rpLCQLX6Bi0WJHXNO7Js/fUENpBQf/+P4NtpzNX0jSgR5zVvPOJp+W2Kg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />


<!-- tables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.3.9/css/autoFill.bootstrap5.min.css">


<!-- datepicker time and date -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css"
    integrity="sha512-MQXduO8IQnJVq1qmySpN87QQkiR1bZHtorbJBD0tzy7/0U9+YIC93QWHeGTEoojMVHWWNkoCp8V6OzVSYrX0oQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://fastly.jsdelivr.net/npm/flatpickr@4.6.13/dist/plugins/monthSelect/style.min.css">

@endsection

<!-- content insert -->
@section('content')

<div class="cont_wrapper pb-2">

    <div class="main_cont py-4 px-4">

        {{-------- 1-2- Welcome Page --------}}
        <div class="cont_tap" @if($roadmap==10) style="display: block" @else style="display: none" @endif id="clinics">

            <form id="myform">
                <div class="text-center py-5">
                    <h1 class="text-gray-900 text-center mb-4 fw-bold">اهلا بك في منصة لام </h1>
                    <iframe class="col-12 col-md-8 col-xl-6" width="560" height="315" src="{{ $video_tutorial->url }}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>

                <div class="next-form-steps progressbar_roadmap_next_btn">
                    <h6 class="mb-0 ms-2">التالي</h6>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </form>
        </div>

        {{-------- 3- General Info --------}}
        <div class="cont_tap" @if($roadmap==11) style="display: block" @else style="display: none" @endif id="clinics">
            <h5 class="text-gray-800 fw-bold mb-5"><svg class="me-2" width="23" height="23" viewBox="0 0 23 23"
                    fill="transparent" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M8.35 22H14.65C19.9 22 22 19.9 22 14.65V8.35C22 3.1 19.9 1 14.65 1H8.35C3.1 1 1 3.1 1 8.35V14.65C1 19.9 3.1 22 8.35 22Z"
                        stroke="#444444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M17.2751 16.8342H15.3326" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M12.5185 16.8342H5.72504" stroke="#444444" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M17.8 8.34985H5.20001" stroke="#444444" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M17.275 12.8865H11.4685" stroke="#444444" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M8.63354 12.8865H5.72504" stroke="#444444" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg> بيانات عامة
            </h5>

            <form id="myform_general_info" method="POST" enctype="multipart/form-data">
                @csrf

                <div>
                    <div class="row mb-4">
                        <div class="col-12 col-md-4 col-xl-4 align-self-center">
                            <label class="form-label mb-2 mb-xl-0">نوع المدرسة
                                <span class=" text-red fs-6">*</span></label>
                        </div>
                        <div class="col-12 col-md-7 col-xl-7">
                            <div class="d-flex">
                                <div class="check_custom_index me-5">
                                    <input type="hidden" name="school" value="sec12saksa">
                                    <input @if($second_school) @if($second_school->gendar == 1)
                                    checked
                                    @endif
                                    @else checked
                                    @endif type="radio" id="school_gendar_m_radio" name="school_gendar"
                                    value="1">
                                    <label for="school_gendar_m_radio">بنين</label>
                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </div>
                                <div class="check_custom_index me-3">
                                    <input @if($second_school) @if($second_school->gendar == 2)
                                    checked
                                    @endif
                                    @endif type="radio" id="school_gendar_f_radio" name="school_gendar" value="2">
                                    <label for="school_gendar_f_radio">بنات</label>
                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="school_gendar-js_error_valid"></div>
                            @error('school_gendar')
                            <span class="error-msg-form">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12 col-md-4 col-xl-4 align-self-center">
                            <label class="form-label mb-2 mb-xl-0">المرحلة الدراسية
                                <span class=" text-red fs-6">*</span></label>
                        </div>
                        <div class="col-12 col-md-7 col-xl-7">

                            <select class="js-example-basic-single select2-no-search select2-hidden-accessible"
                                name="school_level" required>
                                <option @if($second_school) @if($second_school->level == 1)
                                    selected @endif @endif value="1">المرحلة الابتدائية</option>
                                <option @if($second_school) @if($second_school->level == 2)
                                    selected @endif @endif value="2">المرحلة الاعدادية</option>
                                <option @if($second_school) @if($second_school->level == 3)
                                    selected @endif @endif value="3">المرحلة الثانوية</option>
                            </select>

                            <div id="school_level-js_error_valid"></div>
                            @error('school_level')
                            <span class="error-msg-form">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12 col-md-4 col-xl-4 align-self-center">
                            <label class="form-label mb-2 mb-xl-0">اسم المدرسة
                                <span class=" text-red fs-6">*</span></label>
                        </div>
                        <div class="col-12 col-md-7 col-xl-7">
                            <input name="school_name" type="text" class="form-control" maxlength="100"
                                placeholder="اكتب هنا اسم المدرسة .."
                                value="@if($second_school){{ $second_school->name }}@endif" required>
                            <div id="school_name-js_error_valid"></div>
                            @error('school_name')
                            <span class="error-msg-form">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12 col-md-4 col-xl-4 align-self-center">
                            <label class="form-label mb-2 mb-xl-0">الرقم الوزاري
                                <span class=" text-red fs-6">*</span></label>
                        </div>
                        <div class="col-12 col-md-7 col-xl-7">
                            <input name="ministerial_number" type="text" minlength="4" maxlength="40"
                                class="form-control" placeholder="اكتب هنا الرقم الوزاري .."
                                value="@if($second_school){{ $second_school->ministerial_number }}@endif" required>
                            <div id="ministerial_number-js_error_valid"></div>
                            @error('ministerial_number')
                            <span class="error-msg-form">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12 col-md-4 col-xl-4 align-self-center">
                            <label class="form-label mb-2 mb-xl-0">نوع المدرسة
                                <span class=" text-red fs-6">*</span></label>
                        </div>
                        <div class="col-12 col-md-7 col-xl-7">
                            <div class="d-flex">
                                <div class="check_custom_index me-5">
                                    <input @if($second_school) @if($second_school->school_type == 1)
                                    checked
                                    @endif
                                    @else checked
                                    @endif type="radio" id="school_type_public_raido" name="school_type"
                                    value="1">
                                    <label for="school_type_public_raido">حكومي</label>
                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </div>
                                <div class="check_custom_index me-3">
                                    <input @if($second_school) @if($second_school->school_type == 2)
                                    checked
                                    @endif
                                    @endif type="radio" id="school_type_private_raido" name="school_type" value="2">
                                    <label for="school_type_private_raido">اهلي</label>
                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="school_type-js_error_valid"></div>
                            @error('school_type')
                            <span class="error-msg-form">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12 col-md-4 col-xl-4 align-self-center">
                            <label class="form-label mb-2 mb-xl-0">ادارة التعليم
                                <span class=" text-red fs-6">*</span></label>
                        </div>
                        <div class="col-12 col-md-7 col-xl-7">

                            <select class="js-example-basic-single select2-hidden-accessible" name="school_department"
                                id="school_department" required>
                                @foreach ($departments as $item)
                                <option @if($second_school) @if($second_school->edu_department_id == $item->id)
                                    selected @endif @endif value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>

                            <div id="school_department-js_error_valid"></div>
                            @error('school_department')
                            <span class="error-msg-form">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12 col-md-4 col-xl-4 align-self-center">
                            <label class="form-label mb-2 mb-xl-0">المكتب التابع له المدرسة
                                <span class=" text-red fs-6">*</span></label>
                        </div>
                        <div class="col-12 col-md-7 col-xl-7">

                            <select class="js-example-basic-single select2-hidden-accessible"
                                name="school_department_office" id="school_department_office" required>
                                @if($second_school)
                                <option selected value="{{ $second_school->edu_department_office_id }}">{{
                                    $second_school->department_office->name }}</option>
                                @else
                                <option> - يرجي اختيار ادارة التعليم اولا - </option>
                                @endif


                            </select>

                            <div id="school_department_office-js_error_valid"></div>
                            @error('school_department_office')
                            <span class="error-msg-form">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12 col-md-4 col-xl-4 align-self-center">
                            <label class="form-label mb-2 mb-xl-0">تاريخ تاسيس المدرسة
                                <span class=" text-red fs-6">*</span></label>
                        </div>
                        <div class="col-12 col-md-7 col-xl-7">

                            <div class="input-group">

                                <input name="established_date" type="text" style="border-left: 0px;"
                                    class="form-control hasdatetimepicker clickable-item-pointer @error('established_date') is-invalid @enderror"
                                    placeholder="YYYY/MM/DD"
                                    value="@if($second_school){{ $second_school->established_date }}@endif" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"> <img class="platform_icon" alt="school"
                                            src="{{ URL::asset('img/icons/calendar.svg') }}"> </div>
                                </div>
                            </div>
                            <div id="established_date-js_error_valid"></div>
                            @error('established_date')
                            <span class="error-msg-form">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12 col-md-4 col-xl-4 align-self-center">
                            <label class="form-label mb-2 mb-xl-0">فترة الدوام
                                <span class=" text-red fs-6">*</span></label>
                        </div>
                        <div class="col-12 col-md-7 col-xl-7">
                            <div class="d-flex">
                                <div class="check_custom_index me-5">
                                    <input @if($second_school) @if($second_school->school_period == 1)
                                    checked
                                    @endif
                                    @else
                                    checked
                                    @endif type="radio" id="school_period_morning" name="school_period"
                                    value="1">
                                    <label for="school_period_morning">صباحي</label>
                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </div>
                                <div class="check_custom_index me-5">
                                    <input @if($second_school) @if($second_school->school_period == 2)
                                    checked
                                    @endif
                                    @endif type="radio" id="school_period_afternoon" name="school_period" value="2">
                                    <label for="school_period_afternoon">مسائي</label>
                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </div>
                                <div class="check_custom_index me-3">
                                    <input @if($second_school) @if($second_school->school_period == 3)
                                    checked
                                    @endif
                                    @endif type="radio" id="school_period_night" name="school_period" value="3">
                                    <label for="school_period_night">ليلي</label>
                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="school_type-js_error_valid"></div>
                            @error('school_type')
                            <span class="error-msg-form">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-12 col-md-4 col-xl-4 align-self-center">
                            <label class="form-label mb-2 mb-xl-0">عنوان المدرسة
                                <span class=" text-red fs-6">*</span></label>
                        </div>
                        <div class="col-12 col-md-7 col-xl-7">
                            <input name="address" type="text" class="form-control" minlength="5" maxlength="255"
                                placeholder="منطقة - محافظة - مدينة أو حي"
                                value="@if($second_school){{ $second_school->address }}@endif" required>
                            <div id="address-js_error_valid"></div>
                            @error('address')
                            <span class="error-msg-form">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <div class="previous-form-steps progressbar_roadmap_previous_btn">
                        <h6 class="mb-0 ms-2">السابق</h6>
                        <i class="fas fa-chevron-up"></i>
                    </div>

                    <div class="progressbar_roadmap_next_btn" id="general_info">
                        <h6 class="mb-0 ms-2">التالي</h6>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>

            </form>


        </div>

        {{-------- 4- Facilities --------}}
        <div class="cont_tap" @if($roadmap==12) style="display: block" @else style="display: none" @endif
            id="facilities">
            <h5 class="text-gray-800 fw-bold mb-5"><svg class="me-2" width="23" height="23" viewBox="0 0 23 23"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M20.2973 10.7651V6.29204C20.2973 2.06052 19.2303 1 14.9395 1H6.35784C2.06703 1 1 2.06052 1 6.29204V18.1151C1 20.9081 2.65731 21.5696 4.6665 19.5746L4.67783 19.5641C5.60864 18.6506 7.02756 18.7241 7.8335 19.7216L8.98 21.1391"
                        stroke="#444444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M17.6866 21.3702C19.6927 21.3702 21.319 19.8658 21.319 18.0102C21.319 16.1545 19.6927 14.6501 17.6866 14.6501C15.6804 14.6501 14.0541 16.1545 14.0541 18.0102C14.0541 19.8658 15.6804 21.3702 17.6866 21.3702Z"
                        stroke="#444444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M22 22.0001L20.8649 20.9501" stroke="#444444" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M6.10809 6.25H15.1892" stroke="#444444" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M7.24329 10.4501H14.0541" stroke="#444444" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                بيانات مرافق المدرسة
            </h5>

            <form id="myform_facilities" method="POST" enctype="multipart/form-data">
                @csrf

                <div>
                    <div class="row mb-4">
                        <div class="col-12 col-md-4 col-xl-4 align-self-center">
                            <label class="form-label mb-2 mb-xl-0">نوع المبني
                                <span class=" text-red fs-6">*</span></label>
                        </div>
                        <div class="col-12 col-md-7 col-xl-7">
                            <div class="d-flex">
                                <div class="check_custom_index me-5">
                                    <input @if($second_school) @if($second_school->building_type == 1)
                                    checked
                                    @else
                                    checked
                                    @endif
                                    @else
                                    checked
                                    @endif type="radio" id="building_type_gov" name="building_type"
                                    value="1">
                                    <label for="building_type_gov">حكومي</label>
                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </div>
                                <div class="check_custom_index me-3">
                                    <input @if($second_school) @if($second_school->building_type == 2)
                                    checked
                                    @endif
                                    @endif
                                    type="radio" id="building_type_rent" name="building_type" value="2">
                                    <label for="building_type_rent">مستأجر</label>
                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="school_gendar-js_error_valid"></div>
                            @error('school_gendar')
                            <span class="error-msg-form">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12 col-md-4 col-xl-4 align-self-center">
                            <label class="form-label mb-2 mb-xl-0">حالة المبني
                                <span class=" text-red fs-6">*</span></label>
                        </div>
                        <div class="col-12 col-md-7 col-xl-7">
                            <div class="d-flex">
                                <div class="check_custom_index me-5">
                                    <input @if($second_school) @if($second_school->building_status == 1)
                                    checked
                                    @else
                                    checked
                                    @endif
                                    @else
                                    checked
                                    @endif type="radio" id="building_status_exc" name="building_status"
                                    value="1">
                                    <label for="building_status_exc">ممتازة</label>
                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </div>
                                <div class="check_custom_index me-4">
                                    <input @if($second_school) @if($second_school->building_status == 2)
                                    checked
                                    @endif
                                    @endif type="radio" id="building_status_good" name="building_status" value="2">
                                    <label for="building_status_good">جيدة</label>
                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </div>
                                <div class="check_custom_index me-3">
                                    <input @if($second_school) @if($second_school->building_status == 3)
                                    checked
                                    @endif
                                    @endif type="radio" id="building_status_bad" name="building_status" value="3">
                                    <label for="building_status_bad">متهالكة</label>
                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="school_gendar-js_error_valid"></div>
                            @error('school_gendar')
                            <span class="error-msg-form">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">عدد الفصول الدراسية
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input name="classes_number" type="number" min="0" max="2000"
                                        class="form-control facilities_number" placeholder="العدد"
                                        value="@if($second_school){{ $second_school->classes_number }}@else 0 @endif"
                                        required>
                                    <div id="classes_number-js_error_valid"></div>
                                    @error('classes_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">عدد دورات المياه
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input name="bathroom_number" type="number" min="0" max="2000"
                                        class="form-control facilities_number" placeholder="العدد"
                                        value="@if($second_school){{ $second_school->bathroom_number }}@else 0 @endif"
                                        required>
                                    <div id="bathroom_number-js_error_valid"></div>
                                    @error('bathroom_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">عدد الادوار
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input name="floors_number" type="number" min="0" max="2000"
                                        class="form-control facilities_number" placeholder="العدد"
                                        value="@if($second_school){{ $second_school->floors_number }}@else 0 @endif"
                                        required>
                                    <div id="floors_number-js_error_valid"></div>
                                    @error('floors_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">عدد غرف المعلمين
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input name="teachers_room_number" type="number" min="0" max="2000"
                                        class="form-control facilities_number" placeholder="العدد"
                                        value="@if($second_school){{ $second_school->teachers_room_number }}@else 0 @endif"
                                        required>
                                    <div id="teachers_room_number-js_error_valid"></div>
                                    @error('teachers_room_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">عدد غرف الادارة
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input name="management_room_number" type="number" min="0" max="2000"
                                        class="form-control facilities_number" placeholder="العدد"
                                        value="@if($second_school){{ $second_school->management_room_number }}@else 0 @endif"
                                        required>
                                    <div id="management_room_number-js_error_valid"></div>
                                    @error('management_room_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">معامل الحاسب الالي
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input name="computers_room_number" type="number" min="0" max="2000"
                                        class="form-control facilities_number" placeholder="العدد"
                                        value="@if($second_school){{ $second_school->computers_room_number }}@else 0 @endif"
                                        required>
                                    <div id="computers_room_number-js_error_valid"></div>
                                    @error('computers_room_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">عدد المختبرات
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input name="lab_room_number" type="number" min="0" max="2000"
                                        class="form-control facilities_number" placeholder="العدد"
                                        value="@if($second_school){{ $second_school->lab_room_number }}@else 0 @endif"
                                        required>
                                    <div id="lab_room_number-js_error_valid"></div>
                                    @error('lab_room_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">عدد المستودعات
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input name="stock_room_number" type="number" min="0" max="2000"
                                        class="form-control facilities_number" placeholder="العدد"
                                        value="@if($second_school){{ $second_school->stock_room_number }}@else 0 @endif"
                                        required>
                                    <div id="stock_room_number-js_error_valid"></div>
                                    @error('stock_room_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">عدد مصادر التعلم
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input name="learning_resources_room_number" type="number" min="0" max="2000"
                                        class="form-control facilities_number" placeholder="العدد"
                                        value="@if($second_school){{ $second_school->learning_resources_room_number }}@else 0 @endif"
                                        required>
                                    <div id="learning_resources_room_number-js_error_valid"></div>
                                    @error('learning_resources_room_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">عدد غرف الانشطة
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input name="activities_room_number" type="number" min="0" max="2000"
                                        class="form-control facilities_number" placeholder="العدد"
                                        value="@if($second_school){{ $second_school->activities_room_number }}@else 0 @endif"
                                        required>
                                    <div id="activities_room_number-js_error_valid"></div>
                                    @error('activities_room_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">عدد غرف الاجتماعات
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input name="meetings_room_number" type="number" min="0" max="2000"
                                        class="form-control facilities_number" placeholder="العدد"
                                        value="@if($second_school){{ $second_school->meetings_room_number }}@else 0 @endif"
                                        required>
                                    <div id="meetings_room_number-js_error_valid"></div>
                                    @error('meetings_room_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">عدد الصالات الرياضية
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input name="sport_room_number" type="number" max="2000" class="form-control"
                                        placeholder="العدد"
                                        value="@if($second_school){{ $second_school->sport_room_number }}@else 0 @endif"
                                        required>
                                    <div id="sport_room_number-js_error_valid"></div>
                                    @error('sport_room_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">عدد المسارح
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input name="theaters_number" type="number" min="0" max="2000"
                                        class="form-control facilities_number" placeholder="العدد"
                                        value="@if($second_school){{ $second_school->theaters_number }}@else 0 @endif"
                                        required>
                                    <div id="theaters_number-js_error_valid"></div>
                                    @error('theaters_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">عدد الملاعب
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input name="grounds_number" type="number" min="0" max="2000"
                                        class="form-control facilities_number" placeholder="العدد"
                                        value="@if($second_school){{ $second_school->grounds_number }}@else 0 @endif"
                                        required>
                                    <div id="grounds_number-js_error_valid"></div>
                                    @error('grounds_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">فناء خارجي
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input name="outdoor_room_number" type="number" min="0" max="2000"
                                        class="form-control facilities_number" placeholder="العدد"
                                        value="@if($second_school){{ $second_school->outdoor_room_number }}@else 0 @endif"
                                        required>
                                    <div id="outdoor_room_number-js_error_valid"></div>
                                    @error('outdoor_room_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">فناء خارجي
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input name="indoor_room_number" type="number" min="0" max="2000"
                                        class="form-control facilities_number" placeholder="العدد"
                                        value="@if($second_school){{ $second_school->indoor_room_number }}@else 0 @endif"
                                        required>
                                    <div id="indoor_room_number-js_error_valid"></div>
                                    @error('indoor_room_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-12 col-md-7">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 col-xl-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0 fw-bold text-gray-800"><span
                                            class="text-gray-400 clickable-item-pointer me-1" href="#"
                                            data-bs-toggle="tooltip"
                                            data-bs-title="الفصول الدراسية، غرف المعلمين، غرف الإدارة، معامل الحاسب الاّلي، المختبرات، مصادر التعلم، غرف النشاط، غرف الاجتماعات"><i
                                                class="fas fa-info-circle main-color fs-5"></i></span>
                                        العدد الاجمالي للغرف</label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-4">
                                    <input id="total_facilities_rooms" value="@if($second_school){{ $second_school->total_rooms
                                    }}@endif" type="text" disabled class="form-control text-center" placeholder="العدد"
                                        required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div>
                        <div class="previous-form-steps progressbar_roadmap_previous_btn">
                            <h6 class="mb-0 ms-2">السابق</h6>
                            <i class="fas fa-chevron-up"></i>
                        </div>

                        <div class="progressbar_roadmap_next_btn" id="facilities_btn">
                            <h6 class="mb-0 ms-2">التالي</h6>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>

            </form>

        </div>
    </div>

    {{-------- 5- Students --------}}
    <div class="cont_tap" @if($roadmap==13) style="display: block" @else style="display: none" @endif id="students">
        <h5 class="text-gray-800 fw-bold mb-3">
            <svg class="me-2" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.77839 10.417C8.68256 10.4075 8.56756 10.4075 8.46214 10.417C6.18131 10.3404 4.37006 8.47163 4.37006 6.17163C4.37006 3.82371 6.26756 1.91663 8.62506 1.91663C10.973 1.91663 12.8801 3.82371 12.8801 6.17163C12.8705 8.47163 11.0593 10.3404 8.77839 10.417Z"
                    stroke="#444444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path
                    d="M15.7263 3.83325C17.5854 3.83325 19.0804 5.33784 19.0804 7.18742C19.0804 8.99867 17.6429 10.4745 15.8509 10.5416C15.7742 10.532 15.6879 10.532 15.6017 10.5416"
                    stroke="#444444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path
                    d="M3.98663 13.9533C1.66746 15.5058 1.66746 18.0358 3.98663 19.5787C6.62205 21.342 10.9442 21.342 13.5796 19.5787C15.8987 18.0262 15.8987 15.4962 13.5796 13.9533C10.9537 12.1995 6.63163 12.1995 3.98663 13.9533Z"
                    stroke="#444444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path
                    d="M17.5759 19.1666C18.2659 19.0229 18.9176 18.745 19.4543 18.3329C20.9493 17.2116 20.9493 15.362 19.4543 14.2408C18.9272 13.8383 18.2851 13.57 17.6047 13.4166"
                    stroke="#444444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            بيانات الطلاب
        </h5>

        <div class="mb-4">
            @if(count($students) > 0)
            <div class="d-flex align-items-center mb-3">
                <h6 class="me-2 mb-0"> اعادة استيراد ملف الطلاب</h6>
                <form id="myform_student_resend" method="POST"
                    action="{{ route('school_route.roadmap_students_store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="text-center">
                        <label for="students_file_upload_resend"
                            class="link-cust-text main_btn border_radius_10 px-4 clickable-item-pointer text-xs p-0"
                            style="display: inline-block;min-height: 34px !important;padding-top: 5px !important;">
                            @if(count($students) > 0)
                            اعادة الاستيراد
                            @else
                            استيراد
                            @endif
                            <svg class="mb-2 ms-1" width="20" height="20" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17 8.2V13C17 16.2 16.2 17 13 17H5C1.8 17 1 16.2 1 13V5C1 1.8 1.8 1 5 1H6.2C7.4 1 7.664 1.352 8.12 1.96L9.32 3.56C9.624 3.96 9.8 4.2 10.6 4.2H13C16.2 4.2 17 5 17 8.2Z"
                                    fill="#FFFFFF" stroke="#FFFFFF" stroke-miterlimit="10" />
                                <path d="M9 13V8.19995" stroke="#0A3A81" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M6.59961 9.7999L8.99961 7.3999L11.3996 9.7999" stroke="#0A3A81"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </label>
                        <input type="hidden" name="school" value="fr1ksa">
                        <input id="students_file_upload_resend" name="students_file_upload"
                            class="custom_file_upload_input" type="file" accept=".xlsx" />
                    </div>
                </form>

            </div>
            <h6> <i class="fas fa-info-circle fs-5 me-1 main-color"></i>عند استعادة استيراد ملف الطلاب سوف يتم مسح الملف
                الحالي</h6>
            @else
            <h6> <i class="fas fa-info-circle fs-5 me-1 main-color"></i>
                قم بتحميل ملف الطلاب الذي تم تحميله من نظام نور</h6>
            @endif
        </div>

        <div>

            <div class="row mb-4">
                <div class="col-12  align-self-center">

                    @if(count($students) == 0)
                    <div class="table-responsive">
                        <table class="table display normal_table" style="direction: " width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-xs fw-bold">اسم الطالب</th>
                                    <th class="text-xs fw-bold">السجل المدني</th>
                                    <th class="text-xs fw-bold">الجنسية</th>
                                    <th class="text-xs fw-bold">رقم الجوال</th>
                                    <th class="text-xs fw-bold">الصف</th>
                                    <th class="text-xs fw-bold">القسم</th>
                                    <th class="text-xs fw-bold">الفصل</th>
                                </tr>
                            </thead>

                        </table>
                    </div>

                    <form id="myform_student" method="POST" action="{{ route('school_route.roadmap_students_store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="text-center">

                            <label for="students_file_upload" class="custom_file_upload">
                                <svg class="mb-2" width="40" height="40" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17 8.2V13C17 16.2 16.2 17 13 17H5C1.8 17 1 16.2 1 13V5C1 1.8 1.8 1 5 1H6.2C7.4 1 7.664 1.352 8.12 1.96L9.32 3.56C9.624 3.96 9.8 4.2 10.6 4.2H13C16.2 4.2 17 5 17 8.2Z"
                                        fill="#0A3A81" stroke="#0A3A81" stroke-miterlimit="10" />
                                    <path d="M9 13V8.19995" stroke="#FFFFFF" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M6.59961 9.7999L8.99961 7.3999L11.3996 9.7999" stroke="#FFFFFF"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <h4 class="mb-0">اضغط هنا لاستيراد الطلاب</h4>
                                <p class=" text-gray-400">لم يتم استيراد بيانات الطلاب</p>
                            </label>
                            <input type="hidden" name="school" value="sec12saksa">
                            <input id="students_file_upload" name="students_file_upload"
                                class="custom_file_upload_input" type="file" accept=".xlsx" />
                        </div>
                    </form>
                    @else
                    <div class="table-responsive">
                        <table class="table display datatable-modal" style="direction: " id="p-table" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-xs fw-bold">اسم الطالب</th>
                                    <th class="text-xs fw-bold">السجل المدني</th>
                                    <th class="text-xs fw-bold">الجنسية</th>
                                    <th class="text-xs fw-bold">رقم الجوال</th>
                                    <th class="text-xs fw-bold">الصف</th>
                                    <th class="text-xs fw-bold">القسم</th>
                                    <th class="text-xs fw-bold">الفصل</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($students as $item)
                                <tr>
                                    <td class="">
                                        {{ $item->name }}
                                    </td>
                                    <td class="">
                                        {{ $item->identification_number }}
                                    </td>
                                    <td class="">
                                        {{ $item->nationality }}
                                    </td>
                                    <td class="">
                                        {{ $item->phone_number }}
                                    </td>
                                    <td class="">
                                        {{ $item->grade->name }}
                                    </td>
                                    <td class="">
                                        {{ $item->department }}
                                    </td>
                                    <td class="">
                                        {{ $item->class->name }}
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>


                            <tfoot>
                                <tr>
                                    <th class="text-center fw-bold text-s">اجمالي عدد الطلاب</th>
                                    <th class="text-center fw-bold text-s">{{ count($students) }} طلاب</th>

                                </tr>
                            </tfoot>

                        </table>
                    </div>
                    @endif

                    <div class="row pt-4">
                        <div class="col-12">
                            <h6 class="fw-bold">مسار تحميل الملف من نظام نور</h6>
                            <ul class="px-2 pe-md-4 progressbar_upload_file mb-0 mt-0 py-0" style="overflow: auto">
                                <li>
                                    <a class="d-flex align-items-center">
                                        <div class="icon-circle d-flex align-items-center justify-content-center me-2">
                                            <img class="platform_icon" alt="upload file from nour platform"
                                                src="{{ URL::asset('img/icons/upload_nour/group1.svg') }}">
                                        </div>
                                        <h6 class="mb-0">التقارير</h6>
                                    </a>
                                </li>
                                <li>
                                    <a class="d-flex align-items-center">
                                        <div class="icon-circle d-flex align-items-center justify-content-center me-2">
                                            <img class="platform_icon" alt="upload file from nour platform"
                                                src="{{ URL::asset('img/icons/upload_nour/group2.svg') }}">
                                        </div>
                                        <h6 class="mb-0">تقارير الطلاب</h6>
                                    </a>
                                </li>
                                <li>
                                    <a class="d-flex align-items-center">
                                        <div class="icon-circle d-flex align-items-center justify-content-center me-2">
                                            <img class="platform_icon" alt="upload file from nour platform"
                                                src="{{ URL::asset('img/icons/upload_nour/group3.svg') }}">
                                        </div>
                                        <h6 class="mb-0">كشف الطلاب</h6>
                                    </a>
                                </li>
                                <li>
                                    <a class="d-flex align-items-center">
                                        <div class="icon-circle d-flex align-items-center justify-content-center me-2">
                                            <img class="platform_icon" alt="upload file from nour platform"
                                                src="{{ URL::asset('img/icons/upload_nour/group4.svg') }}">
                                        </div>
                                        <h6 class="mb-0">اختر</h6>
                                    </a>
                                </li>
                                <li>
                                    <a class="d-flex align-items-center">
                                        <div class="icon-circle d-flex align-items-center justify-content-center me-2">
                                            <img class="platform_icon" alt="upload file from nour platform"
                                                src="{{ URL::asset('img/icons/upload_nour/group5.svg') }}">
                                        </div>
                                        <h6 class="mb-0">عرض</h6>
                                    </a>
                                </li>
                                <li>
                                    <a class="d-flex align-items-center">
                                        <div class="icon-circle d-flex align-items-center justify-content-center me-2">
                                            <img class="platform_icon" alt="upload file from nour platform"
                                                src="{{ URL::asset('img/icons/upload_nour/group6.svg') }}">
                                        </div>
                                        <h6 class="mb-0">من (أيقونة الحفظ) اختر Excel</h6>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div>
            <div class="previous-form-steps progressbar_roadmap_previous_btn">
                <h6 class="mb-0 ms-2">السابق</h6>
                <i class="fas fa-chevron-up"></i>
            </div>

            <div class="progressbar_roadmap_next_btn" id="next_students">
                <h6 class="mb-0 ms-2">التالي</h6>
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </div>

    {{-------- 6- Entsab --------}}
    <div class="cont_tap" @if($roadmap==14) style="display: block" @else style="display: none" @endif id="entsab">
        <h5 class="text-gray-800 fw-bold mb-5">
            <svg class="me-2" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.77839 10.417C8.68256 10.4075 8.56756 10.4075 8.46214 10.417C6.18131 10.3404 4.37006 8.47163 4.37006 6.17163C4.37006 3.82371 6.26756 1.91663 8.62506 1.91663C10.973 1.91663 12.8801 3.82371 12.8801 6.17163C12.8705 8.47163 11.0593 10.3404 8.77839 10.417Z"
                    stroke="#444444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path
                    d="M15.7263 3.83325C17.5854 3.83325 19.0804 5.33784 19.0804 7.18742C19.0804 8.99867 17.6429 10.4745 15.8509 10.5416C15.7742 10.532 15.6879 10.532 15.6017 10.5416"
                    stroke="#444444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path
                    d="M3.98663 13.9533C1.66746 15.5058 1.66746 18.0358 3.98663 19.5787C6.62205 21.342 10.9442 21.342 13.5796 19.5787C15.8987 18.0262 15.8987 15.4962 13.5796 13.9533C10.9537 12.1995 6.63163 12.1995 3.98663 13.9533Z"
                    stroke="#444444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path
                    d="M17.5759 19.1666C18.2659 19.0229 18.9176 18.745 19.4543 18.3329C20.9493 17.2116 20.9493 15.362 19.4543 14.2408C18.9272 13.8383 18.2851 13.57 17.6047 13.4166"
                    stroke="#444444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            بيانات الطلاب
        </h5>

        <form id="myform_entsab" method="POST" enctype="multipart/form-data">
            @csrf
            <div>

                <div class="row mb-4">
                    <div class="col-12 col-md-4 col-xl-4 align-self-center">
                        <label class="form-label mb-2 mb-xl-0">هل لديك فصول انتساب؟
                            <span class="text-red fs-6">*</span></label>
                    </div>
                    <div class="col-12 col-md-7 col-xl-7">
                        <div class="d-flex">
                            <div class="check_custom_index me-5">
                                <input type="hidden" name="school" value="sec12saksa">
                                <input type="radio" id="have_entsab_yes" name="have_entsab" value="1">
                                <label for="have_entsab_yes">نعم</label>
                                <div class="check">
                                    <div class="inside"></div>
                                </div>
                            </div>
                            <div class="check_custom_index me-5">
                                <input type="radio" id="have_entsab_no" name="have_entsab" value="0">
                                <label for="have_entsab_no">لا</label>
                                <div class="check">
                                    <div class="inside"></div>
                                </div>
                            </div>
                        </div>
                        <div id="have_entsab-js_error_valid"></div>
                        @error('have_entsab')
                        <span class="error-msg-form">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>

                <div id="have_entsab_cont" style="display: none">

                    <hr>
                    <h6 class="mb-4 text-gray-400">يرجي تحديد فصول الانتساب</h6>

                    @foreach ($second_school_grades as $item)
                    <div class=" row mb-4">
                        <div class="col-12 col-md-4 col-xl-4 align-self-center">
                            <label class="form-label mb-2 mb-xl-0">{{ $item->name }}
                                <span class=" text-red fs-6">*</span></label>
                        </div>
                        <div class="col-12 col-md-7 col-xl-7">
                            <div class="d-flex">
                                <div class="check_custom_index me-5">
                                    <input checked type="radio" id="have_entsab_yes_{{ $item->id }}"
                                        name="have_entsab_{{ $item->id }}" value="1">
                                    <label for="have_entsab_yes_{{ $item->id }}">نعم</label>
                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </div>
                                <div class="check_custom_index me-5">
                                    <input type="radio" id="have_entsab_no_{{ $item->id }}"
                                        name="have_entsab_{{ $item->id }}" value="0">
                                    <label for="have_entsab_no_{{ $item->id }}">لا</label>
                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="have_entsab-js_error_valid"></div>
                            @error('have_entsab')
                            <span class="error-msg-form">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    @endforeach

                </div>

            </div>

            <div>
                <div class="previous-form-steps progressbar_roadmap_previous_btn">
                    <h6 class="mb-0 ms-2">السابق</h6>
                    <i class="fas fa-chevron-up"></i>
                </div>

                <div class="progressbar_roadmap_next_btn" id="next_entsab">
                    <h6 class="mb-0 ms-2">التالي</h6>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>

        </form>
    </div>

    {{-------- 7- Teachers --------}}
    <div class="cont_tap" @if($roadmap==15) style="display: block" @else style="display: none" @endif id="teachers">
        <h5 class="text-gray-800 fw-bold mb-3">
            <svg class="me-2" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M18.8497 7.3C20.5895 7.3 21.9997 5.88969 21.9997 4.15C21.9997 2.41031 20.5895 1 18.8497 1C17.11 1 15.6997 2.41031 15.6997 4.15C15.6997 5.88969 17.11 7.3 18.8497 7.3Z"
                    stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M6.25 12.5499H11.5" stroke="#444444" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M6.25 16.75H15.7" stroke="#444444" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M13.6 1H8.35C3.1 1 1 3.1 1 8.35V14.65C1 19.9 3.1 22 8.35 22H14.65C19.9 22 22 19.9 22 14.65V9.4"
                    stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            بيانات المعلمين
        </h5>

        <div class="mb-4">
            <div class="d-flex align-items-center mb-3">
                <h6 class="me-2 mb-0"> اعادة استيراد ملف المعلمين</h6>

                <form id="myform_teachers_resend" method="POST"
                    action="{{ route('school_route.roadmap_teachers_store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="text-center">
                        <label for="teachers_file_upload_resend"
                            class="link-cust-text main_btn border_radius_10 px-4 clickable-item-pointer text-xs p-0"
                            style="display: inline-block;min-height: 34px !important;padding-top: 5px !important;">
                            @if(count($teachers) > 0)
                            اعادة الاستيراد
                            @else
                            استيراد
                            @endif
                            <svg class="mb-2 ms-1" width="20" height="20" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17 8.2V13C17 16.2 16.2 17 13 17H5C1.8 17 1 16.2 1 13V5C1 1.8 1.8 1 5 1H6.2C7.4 1 7.664 1.352 8.12 1.96L9.32 3.56C9.624 3.96 9.8 4.2 10.6 4.2H13C16.2 4.2 17 5 17 8.2Z"
                                    fill="#FFFFFF" stroke="#FFFFFF" stroke-miterlimit="10" />
                                <path d="M9 13V8.19995" stroke="#0A3A81" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M6.59961 9.7999L8.99961 7.3999L11.3996 9.7999" stroke="#0A3A81"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </label>
                        <input type="hidden" name="school" value="sec12saksa">
                        <input id="teachers_file_upload_resend" name="teachers_file_upload"
                            class="custom_file_upload_input" type="file" accept=".xlsx" />
                    </div>
                </form>
            </div>

            @if(count($teachers) > 0)

            <h6> <i class="fas fa-info-circle fs-5 me-1 main-color"></i>عند استعادة استيراد ملف المعلمين سوف يتم مسح
                الملف الحالي</h6>
            @else
            <h6> <i class="fas fa-info-circle fs-5 me-1 main-color"></i>
                قم بتحميل ملف المعلمين الذي تم تحميله من نظام نور</h6>
            @endif
        </div>

        <div>

            <div class="row mb-4">
                <div class="col-12  align-self-center">

                    @if(count($teachers) == 0)
                    <div class="table-responsive">
                        <table class="table display normal_table" style="direction: " width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-xs fw-bold">اسم المعلم</th>
                                    <th class="text-xs fw-bold">السجل المدني</th>
                                    <th class="text-xs fw-bold">رقم الجوال</th>
                                    <th class="text-xs fw-bold">البريد الالكتروني</th>
                                    <th class="text-xs fw-bold">التخصص</th>
                                    <th class="text-xs fw-bold">العمل الحالي</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <form id="myform_teachers" method="POST" action="{{ route('school_route.roadmap_teachers_store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="text-center">

                            <label for="teachers_file_upload" class="custom_file_upload">
                                <svg class="mb-2" width="40" height="40" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17 8.2V13C17 16.2 16.2 17 13 17H5C1.8 17 1 16.2 1 13V5C1 1.8 1.8 1 5 1H6.2C7.4 1 7.664 1.352 8.12 1.96L9.32 3.56C9.624 3.96 9.8 4.2 10.6 4.2H13C16.2 4.2 17 5 17 8.2Z"
                                        fill="#0A3A81" stroke="#0A3A81" stroke-miterlimit="10" />
                                    <path d="M9 13V8.19995" stroke="#FFFFFF" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M6.59961 9.7999L8.99961 7.3999L11.3996 9.7999" stroke="#FFFFFF"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <h4 class="mb-0">اضغط هنا لاستيراد المعلمين</h4>
                                <p class=" text-gray-400">لم يتم استيراد بيانات المعلمين</p>
                            </label>
                            <input type="hidden" name="school" value="sec12saksa">
                            <input id="teachers_file_upload" name="teachers_file_upload"
                                class="custom_file_upload_input" type="file" accept=".xlsx" />
                        </div>
                    </form>
                    @else
                    <div class="table-responsive">
                        <table class="table display datatable-modal" style="direction: " id="p_2-table" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-xs fw-bold">اسم المعلم</th>
                                    <th class="text-xs fw-bold">السجل المدني</th>
                                    <th class="text-xs fw-bold">رقم الجوال</th>
                                    <th class="text-xs fw-bold">البريد الالكتروني</th>
                                    <th class="text-xs fw-bold">التخصص</th>
                                    <th class="text-xs fw-bold">العمل الحالي</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($teachers as $item)
                                <tr>
                                    <td class="">
                                        {{ $item->first_name }}
                                    </td>
                                    <td class="">
                                        {{ $item->identification_number }}
                                    </td>
                                    <td class="">
                                        {{ $item->phone_number }}
                                    </td>
                                    <td class="">
                                        {{ $item->email }}
                                    </td>
                                    <td class="">
                                        <select
                                            class="js-example-basic-single select2-hidden-accessible teacher_speciality_select"
                                            name="school_level" data-code="{{ $item->code }}">
                                            <option disabled selected>لا يوجد</option>
                                            @foreach ($teacher_specialities as $item_sp)
                                            <option value="{{ $item_sp->id }}" @if($item->teacher_speciality_id ==
                                                $item_sp->id) selected @endif>{{ $item_sp->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="">
                                        معلم
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>


                            <tfoot>
                                <tr>
                                    <th class="text-center fw-bold text-s">اجمالي عدد المعلمين</th>
                                    <th class="text-center fw-bold text-s">{{ count($teachers) }} معلم</th>

                                </tr>
                            </tfoot>

                        </table>
                    </div>
                    @endif

                    <div class="row pt-4">
                        <div class="col-12">
                            <h6 class="fw-bold">مسار تحميل الملف من نظام نور</h6>
                            <ul class="px-2 pe-md-4 progressbar_upload_file mb-0 mt-0 py-0" style="overflow: auto">
                                <li>
                                    <a class="d-flex align-items-center">
                                        <div class="icon-circle d-flex align-items-center justify-content-center me-2">
                                            <img class="platform_icon" alt="upload file from nour platform"
                                                src="{{ URL::asset('img/icons/upload_nour/group1.svg') }}">
                                        </div>
                                        <h6 class="mb-0">التقارير</h6>
                                    </a>
                                </li>
                                <li>
                                    <a class="d-flex align-items-center">
                                        <div class="icon-circle d-flex align-items-center justify-content-center me-2">
                                            <img class="platform_icon" alt="upload file from nour platform"
                                                src="{{ URL::asset('img/icons/upload_nour/group2.svg') }}">
                                        </div>
                                        <h6 class="mb-0">تقارير المعلمين</h6>
                                    </a>
                                </li>
                                <li>
                                    <a class="d-flex align-items-center">
                                        <div class="icon-circle d-flex align-items-center justify-content-center me-2">
                                            <img class="platform_icon" alt="upload file from nour platform"
                                                src="{{ URL::asset('img/icons/upload_nour/group3.svg') }}">
                                        </div>
                                        <h6 class="mb-0">بيانات معلمي المدرسة</h6>
                                    </a>
                                </li>
                                <li>
                                    <a class="d-flex align-items-center">
                                        <div class="icon-circle d-flex align-items-center justify-content-center me-2">
                                            <img class="platform_icon" alt="upload file from nour platform"
                                                src="{{ URL::asset('img/icons/upload_nour/group4.svg') }}">
                                        </div>
                                        <h6 class="mb-0">اختر</h6>
                                    </a>
                                </li>
                                <li>
                                    <a class="d-flex align-items-center">
                                        <div class="icon-circle d-flex align-items-center justify-content-center me-2">
                                            <img class="platform_icon" alt="upload file from nour platform"
                                                src="{{ URL::asset('img/icons/upload_nour/group5.svg') }}">
                                        </div>
                                        <h6 class="mb-0">عرض</h6>
                                    </a>
                                </li>
                                <li>
                                    <a class="d-flex align-items-center">
                                        <div class="icon-circle d-flex align-items-center justify-content-center me-2">
                                            <img class="platform_icon" alt="upload file from nour platform"
                                                src="{{ URL::asset('img/icons/upload_nour/group6.svg') }}">
                                        </div>
                                        <h6 class="mb-0">من (أيقونة الحفظ) اختر Excel</h6>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div>
            <div class="previous-form-steps progressbar_roadmap_previous_btn">
                <h6 class="mb-0 ms-2">السابق</h6>
                <i class="fas fa-chevron-up"></i>
            </div>

            <div class="progressbar_roadmap_next_btn" id="next_teachers">
                <h6 class="mb-0 ms-2">التالي</h6>
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </div>

    {{-------- 8- Administrator --------}}
    <div class="cont_tap" @if($roadmap==16) style="display: block" @else style="display: none" @endif
        id="administrator">
        <h5 class="text-gray-800 fw-bold mb-3">
            <svg class="me-2" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 7.17627H10.9711" stroke="#444444" stroke-width="1.5" stroke-miterlimit="10"
                    stroke-linecap="round" stroke-linejoin="round" />
                <path d="M5.19824 17.0591H7.29743" stroke="#444444" stroke-width="1.5" stroke-miterlimit="10"
                    stroke-linecap="round" stroke-linejoin="round" />
                <path d="M9.92188 17.0591H14.1202" stroke="#444444" stroke-width="1.5" stroke-miterlimit="10"
                    stroke-linecap="round" stroke-linejoin="round" />
                <path d="M5.20215 12.7356H14.6485" stroke="#444444" stroke-width="1.5" stroke-miterlimit="10"
                    stroke-linecap="round" stroke-linejoin="round" />
                <path
                    d="M21.9919 11.5371V16.5771C21.9919 20.9129 21.0577 22 17.3317 22H5.66019C1.93414 22 1 20.9129 1 16.5771V6.42294C1 2.08706 1.93414 1 5.66019 1H14.1199"
                    stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path
                    d="M18.9267 1.77814L15.0327 6.36108C14.8858 6.53402 14.7388 6.8799 14.7073 7.12696L14.4974 8.88108C14.4239 9.51113 14.8018 9.95584 15.3371 9.86937L16.8275 9.62231C17.0374 9.58525 17.3313 9.41231 17.4783 9.23937L21.3723 4.65637C22.044 3.86579 22.3589 2.95167 21.3723 1.79049C20.3751 0.616962 19.5984 0.98755 18.9267 1.77814Z"
                    stroke="black" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M18.3711 2.43286C18.707 3.82874 19.6306 4.9158 20.8061 5.29874" stroke="black"
                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            بيانات الاداريين
        </h5>

        <div class="mb-4">
            <div class="d-flex align-items-center mb-3">
                <h6 class="me-2 mb-0"> اضافة بيانات الاداريين</h6>

                <div class="link-cust-text main_btn border_radius_10 px-4 clickable-item-pointer text-xs"
                    data-bs-toggle="modal" data-bs-target="#add_new_administrator"> <i class="fas fa-plus"></i>
                    اضافة اداري
                </div>
            </div>
        </div>

        <div>

            <div class="row mb-4">
                <div class="col-12  align-self-center">

                    @if(count($administrators) == 0 )
                    <div class="table-responsive" id="admin_cont_add_new_empty">
                        <table class="table display normal_table" style="direction: " width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-xs fw-bold">اسم الاداري</th>
                                    <th class="text-xs fw-bold">السجل المدني</th>
                                    <th class="text-xs fw-bold">رقم الجوال</th>
                                    <th class="text-xs fw-bold">البريد الالكتروني</th>
                                    <th class="text-xs fw-bold">التخصص</th>
                                    <th class="text-xs fw-bold">العمل الحالي</th>
                                    <th class="text-xs fw-bold"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    @endif

                    <div class="text-center" id="admin_cont_add_new" @if(count($administrators)> 0 ) style="display:
                        none" @else style="display: block" @endif>
                        <div class="custom_file_upload" data-bs-toggle="modal" data-bs-target="#add_new_administrator">
                            <svg class="mb-2" width="40" height="40" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17 8.2V13C17 16.2 16.2 17 13 17H5C1.8 17 1 16.2 1 13V5C1 1.8 1.8 1 5 1H6.2C7.4 1 7.664 1.352 8.12 1.96L9.32 3.56C9.624 3.96 9.8 4.2 10.6 4.2H13C16.2 4.2 17 5 17 8.2Z"
                                    fill="#0A3A81" stroke="#0A3A81" stroke-miterlimit="10" />
                                <path d="M9 13V8.19995" stroke="#FFFFFF" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M6.59961 9.7999L8.99961 7.3999L11.3996 9.7999" stroke="#FFFFFF"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <h4 class="mb-0">اضغط هنا لاضافة اداري جديد</h4>
                            <p class=" text-gray-400">لم يتم اضافة اي اداري بعد</p>
                        </div>
                    </div>





                    <div class="table-responsive" id="admin_table_cont" @if(count($administrators)> 0 ) style="display:
                        block" @else style="display: none" @endif>
                        <table class="table display datatable-modal" style="direction: " id="p_3-table" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-xs fw-bold">اسم الاداري</th>
                                    <th class="text-xs fw-bold">السجل المدني</th>
                                    <th class="text-xs fw-bold">رقم الجوال</th>
                                    <th class="text-xs fw-bold">البريد الالكتروني</th>
                                    <th class="text-xs fw-bold">التخصص</th>
                                    <th class="text-xs fw-bold">العمل الحالي</th>
                                    <th class="text-xs fw-bold"></th>
                                </tr>
                            </thead>

                            <tbody id="admin_table_cont_tr">
                                @foreach ($administrators as $key => $item)
                                <tr id="row_{{ $item->code }}">
                                    <td class="">
                                        {{ $item->first_name }}
                                    </td>
                                    <td class="">
                                        {{ $item->identification_number }}
                                    </td>
                                    <td class="">
                                        {{ $item->phone_number }}
                                    </td>
                                    <td class="">
                                        {{ $item->email }}
                                    </td>
                                    <td class="">
                                        {{ $item->job->name }}
                                    </td>
                                    <td class="">
                                        {{ $item->teacher_speciality->name }}
                                    </td>
                                    <td>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fs-6 fa-fw text-gray-700"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item text-green update_admin" href="#"
                                                    data-code="{{ $item->code }}" data-name="{{ $item->first_name }}"
                                                    data-identification_number="{{ $item->identification_number }}"
                                                    data-phone_number="{{ $item->phone_number }}"
                                                    data-email="{{ $item->email }}"
                                                    data-school_job_id="{{ $item->school_job_id }}"
                                                    data-teacher_speciality_id="{{ $item->teacher_speciality_id }}"><i
                                                        class="fas fa-trash-alt me-1"></i>
                                                    تعديل</a>
                                                <a class="dropdown-item text-red" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#delete_admin_modal{{ $item->code }}"><i
                                                        class="fas fa-trash-alt me-1"></i>
                                                    حذف</a>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete_admin_modal{{ $item->code }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                                                <div class="modal-content b-r-s-cont border-0">

                                                    <div class="modal-header">
                                                        <div class="modal-title" id="exampleModalLabel"><i
                                                                class="fas fa-trash me-1"></i>
                                                            حذف الاداري </div>
                                                        <button type="button" data-bs-dismiss="modal"
                                                            aria-label="Close"><i class="fas fa-times"></i></button>
                                                    </div>
                                                    <form>

                                                        <!-- Modal content -->
                                                        <div class="modal-body px-4">
                                                            <div class="modal-body delete-conf-input text-center py-0">
                                                                <p class="mb-0">هل انت متاكد من حذف الاداري</p>
                                                                <br>
                                                                <input type="hidden" name="item_id"
                                                                    value="{{ $item->code }}">
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <div class="right-side">
                                                                <button type="button" data-code="{{ $item->code }}"
                                                                    class="btn btn-default btn-link text-red fw-bold delete_admin_btn">حذف
                                                                </button>
                                                            </div>
                                                            <div class="divider"></div>
                                                            <div class="left-side">
                                                                <button type="button" class="btn btn-default btn-link"
                                                                    data-bs-dismiss="modal">غلق النافذة</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>






                </div>
            </div>
        </div>

        {{-- Modal to add new administrator --}}
        <div class="modal fade" id="add_new_administrator" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true" style="overflow:hidden">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content b-r-s-cont border-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <svg class="me-2" width="23" height="23"
                                viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 7.17627H10.9711" stroke="#444444" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5.19824 17.0591H7.29743" stroke="#444444" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M9.92188 17.0591H14.1202" stroke="#444444" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5.20215 12.7356H14.6485" stroke="#444444" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M21.9919 11.5371V16.5771C21.9919 20.9129 21.0577 22 17.3317 22H5.66019C1.93414 22 1 20.9129 1 16.5771V6.42294C1 2.08706 1.93414 1 5.66019 1H14.1199"
                                    stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M18.9267 1.77814L15.0327 6.36108C14.8858 6.53402 14.7388 6.8799 14.7073 7.12696L14.4974 8.88108C14.4239 9.51113 14.8018 9.95584 15.3371 9.86937L16.8275 9.62231C17.0374 9.58525 17.3313 9.41231 17.4783 9.23937L21.3723 4.65637C22.044 3.86579 22.3589 2.95167 21.3723 1.79049C20.3751 0.616962 19.5984 0.98755 18.9267 1.77814Z"
                                    stroke="black" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M18.3711 2.43286C18.707 3.82874 19.6306 4.9158 20.8061 5.29874" stroke="black"
                                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            اضافة اداري جديد</h5>
                        <button type="button" data-bs-dismiss="modal" aria-label="Close"><i
                                class="fas fa-times"></i></button>
                    </div>

                    <form id="myform_admin" class="mb-0" style="display: contents;">

                        <!-- Modal content -->
                        <div class="modal-body px-5 py-3">

                            <div class="row mb-4">
                                <div class="col-12 col-md-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">الاسم
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input type="hidden" name="school" value="sec12saksa">
                                    <input name="admin_name" type="text" minlength="2" maxlength="100"
                                        class="form-control" maxlength="100" placeholder="اكتب هنا اسم الاداري .."
                                        value="{{ old('admin_name') }}" required>
                                    <div id="admin_name-js_error_valid"></div>
                                    @error('admin_name')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">السجل المدني
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input name="admin_identification_number" minlength="2" maxlength="100" type="text"
                                        class="form-control" maxlength="100" placeholder="اكتب هنا رقم السجل المدني .."
                                        value="{{ old('admin_identification_number') }}" required>
                                    <div id="admin_identification_number-js_error_valid"></div>
                                    @error('admin_identification_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">رقم الجوال
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input name="admin_phone_number" type="number" class="form-control" minlength="6"
                                        maxlength="100" placeholder="اكتب هنا رقم جوال الاداري .."
                                        value="{{ old('admin_phone_number') }}" required>
                                    <div id="admin_phone_number-js_error_valid"></div>
                                    @error('admin_phone_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">البريد الالكتروني
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input name="admin_email" type="email" class="form-control" minlength="5"
                                        maxlength="100" placeholder="اكتب هنا البريد الالكتروني للاداري .."
                                        value="{{ old('admin_email') }}" required>
                                    <div id="admin_email-js_error_valid"></div>
                                    @error('admin_email')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">العمل الحالي
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8">

                                    <select class="js-example-basic-single_admin select2-hidden-accessible"
                                        name="admin_school_job" required>
                                        @foreach ($school_jobs as $item_job)
                                        <option value="{{ $item_job->id }}">{{ $item_job->name }}</option>
                                        @endforeach
                                    </select>

                                    <div id="admin_school_job-js_error_valid"></div>
                                    @error('admin_school_job')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">التخصص
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8">

                                    <select class="js-example-basic-single_admin select2-hidden-accessible"
                                        name="admin_speciality_id" required>
                                        @foreach ($teacher_specialities as $item_sp)
                                        <option value="{{ $item_sp->id }}">{{ $item_sp->name }}</option>
                                        @endforeach
                                    </select>

                                    <div id="admin_speciality_id-js_error_valid"></div>
                                    @error('admin_speciality_id')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="right-side">
                                <button id="new_admin_btn" type="button"
                                    class="btn btn-default btn-link main-color fw-bold">اضافة
                                    جديدة</button>
                            </div>
                            <div class="divider"></div>
                            <div class="left-side">
                                <button type="button" class="btn btn-default btn-link" data-bs-dismiss="modal">غلق
                                    النافذة</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        {{-- Modal to update administrator --}}
        <div class="modal fade" id="update_new_administrator" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true" style="overflow:hidden">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content b-r-s-cont border-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <svg class="me-2" width="23" height="23"
                                viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 7.17627H10.9711" stroke="#444444" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5.19824 17.0591H7.29743" stroke="#444444" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M9.92188 17.0591H14.1202" stroke="#444444" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5.20215 12.7356H14.6485" stroke="#444444" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M21.9919 11.5371V16.5771C21.9919 20.9129 21.0577 22 17.3317 22H5.66019C1.93414 22 1 20.9129 1 16.5771V6.42294C1 2.08706 1.93414 1 5.66019 1H14.1199"
                                    stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M18.9267 1.77814L15.0327 6.36108C14.8858 6.53402 14.7388 6.8799 14.7073 7.12696L14.4974 8.88108C14.4239 9.51113 14.8018 9.95584 15.3371 9.86937L16.8275 9.62231C17.0374 9.58525 17.3313 9.41231 17.4783 9.23937L21.3723 4.65637C22.044 3.86579 22.3589 2.95167 21.3723 1.79049C20.3751 0.616962 19.5984 0.98755 18.9267 1.77814Z"
                                    stroke="black" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M18.3711 2.43286C18.707 3.82874 19.6306 4.9158 20.8061 5.29874" stroke="black"
                                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            تعديل اداري</h5>
                        <button type="button" data-bs-dismiss="modal" aria-label="Close"><i
                                class="fas fa-times"></i></button>
                    </div>

                    <form id="myform_update_admin" class="mb-0" style="display: contents;">

                        <!-- Modal content -->
                        <div class="modal-body px-5 py-3">

                            <div class="row mb-4">
                                <div class="col-12 col-md-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">الاسم
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input type="hidden" name="school" value="sec12saksa">
                                    <input name="admin_index_update" type="hidden" required>
                                    <input name="admin_code_update" type="hidden" required>
                                    <input name="admin_name_update" type="text" minlength="2" maxlength="100"
                                        class="form-control" maxlength="100" placeholder="اكتب هنا اسم الاداري .."
                                        required>
                                    <div id="admin_name-js_error_valid"></div>
                                    @error('admin_name')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">السجل المدني
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input name="admin_identification_number_update" minlength="2" maxlength="100"
                                        type="text" class="form-control" maxlength="100"
                                        placeholder="اكتب هنا رقم السجل المدني .." required>
                                    <div id="admin_identification_number-js_error_valid"></div>
                                    @error('admin_identification_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">رقم الجوال
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input name="admin_phone_number_update" type="number" class="form-control"
                                        minlength="6" maxlength="100" placeholder="اكتب هنا رقم جوال الاداري .."
                                        required>
                                    <div id="admin_phone_number-js_error_valid"></div>
                                    @error('admin_phone_number')
                                    <span class="error-msg-form">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">البريد الالكتروني
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input name="admin_email_update" type="email" class="form-control" minlength="5"
                                        maxlength="100" placeholder="اكتب هنا البريد الالكتروني للاداري .." required>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">العمل الحالي
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8">

                                    <select class="js-example-basic-single_admin_update select2-hidden-accessible"
                                        name="admin_school_job_update" id="admin_school_job_update" required>
                                        @foreach ($school_jobs as $item_job)
                                        <option value="{{ $item_job->id }}">{{ $item_job->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-4 align-self-center">
                                    <label class="form-label mb-2 mb-xl-0">التخصص
                                        <span class=" text-red fs-6">*</span></label>
                                </div>
                                <div class="col-12 col-md-8">

                                    <select class="js-example-basic-single_admin_update select2-hidden-accessible"
                                        name="admin_speciality_id_update" id="admin_speciality_id_update" required>
                                        @foreach ($teacher_specialities as $item_sp)
                                        <option value="{{ $item_sp->id }}">{{ $item_sp->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="right-side">
                                <button id="update_admin_btn" type="button"
                                    class="btn btn-default btn-link main-color fw-bold">تعديل الاداري</button>
                            </div>
                            <div class="divider"></div>
                            <div class="left-side">
                                <button type="button" class="btn btn-default btn-link" data-bs-dismiss="modal">غلق
                                    النافذة</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
        <div>
            <div class="previous-form-steps progressbar_roadmap_previous_btn">
                <h6 class="mb-0 ms-2">السابق</h6>
                <i class="fas fa-chevron-up"></i>
            </div>

            <div class="progressbar_roadmap_next_btn" id="next_administrators">
                <h6 class="mb-0 ms-2">التالي</h6>
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </div>

    {{-------- 9- other Info --------}}
    <div class="cont_tap" @if($roadmap==17) style="display: block" @else style="display: none" @endif id="other_info">
        <h5 class="text-gray-800 fw-bold mb-5"><svg class="me-2" width="25" height="25" viewBox="0 0 27 27" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M25.2955 13.2247V7.62534C25.2955 2.32829 23.9521 1.00073 18.5499 1.00073H7.74558C2.3434 1.00073 1 2.32829 1 7.62534V22.4255C1 25.9218 7.83132 25.3172 10.2895 25.3172"
                    stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M7.43164 7.57288H18.8648" stroke="black" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M7.5332 12.8301H17.4352M7.5332 17.5244H17.4352" stroke="black" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round" />
                <path
                    d="M22.0264 17.7861L16.9672 22.4391C16.7672 22.6231 16.5814 22.9649 16.5385 23.2146L16.267 24.9891C16.1669 25.6331 16.6528 26.08 17.3531 25.988L19.2825 25.7383C19.554 25.6989 19.9399 25.528 20.1257 25.344L25.1848 20.691C26.0566 19.8892 26.4711 18.956 25.1848 17.773C23.9129 16.6032 22.8982 16.9844 22.0264 17.7861Z"
                    stroke="black" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M21.2949 18.4565C21.7237 19.8761 22.9242 20.9802 24.4676 21.3745" stroke="black"
                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            بيانات اخري
        </h5>

        <form id="myform_other_info" method="POST" enctype="multipart/form-data">
            @csrf

            <div>
                <div class="row mb-4">
                    <div class="col-12 col-md-4 col-xl-4 align-self-center">
                        <label class="form-label mb-2 mb-xl-0">هاتف المدرسة</label>
                    </div>
                    <div class="col-12 col-md-7 col-xl-7">
                        <input type="hidden" name="school" value="sec12saksa">
                        <input name="school_telephone" type="text" class="form-control" maxlength="100"
                            placeholder="01XXXXXXXX" value="@if($second_school){{ $second_school->telephone }}@endif">
                        <div id="school_telephone-js_error_valid"></div>
                        @error('school_telephone')
                        <span class="error-msg-form">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12 col-md-4 col-xl-4 align-self-center">
                        <label class="form-label mb-2 mb-xl-0">رقم الجوال
                            <span class=" text-red fs-6">*</span></label>
                    </div>
                    <div class="col-12 col-md-5 mb-2 mb-md-0">
                        <input name="school_phone_number" type="text" minlength="4" maxlength="40" class="form-control"
                            placeholder="5XXXXXXXX" value="@if($second_school){{ $second_school->phone_number }}@endif"
                            required>
                        <div id="school_phone_number-js_error_valid"></div>
                        @error('school_phone_number')
                        <span class="error-msg-form">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="col-12 col-md-3 position-relative">
                        <img class=" position-absolute" alt="whatsapp" style="right: 20px;
                        top: 11px;" src="{{ URL::asset('img/icons/roadmap/whatsapp.svg') }}">
                        <div class=" position-absolute" alt="whatsapp" style="left: 20px;
                        top: 11px;">
                            <label class="form-label mb-2 mb-xl-0 fw-bold text-gray-800"><span
                                    class="text-gray-400 clickable-item-pointer me-1" href="#" data-bs-toggle="tooltip"
                                    data-bs-title="تجاهل الخانة اذا لم يكن لدى المدرسة واتس آب مفعل"><i
                                        class="fas fa-info-circle main-color fs-5"></i></span></label>
                        </div>
                        <input name="school_whatsapp" type="text" minlength="4" maxlength="40" class="form-control ps-5"
                            placeholder="+966 5XX XXX XXX"
                            value="@if($second_school){{ $second_school->whatsapp }}@endif">
                        <div id="school_whatsapp-js_error_valid"></div>
                        @error('school_whatsapp')
                        <span class="error-msg-form">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                </div>
                <div class="row mb-4">
                    <div class="col-12 col-md-4 col-xl-4 align-self-center">
                        <label class="form-label mb-2 mb-xl-0">تويتر المدرسة
                            <span class=" text-red fs-6">*</span></label>
                    </div>
                    <div class="col-12 col-md-7 col-xl-7">
                        <input name="school_twitter" type="text" minlength="4" maxlength="40" class="form-control"
                            placeholder="@username" value="@if($second_school){{ $second_school->twitter }}@endif"
                            required>
                        <div id="school_twitter-js_error_valid"></div>
                        @error('school_twitter')
                        <span class="error-msg-form">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12 col-md-4 col-xl-4 align-self-center">
                        <label class="form-label mb-2 mb-xl-0">الموقع الالكتروني</label>
                    </div>
                    <div class="col-12 col-md-7 col-xl-7">
                        <input name="school_website" type="text" minlength="5" maxlength="40" class="form-control"
                            placeholder="www.website.com"
                            value="@if($second_school){{ $second_school->website }}@endif">
                        <div id="school_website-js_error_valid"></div>
                        @error('school_website')
                        <span class="error-msg-form">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <hr>
                <h6>مواقع تواصل اجتماعية أخرى يمكنك إضافتها</h6>
                <div class="row mb-4">
                    <div class="col-12 col-md-4 col-xl-4 align-self-center">
                        <label class="form-label mb-2 mb-xl-0">فيسبوك</label>
                    </div>
                    <div class="col-12 col-md-7 col-xl-7">
                        <input name="school_facebook" type="text" minlength="2" maxlength="40" class="form-control"
                            placeholder="User Name" value="@if($second_school){{ $second_school->facebook }}@endif">
                        <div id="school_facebook-js_error_valid"></div>
                        @error('school_facebook')
                        <span class="error-msg-form">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12 col-md-4 col-xl-4 align-self-center">
                        <label class="form-label mb-2 mb-xl-0">سناب شات</label>
                    </div>
                    <div class="col-12 col-md-7 col-xl-7">
                        <input name="school_snapchat" type="text" minlength="2" maxlength="40" class="form-control"
                            placeholder="@username" value="@if($second_school){{ $second_school->snapchat }}@endif">
                        <div id="school_snapchat-js_error_valid"></div>
                        @error('school_snapchat')
                        <span class="error-msg-form">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12 col-md-4 col-xl-4 align-self-center">
                        <label class="form-label mb-2 mb-xl-0">تيك توك</label>
                    </div>
                    <div class="col-12 col-md-7 col-xl-7">
                        <input name="school_tiktok" type="text" minlength="2" maxlength="40" class="form-control"
                            placeholder="@username" value="@if($second_school){{ $second_school->tiktok }}@endif">
                        <div id="school_tiktok-js_error_valid"></div>
                        @error('school_tiktok')
                        <span class="error-msg-form">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12 col-md-4 col-xl-4 align-self-center">
                        <label class="form-label mb-2 mb-xl-0">تيلغرام</label>
                    </div>
                    <div class="col-12 col-md-7 col-xl-7">
                        <input name="school_telegram" type="text" minlength="2" maxlength="40" class="form-control"
                            placeholder="@username" value="@if($second_school){{ $second_school->telegram }}@endif">
                        <div id="school_tiktok-js_error_valid"></div>
                        @error('school_telegram')
                        <span class="error-msg-form">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div>
                <div class="previous-form-steps progressbar_roadmap_previous_btn">
                    <h6 class="mb-0 ms-2">السابق</h6>
                    <i class="fas fa-chevron-up"></i>
                </div>

                <div class="progressbar_roadmap_next_btn" id="other_info_btn">
                    <h6 class="mb-0 ms-2">التالي</h6>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>

        </form>
    </div>


    {{-------- 10- finish --------}}
    <div class="cont_tap" @if($roadmap==18) style="display: block" @else style="display: none" @endif id="other_info">

        <div class="text-center" id="cong_page" style="display: none">
            <img alt="finished roadmap" class="mb-4" src="{{ URL::asset('img/icons/roadmap/done_2.svg') }}">

            <h3 class="mb-4 fw-bold">اهلا بك في منصة لام<br>
                انت الان في {{ Auth::guard('school')->user()->first_school->name }}
            </h3>
            <div class="d-flex align-items-center text-center justify-content-center">
                <h6 class="me-2">اذا لم يتم نقلك الى الواجهة الرئيسية فضلا </h6>
                <a href="{{ route('school_route.dashboard') }}" id="move_to_next_school" type="button"
                    class="main_btn border_radius_20 px-5 fw-bold finished_roadmap_btn me-3">اضغط هنا</a>
            </div>
        </div>

        <div class="text-center py-5" id="choose_school_page">
            <img alt="finished roadmap" class="mb-4" src="{{ URL::asset('img/icons/roadmap/done_1.svg') }}">
            <h6 class="mb-4">تهانينا ، لقد أنهيت إدخال كافة بيانات مدرستك بنجاح <br>
                يمكنك الان البدء في استخدام نظام لام .
            </h6>

            <a href="#" id="move_to_next_school" type="button" data-school_type="1"
                class="main_btn border_radius_20 px-5 fw-bold finished_roadmap_btn me-3">انتقل الي {{
                Auth::guard('school')->user()->first_school->name }}</a>

            <a href="#" id="move_to_dashboard" type="button" data-school_type="2"
                class="main_btn border_radius_20 px-5 fw-bold finished_roadmap_btn">
                @if(Auth::guard('school')->user()->second_school)
                انتقل الى
                {{ Auth::guard('school')->user()->second_school->name }}
                @endif
            </a>
        </div>

    </div>

</div>
</div>

@endsection

<!-- js insert -->
@section('js')

{{------ Roadmap js ------}}
@include('website.roadmap.components.js')


@endsection
