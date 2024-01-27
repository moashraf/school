@extends('website.school.layouts.master', ['no_header' => true, 'no_transparent_header' => false])
@section('title', 'انشاء تكليف')
@section('topbar', 'انشاء تكليف')


@section('fixedcontent')
    <!-- Your fixed content here -->
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
                <h1 style="font-size: 22px; font-weight: 700; text-align: center;">إنشاء تكليف مدير المدرسة </h1>
                <div class="header-info">
                    <table>
                        @foreach($SingleAssignment['header_items_data'] as $key => $header_item_data)
                        <tr>
                            <th><?php echo $key ?></th>
                            <td><?php echo $header_item_data ?></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <form id="myform" class="myform" method="POST" action="http://localhost/lam-ui-last/Pages/Sprint-4/index.php"
                      enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="syhKNup958iJi5zJhQRToU3NVUVWLYw0DvMdnfHg">
                    <input type="hidden" name="_method" value="PUT">
                    <div>
                        <div class="form-group" style="margin-bottom:48px">
                            <div class="row">
                                <div class="col-12 col-md-4 col-xl-2 align-self-center ">
                                    <label for="committee" class="form-label bold_form_label "> اليوم و التاريخ
                                </div>
                                <div class="col-12 col-md-8 col-xl-10" style="max-width: 355px;">
                                    <div class="input-group">
                                        <input name="start_date" type="text"
                                               class="hijri-date-input form-control border-left-0 clickable-item-pointer "
                                               placeholder="تاريخ الاجتماع" value="" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"> <img class="platform_icon" alt="school"
                                                                                src="https://factoryfiy.com/img/icons/calendar.svg"> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="row">
                            <div class="col-12 col-md-4 col-xl-2 align-self-center">
                                <label class="form-label mb-2 mb-xl-0">
                                    اسم المكلف
                                </label>
                            </div>
                            <div class="col-12 col-md-8 col-xl-10 align-self-center" style="max-width: 355px;">
                                <select class="js-example-basic-single select2-no-search select2-hidden-accessible" name="assignment_name"
                                        required>
                                    @foreach($Managers as $index => $Manager)
                                    <option value="{{$Manager['id']}}" >{{$Manager['first_name']}}</option>
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
                    </div>

                    <div class="row" style="margin-bottom:48px">
                        <div class="col-12 col-md-4 col-xl-2 align-self-center">
                            <label class="form-label mb-2 mb-xl-0"> رقم السجل المدني
                            </label>
                        </div>
                        <div class="col-12 col-md-8 col-xl-10" style="max-width: 355px;">
                            <input name="school_name" type="text" class="form-control" maxlength="100"
                                   placeholder="اكتب هنا الفصل الدراسي .." >
                            <div id="school_name-js_error_valid"></div>
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
        $('.js-example-basic-single').select2();
        //hide search
        $('.select2-no-search').select2({
        minimumResultsForSearch: -1
    });
    });
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
