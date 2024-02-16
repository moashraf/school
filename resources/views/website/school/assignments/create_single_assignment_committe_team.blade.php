@extends('website.school.layouts.master', ['no_header' => true, 'no_transparent_header' => false])
@section('title', 'انشاء تكليف')
@section('topbar', 'انشاء تكليف')


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
                <h1 style="font-size: 22px; font-weight: 700; text-align: center;">إنشاء
                {{   $Committees_and_teams['title'] }}</h1>
                <div class="header-info">
                    <table>
                         <tr>
                            <th>اسم اللجنه  </th>
                            <td> {{   $Committees_and_teams['title'] }} </td>
                        </tr>

                        <tr>
                            <th>اهداف  اللجنه  </th>
                            <td> {{   $Committees_and_teams['title'] }} </td>
                        </tr>

                        <tr>
                            <th>    قواعد تشكيل اللجنه   </th>
                            <td> {{   $Committees_and_teams['title'] }} </td>
                        </tr>

                     </table>
                </div>
                <form id="myform" class="myform" method="POST" action="{{ route('school_route.single_assignment.store') }}"
                      enctype="multipart/form-data">
                    @csrf
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
                                               placeholder="تاريخ الاجتماع" value="" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <img class="platform_icon" alt="school"   src="https://factoryfiy.com/img/icons/calendar.svg">
                                            </div>
                                        </div>
                                        <input type="hidden" name="assignment_item_id" value="0">
                                        <input type="hidden" name="is_committe_or_team" value="{{ $Committees_and_teams['id'] }}">
{{--                                        <input type="hidden" name="committe_team_id" value="{{$AssignmentItem['committe_team_id']}}">--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>

                        <div class="row" style="margin-bottom:48px; margin-top:5px;">
                            <span class="col-12 col-md-4 col-xl-2 align-self-center"></span>
                            <div style="color:#979797; font-size: 14px; width: 350px;"
                                 class="ol-12 col-md-8 col-xl-10 align-self-center d-flex align-items-center justify-content-center">
                                <img src="http://localhost/lam-ui-last/assets/icons/hint_icon.svg" alt="info" style="margin-left:8px">
                                <span>يمكنك إختيار تكليف معلم أو أكثر من القائمة المنسدلة</span>
                            </div>
                        </div>
                    </div>

                    <div class="main_data">
                        <h3>أختيار أعضاء اللجنة</h3>
                        <div class="lam_accordion_body AdministrativeCommittee_table"
                             style="margin:24px 0; background-color: #F1F1F1; border-radius: 10px; padding-top: 0">
                            <!-- Start Header of table -->
                            <div class="row"
                                 style="color:#0A3A81;font-weight: 700; background-color: #EAB977; margin: 0; border-radius: 10px 10px 0px 0px; text-align: center; align-items: center; min-height: 53px;">
                                <p class="col-1">م</p>
                                <p class="col">اسم الشخص المكلف</p>
                                <p class="col">المسمي الوظيفي</p>
                                <p class="col">العمل المكلف به</p>
                            </div>
                            <!-- End Header of table -->
                            <!-- Start of Data Table -->
                            <div class="row" style="margin: 0; text-align: center; align-items: center; min-height: 53px; ">
                                <p class="col-1"> </p>
                                <div class="col">
                                    <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="school_level"
                                            required>
                                        @foreach($Managers as $index => $Manager)
                                            <option value="{{$Manager['id']}}" >{{$Manager['first_name']}}</option>
                                        @endforeach                                    </select>
                                </div>
                                <p class="col">مدير المدرسة</p>
                                <p class="col">رئيسا للجنة</p>
                            </div>

                            <div class="row" style="margin: 0; text-align: center; align-items: center; min-height: 53px; ">
                                <p class="col-1"> </p>
                                <div class="col">
                                    <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="school_level"
                                            required>

                                        @foreach($Managers as $index => $Manager)
                                            <option value="{{$Manager['id']}}" >{{$Manager['first_name']}}</option>
                                        @endforeach
                                     </select>
                                </div>
                                <p class="col">وكيل المدرسة للشؤون التعليمية</p>
                                <p class="col">عضو</p>
                            </div>

                            <div class="row" style="margin: 0; text-align: center; align-items: center; min-height: 53px; ">
                                <p class="col-1"> </p>
                                <div class="col">
                                    <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="school_level"
                                            required>
                                        @foreach($Managers as $index => $Manager)
                                            <option value="{{$Manager['id']}}" >{{$Manager['first_name']}}</option>
                                        @endforeach                                    </select>
                                </div>
                                <p class="col">وكيل المدرسة لشؤون الطلاب</p>
                                <p class="col">عضو</p>
                            </div>

                            <div class="row" style="margin: 0; text-align: center; align-items: center; min-height: 53px; ">
                                <p class="col-1"> </p>
                                <div class="col">
                                    <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="school_level"
                                            required>
                                        @foreach($Managers as $index => $Manager)
                                            <option value="{{$Manager['id']}}" >{{$Manager['first_name']}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <p class="col">وكيل المدرسة للشؤون المدرسية</p>
                                <p class="col">عضو</p>
                            </div>

                            <div class="row" style="margin: 0; text-align: center; align-items: center; min-height: 53px; ">
                                <p class="col-1"> </p>
                                <div class="col">
                                    <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="school_level"
                                            required>
                                        <option value="1" selected>خالد عبدالله محمد حسن أحمد</option>
                                    </select>
                                </div>
                                <p class="col">الموجه الطلابي </p>
                                <p class="col">عضو</p>
                            </div>

                            <div class="row" style="margin: 0; text-align: center; align-items: center; min-height: 53px; ">
                                <p class="col-1"> </p>
                                <div class="col">
                                    <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="school_level"
                                            required>
                                        <option value="1" selected>خالد عبدالله محمد حسن أحمد</option>
                                    </select>
                                </div>
                                <p class="col">رائد النشاط</p>
                                <p class="col">عضو</p>
                            </div>

                            <div class="row" style="margin: 0; text-align: center; align-items: center; min-height: 53px; ">
                                <p class="col-1"> </p>
                                <div class="col">
                                    <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="school_level"
                                            required>
                                        <option value="1" selected>خالد عبدالله محمد حسن أحمد</option>
                                    </select>
                                </div>
                                <p class="col">معلم</p>
                                <p class="col">عضو</p>
                            </div>

                            <div class="row" style="margin: 0; text-align: center; align-items: center; min-height: 53px; ">
                                <p class="col-1"> </p>
                                <div class="col">
                                    <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="school_level"
                                            required>
                                        <option value="1" selected>خالد عبدالله محمد حسن أحمد</option>
                                    </select>
                                </div>
                                <p class="col">مساعد إداري</p>
                                <p class="col">مقرر اللجنة</p>
                            </div>

                            <div class="row main_row" style="margin: 0; text-align: center; align-items: center; min-height: 53px; ">
                                <p class="col-1"> </p>
                                <div class="col">
                                    <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="school_level"
                                            required>
                                        <option value="1" disabled selected>الشخص المكلف</option>
                                        <option value="2">خالد عبدالله محمد حسن أحمد</option>
                                        <option value="3"> محمد حسن أحمد</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="school_level"
                                            required>
                                        <option value="1" disabled selected>المسمي الوظيفي</option>
                                    </select>
                                </div>
                                <div class="col d-flex gap-2 align-items-center">
                                    <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="school_level"
                                            required>
                                        <option value="1" disabled selected>العمل المكلف به </option>
                                    </select>
                                    <div class="d-flex gap-2">
                                        <i class="fa fa-minus-circle" style="color: #FF6347; font-size: 24px; display: none;"
                                           aria-hidden="true"></i>
                                        <i class="fa fa-plus-circle" style="color: #1DAE6D; font-size: 24px;" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Data Table -->
                        </div>
                        <div class="mt-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3>إنشاء إجتماعات اللجنة</h3>
                                <div style="width: 355px;">
                                    <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="school_level"
                                            required>
                                        <option value="1" selected>الفصل الدراسي الأول</option>
                                        <option value="2">الفصل الدراسي الثاني</option>
                                    </select>
                                </div>
                            </div>

                            <div class="lam_accordion_body AdministrativeCommittee_table_2"
                                 style="margin:24px 0; background-color: #F1F1F1; border-radius: 10px; padding-top: 0">
                                <!-- Start Header of table -->
                                <div class="row"
                                     style="color:#0A3A81;font-weight: 700; background-color: #EAB977; margin: 0; border-radius: 10px 10px 0px 0px; text-align: center; align-items: center; min-height: 53px;">
                                    <div class="col-2"> </div>
                                    <p class="col">الأجتماع الأول</p>
                                    <p class="col">الأجتماع الثاني</p>
                                    <p class="col">الأجتماع الثالث</p>
                                </div>
                                <!-- End Header of table -->
                                <!-- Start of Data Table -->
                                <div class="row"
                                     style="margin: 0; text-align: center; align-items: center; min-height: 53px; border-bottom: 1px solid #DEDEDE">
                                    <div class="col-2 row align-items-center"
                                         style="height: 94px; background-color:#EAB977; margin: 0; color: #0A3A81">
                                        <h5>تاريخ الإجتماع</h5>
                                    </div>
                                    <div class="col row justify-content-center">
                                        <div style="width: 80%">
                                            <select class="js-example-basic-single select2-no-search select2-hidden-accessible"
                                                    name="school_level" required>
                                                <option value="1" disabled selected>تاريخ الاجتماع</option>
                                                <option value="2">2023/02/10 الأحد</option>
                                                <option value="3">2023/02/11 الاثنين</option>
                                                <option value="4">2023/02/12 الثلاثاء</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col row justify-content-center">
                                        <div style="width: 80%">
                                            <select class="js-example-basic-single select2-no-search select2-hidden-accessible"
                                                    name="school_level" required>
                                                <option value="1" disabled selected>تاريخ الاجتماع</option>
                                                <option value="2">2023/02/10 الأحد</option>
                                                <option value="3">2023/02/11 الاثنين</option>
                                                <option value="4">2023/02/12 الثلاثاء</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col row justify-content-center">
                                        <div style="width: 80%">
                                            <select class="js-example-basic-single select2-no-search select2-hidden-accessible"
                                                    name="school_level" required>
                                                <option value="1" disabled selected>تاريخ الاجتماع</option>
                                                <option value="2">2023/02/10 الأحد</option>
                                                <option value="3">2023/02/11 الاثنين</option>
                                                <option value="4">2023/02/12 الثلاثاء</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin: 0; text-align: center; align-items: center; min-height: 53px;">
                                    <div class="col-2 row align-items-center"
                                         style="height: 94px; background-color:#EAB977; margin: 0; border-radius: 0 0 10px 0;  color: #0A3A81">
                                        <h5>مكان الإجتماع</h5>
                                    </div>
                                    <div class="col row justify-content-center">
                                        <div style="width: 80%">
                                            <select class="js-example-basic-single select2-no-search select2-hidden-accessible"
                                                    name="school_level" required>
                                                <option value="1" disabled selected>مكان الإجتماع</option>
                                                <option value="2">غرفه الإجتماعات</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col row justify-content-center">
                                        <div style="width: 80%">
                                            <select class="js-example-basic-single select2-no-search select2-hidden-accessible"
                                                    name="school_level" required>
                                                <option value="1" disabled selected>مكان الإجتماع</option>
                                                <option value="2">غرفه الإجتماعات</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col row justify-content-center">
                                        <div style="width: 80%">
                                            <select class="js-example-basic-single select2-no-search select2-hidden-accessible"
                                                    name="school_level" required>
                                                <option value="1" disabled selected>مكان الإجتماع</option>
                                                <option value="2">غرفه الإجتماعات</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

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

        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder: 'اسم المكلف',
                width: '100%', // Adjust the width as needed
                allowClear: true, // Add a clear button
            });

            // Handle "Select All" option
            $('.js-example-basic-multiple').on('change', function() {
                const selectedValues = $(this).val();
                const selectedOptionsDiv = $('#selectedOptions');
                selectedOptionsDiv.empty();

                if (selectedValues && selectedValues.includes('all')) {
                    // If "Select All" is selected, select all options
                    $(this).val($(this).children('option').not(':first').map(function() {
                        return this.value;
                    })).trigger('change');
                }
                if (selectedValues) {
                    selectedValues.forEach(function(value, index) {
                        // Append each selected option to the div
                        if (value !== 'all' || !includeSelectAll) {
                            selectedOptionsDiv.append(`
              <div class="row" style="color:#0A3A81;font-weight: 700; background-color: #EAB977; margin: 0; border-radius: 10px 10px 0px 0px; text-align: center; align-items: center; min-height: 53px;">
>
                <p class="col-1">${index + 1}</p>
                <p class="col">${value}</p>
                <p class="col">0123456789</p>
                <p class="col">اللغة العربية</p>
                <div class="col">
                  <button class="delete-btn" data-index="${index}" style="background-color: transparent; border: none;">
                    <img src="http://localhost/lam-ui-last/assets/icons/delete-icon.svg" width="20" height="20"
                      style="margin-left: 5px;" />
                  </button>
                </div>
              </div>
            </div>
          </div>`);
                        }
                    });
                }
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



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tableContainer = document.querySelector(".AdministrativeCommittee_table");
            const addButtons = document.querySelectorAll(".fa-plus-circle");
            const deleteButtons = document.querySelectorAll(".fa-minus-circle");

            addButtons.forEach((button, index) => {
                button.addEventListener("click", function() {
                    // Hide plus button in the active row
                    addButtons[index].style.display = "none";

                    // Show minus button in the active row
                    deleteButtons[index].style.display = "inline";

                    // Select the last element with class "main_row" as the base for cloning
                    const mainRows = document.querySelectorAll(".main_row");
                    const mainRow = mainRows[mainRows.length - 1];

                    if (mainRow) {
                        // Clone from the base row
                        const newRow = mainRow.cloneNode(true);

                        // Insert the new row before the base row
                        tableContainer.insertBefore(newRow, mainRow);

                        // Show plus button in the new last row
                        addButtons[addButtons.length - 1].style.display = "inline";

                        // Hide minus button in the new last row
                        deleteButtons[deleteButtons.length - 1].style.display = "none";
                    }
                });
            });

            // Add event listener for delete buttons outside the loop
            tableContainer.addEventListener("click", function(event) {
                if (event.target.classList.contains("fa-minus-circle")) {
                    // Remove the row
                    const rowToDelete = event.target.closest(".row");
                    rowToDelete.parentNode.removeChild(rowToDelete);
                }
            });
        });
    </script>


@endsection
