@extends('website.school.layouts.master', ['no_header' => true, 'no_transparent_header' => false])
@section('title', 'انشاء تكليف')
@section('topbar', 'انشاء تكليف')

@php
    $action = isset($item_val['id']) ? route('school_route.single_assignment.update', $item_val['id']) : route('school_route.single_assignment.store');
    $method = isset($item_val['id']) ? 'PUT' : 'POST';
    $text = isset($item_val['id']) ? 'تعديل' : 'إنشاء';
    @endphp
@section('fixedcontent')
    <!-- Your fixed content here -->
@endsection
@section('css')

    <link rel="stylesheet" href="{{ URL::asset('css/hijry/bootstrap-datetimepicker.css') }}" />


@endsection
<!-- content insert -->
@section('content')
    <div class="container-fluid px-4 px-md-5 py-3 py-md-4">
        <div class="page_top_nevg">
            <a href="#">التكليفات</a>
            <i class="fas fa-caret-left"></i>
            <a href="#">إدارة المدرسة</a>
            <i class="fas fa-caret-left"></i>
            <a href="#">تكليف مدير المدرسة</a>


        </div>
        <div class="sprint-4">
            <div class="AssignmentOfTheSchoolDirector">
                <h1 style="font-size: 22px; font-weight: 700; text-align: center;">
                    {{$text}} {{   $AssignmentItem['name'] }}</h1>
                @if($AssignmentItem['classification_id']!=5)
                <div class="header-info">
                    <table>
                        @foreach($AssignmentItem['header_items_data'] as $key => $header_item_data)
                        <tr>
                            <th><?php echo $key ?></th>
                            <td><?php echo $header_item_data ?></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif
                <form id="myform" class="myform" method="POST" action="{{ $action }}"
                      enctype="multipart/form-data">                                                    @csrf
                    @if(isset($item_val['id']))
                        @method($method)
                        <!-- Laravel's method spoofing for PUT request -->
                    @endif

                    @csrf

                    @if($AssignmentItem['classification_id']==5)
                        <div class="form-group" style="margin-bottom:48px">
                            <div>
                                <div class="row">
                                    <div class="col-12 col-md-4 col-xl-2 align-self-center">
                                        <label for="assignment_goal" class="form-label bold_form_label "> بشأن
                                            <span style="color:red; font-size:20px">*</span>
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-8 col-xl-10 align-self-center" style="max-width: 355px;">
                  <textarea name="assignment_goal" placeholder="تفاصيل التكليف" maxlength="140"
                            style="width: 638px; height: 110px; padding: 15px; background-color: #F1F1F1; border: none; border-radius: 8px; resize: none;"></textarea>
                                        <div id="school_level-js_error_valid"></div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:48px; margin-top:5px;">
                                    <span class="col-12 col-md-4 col-xl-2 align-self-center"></span>
                                    <div style="color:#979797; font-size: 14px; width: 350px;"
                                         class="ol-12 col-md-8 col-xl-10 align-self-center d-flex align-items-center">
                                        <img src="http://localhost/lam-ui-last/assets/icons/hint_icon.svg" alt="info" style="margin-left:8px">
                                        <span>أقصى عدد حروف مسموح به 140 حرف</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif

                    <div>
                        <div class="form-group" style="margin-bottom:48px">
                            <div class="row">
                                <div class="col-12 col-md-4 col-xl-2 align-self-center ">
                                    <label for="committee" class="form-label bold_form_label ">
                                        اليوم و التاريخ
                                        </label>
                                </div>
                                <div class="col-12 col-md-8 col-xl-10" style="max-width: 355px;">
                                    <div class="input-group">
                                        <input name="assignment_start_date" type="text"
                                               class="hijri-date-input form-control border-left-0 clickable-item-pointer "
                                               placeholder="تاريخ الاجتماع"
                                               @if(isset($item_val['assignment_start_date'])) value="{{$item_val['assignment_start_date']}}" @endif required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <img class="platform_icon" alt="school"   src="https://factoryfiy.com/img/icons/calendar.svg">
                                            </div>
                                        </div>
                                        <input type="hidden" name="assignment_item_id" value="{{$AssignmentItem['id']}}">
                                        <input type="hidden" name="is_committe_or_team" value="{{$AssignmentItem['classification_id']===4?1:0}}">
{{--                                        <input type="hidden" name="committe_team_id" value="{{$AssignmentItem['committe_team_id']}}">--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($AssignmentItem['classification_id']==5)
                    <div class="row" style="margin-bottom:48px;">
                        <div class="col-12 col-md-4 col-xl-2 align-self-center">
                            <label class="form-label mb-2 mb-xl-0">
                                مدة التكليف
                            </label>
                        </div>
                        <div class="col-12 col-md-8 col-xl-10 align-self-center" style="max-width: 355px;">
                            <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="assignment_duration"
                                    required>
                                <option value="" disabled selected>مدة التكليف</option>
                                <option value="عام دراسي">عام دراسي</option>
                                <option value="فصل دراسي">فصل دراسي</option>
                                <option value="فصلين دراسيين">فصلين دراسيين</option>
                            </select>
                            <div id="school_level-js_error_valid"></div>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="row">
                            <div class="col-12 col-md-4 col-xl-2 align-self-center">
                                <label class="form-label mb-2 mb-xl-0">
                                    اسم المكلف
                                </label>
                            </div>
                            <div class="col-12 col-md-8 col-xl-10 align-self-center" style="max-width: 355px;">
                                <select class="js-example-basic-multiple select2-no-search select2-hidden-accessible" multiple="multiple" name="assignment_users[]"
                                        required>
                                    <option value="all">الجميع</option>
                                @foreach($Managers as $index => $Manager)

                                    <option value="{{$Manager['id']}}" data-identification_number="{{$Manager['identification_number']}}"
                                            data-teacher_speciality="{{$Manager['teacher_speciality']?$Manager['teacher_speciality']['name']:''}}"
                                            @if(isset($assignedUserIds) && in_array($Manager['id'], $assignedUserIds)) selected @endif


                                    >{{$Manager['first_name']}}</option>
                                @endforeach
                                </select>
                                <div id="school_level-js_error_valid"></div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:48px; margin-top:5px;">
                            <span class="col-12 col-md-4 col-xl-2 align-self-center"></span>
                            <div style="color:#979797; font-size: 14px; width: 350px;"
                                 class="ol-12 col-md-8 col-xl-10 align-self-center d-flex align-items-center justify-content-center">
                                <img src="http://localhost/lam-ui-last/assets/icons/hint_icon.svg" alt="info" style="margin-left:8px">
                                <span>يمكنك إختيار تكليف معلم أو أكثر من القائمة المنسدلة</span>
                            </div>
                        </div>
                        <!-- Stat of Show select data table -->
                        <div class="lam_accordion_body" id="khaled"
                             style="padding:24px 0; background-color:#F1F1F1; width:85%; margin: 0 auto 48px auto; border-radius: 10px; padding: 24px; display: none;">
                            <!-- Start Header of table -->
                            <div class="row"
                                 style="color:#0A3A81;font-weight: 700; background-color: #EAB977; margin: 0; border-radius: 10px 10px 0px 0px; text-align: center; align-items: center; min-height: 53px;">
                                <p class="col-1">م</p>
                                <p class="col">اسم الشخص المكلف</p>
                                <p class="col">رقم السجل المدني</p>
                                <p class="col">التخصص</p>
                                <p class="col">حذف</p>
                            </div>
                            <!-- End Header of table -->
                            <!-- Start of Data Table -->
                            <div id="selectedOptions">


                            </div>
                            <!-- End of Data Table -->
                        </div>
                        <!-- End of Show select data table -->
                    </div>

                    <div class="row" style="margin-bottom:48px">
                        <div class="col-12 col-md-4 col-xl-2 align-self-center">
                            <label class="form-label mb-2 mb-xl-0"> رقم السجل المدني
                            </label>
                        </div>
                        <div class="col-12 col-md-8 col-xl-10" style="max-width: 355px;">
                            <input id="identification_number" type="text" class="form-control" maxlength="100" disabled
                                   @if(isset($assignedUserIds) && count($assignedUserIds) === 1)
                                       @foreach($Managers as $Manager)
                                           @if(in_array($Manager['id'], $assignedUserIds))
                                               value="{{ $Manager['identification_number'] }}"
                                   @endif
                                   @endforeach
                                   @endif
                                   placeholder="" >
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="main_btn px-5 border_radius_5">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

        function updateDisplayForSelectedUsers() {
            const selectedValues = $('.js-example-basic-multiple').val() || [];
            const selectedOptionsDiv = $('#selectedOptions');
            selectedOptionsDiv.empty(); // Clear the current display

            // Append user information for each selected value
            selectedValues.forEach((value, index) => {

                if (value.includes('all')) {
                    // Select all options except for the "all" option
                    const allValuesExceptAll = $(this).find('option').not('[value="all"]').map(function() {
                        return this.value;
                    }).get();

                    $(this).val(allValuesExceptAll).trigger('change');
                    // After selecting all, you might want to immediately return or adjust the flow to avoid infinite recursion or unwanted behavior
                    return; // Adjust based on your needs
                }

                if (value !== 'all') {
                    const optionElement = $(`.js-example-basic-multiple option[value="${value}"]`);
                    const identificationNumber = optionElement.data('identification_number');
                    const teacherSpeciality = optionElement.data('teacher_speciality');
                    const optionText = optionElement.text();

                    selectedOptionsDiv.append(`
                    <div class="col">
                        <div class="lam_accordion_row">
                            <div class="row" style="margin: 0; text-align: center; align-items: center; min-height: 53px;">
                                <p class="col-1">${index + 1}</p>
                                <p class="col">${optionText}</p>
                                <p class="col">${identificationNumber ? identificationNumber : ''}</p>
                                <p class="col">${teacherSpeciality ? teacherSpeciality : ''}</p>
                                <div class="col">
                                    <button class="delete-btn" data-value="${value}" style="background-color: transparent; border: none;">
                                        <img src="http://localhost/lam-ui-last/assets/icons/delete-icon.svg" width="20" height="20" style="margin-left: 5px;" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
                }
            });

            // Show or hide the main div based on whether there are selected users
            const hideMainDiv = selectedValues.length === 0;
            $('.lam_accordion_body').toggle(!hideMainDiv);
        }


        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder: 'اسم المكلف',
                width: '100%', // Adjust the width as needed
                allowClear: true, // Add a clear button
            });
            updateDisplayForSelectedUsers();

            // Handle "Select All" option
            $('.js-example-basic-multiple').on('change', function() {
                const selectedValues = $(this).val();
                const selectedOptionsDiv = $('#selectedOptions');
                selectedOptionsDiv.empty();

                // Handle "Select All" functionality
                if (selectedValues && selectedValues.includes('all')) {
                    // Select all options except for the "all" option
                    const allValuesExceptAll = $(this).find('option').not('[value="all"]').map(function() {
                        return this.value;
                    }).get();

                    $(this).val(allValuesExceptAll).trigger('change');
                    // After selecting all, you might want to immediately return or adjust the flow to avoid infinite recursion or unwanted behavior
                    return; // Adjust based on your needs
                }
                if (selectedValues){
                    // When only one option is selected, directly fetch its data attribute
                    if (selectedValues.length === 1) {
                        const optionElement = $('.js-example-basic-multiple').find(":selected");
                        $('#identification_number').val(optionElement.data("identification_number"));
                    }

                // Iterate over selected values to append information
                selectedValues.forEach((value, index) => {
                    // Find the corresponding option element for additional data
                    const optionElement = $(`option[value="${value}"]`, this);
                    const identificationNumber = optionElement.data('identification_number');
                    const teacherSpeciality = optionElement.data('teacher_speciality');
                    const optionText = optionElement.text(); // Get the visible text

                    // Append the information
                    selectedOptionsDiv.append(`<div class="col">
            <div class="lam_accordion_row">
                <div class="row" style="margin: 0; text-align: center; align-items: center; min-height: 53px;">
                     <p class="col-1">${index + 1}</p>
                    <p class="col">${optionText}</p>
                    <p class="col">${identificationNumber ? identificationNumber : ''}</p>
                    <p class="col">${teacherSpeciality ? teacherSpeciality : ''}</p>
                    <div class="col">
                        <button class="delete-btn" data-index="${value}" style="background-color: transparent; border: none;">
                            <img src="http://localhost/lam-ui-last/assets/icons/delete-icon.svg" width="20" height="20" style="margin-left: 5px;" />
                        </button>
                    </div>
                </div>
            </div>
        </div>`);
                });
                // Check if there are selected values
                const hideMainDiv = !selectedValues || selectedValues.length === 0;

                // Toggle the visibility of the main div based on the condition
                $('.lam_accordion_body').toggle(!hideMainDiv);

                // Attach a click event to the delete buttons
                $('.delete-btn').on('click', function() {
                    const indexToRemove = $(this).data('index');
                    selectedValues.splice(indexToRemove, 1);
                    $(this).closest('.lam_accordion_row').remove();

                    // Update the selected values
                    $(this).closest('.js-example-basic-multiple').val(selectedValues).trigger('change');
                });
                }
                // Additional logic to handle UI changes or deletions as required
            });
        });
    </script>
</script>

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



    </script>

    <script src="{{ URL::asset('js/meetings/meetings_custom_js.js') }}"></script>

@endsection
