@extends('website.school.layouts.master', ['no_header' => true, 'no_transparent_header' => false])

@section('title', 'الصفحة الرئيسية لمدرستك في منصة لام | منصة لام')
@section('topbar', 'الصفحة الرئيسية لمدرستك في منصة لام | منصة لام')

<!-- css insert -->
@section('css')

    <!-- swiper -->
    <link rel="stylesheet" href="https://fastly.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

@endsection


@section('fixedcontent')

    <div class="position-fixed main-color-bg text-white p-2 px-3 z-3 clickable-item-pointer" id="video_toutrial_cont"
         data-bs-toggle="modal" data-bs-target="#video_toutrial_modal"
         style="top: 18%; left:0%; border-radius: 0px 10px 10px 0px;">
        <div class="d-flex">
            <i class="fas fa-video me-2"></i>
            <h6 id="video_toutrial_modal_text" class="mb-0 text-s" style="display: none">شرح الصفحة الرئيسية </h6>
        </div>
    </div>


    <!-- Modal for search filtering -->
    <div class="modal fade" id="video_toutrial_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">

            <div class="modal-content b-r-s-cont border-0">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel">
                        شرح الصفحة الرئيسية
                    </h5>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>

                <!-- Modal content -->
                <div class="modal-body px-5 py-3">
                    <div class="text-center">
                        <iframe class="col-12" width="560" height="315" src="{{ $video_tutorial->url }}"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- content insert -->
@section('content')

    <div class="container-fluid px-4 px-md-5 py-3 py-md-4">


        <div class="row">

            <div class="row main_cot_bg p-2 align-items-center mb-4" style=" font-size: .9rem;  background-color: #0A3A81;">

                <div class="col-12 col-xl-12">
                    <h5 class="  text-s2" style="     margin-top: 0.5rem;   color: white;">
                        إجتماعات اللجان والفرق
                    </h5>

                </div>

            </div>



            <div class="col-12 mb-3 mb-md-0">
                <div class="main_cot_bg p-3 py-3 h-100">

                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active tabcontent_active " id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button"
                                    role="tab" aria-controls="pills-home" aria-selected="true">
                                إجتماعات اللجان
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button"
                                    role="tab" aria-controls="pills-profile" aria-selected="false">
                                إجتماعات الفرق
                            </button>
                        </li>

                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                            <div style="    margin-top: 10%;" class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Accordion Item #1
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <div class=" add_border_radius table-responsive" id="admin_table_cont" style="display: block"   >
                                                <table class="table display datatable-modal" style="direction: " id="p_3-table" width="100%"  cellspacing="0">
                                                    <thead>
                                                    <tr>
                                                        <th  class=" table_title_color text-xs fw-bold">الاجتماع  </th>
                                                        <th class="table_title_color  text-xs fw-bold">   تاريخ الاجتماع </th>
                                                        <th class=" table_title_color  text-xs fw-bold">   نوع الاجتماع </th>
                                                        <th class=" table_title_color  text-xs fw-bold">   الفصل الدراسي </th>
                                                        <th class=" table_title_color  text-xs fw-bold">حاله الاجتماع  </th>
                                                        <th class=" table_title_color  text-xs fw-bold">   تاريخ الانشاء </th>
                                                        <th class=" table_title_color  text-xs fw-bold"></th>
                                                    </tr>
                                                    </thead>

                                                    <tbody id="admin_table_cont_tr">

                                                    <tr id="row_cod11">
                                                        <td class="">
                                                            1111
                                                        </td>
                                                        <td class="">
                                                            222
                                                        </td>
                                                        <td class="">
                                                            333
                                                        </td>
                                                        <td class="">
                                                            444
                                                        </td>
                                                        <td class="">
                                                            555
                                                        </td>
                                                        <td class="">
                                                            6666
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
                                                                       data-code="cod11" data-name="rr"
                                                                       data-identification_number="ff"
                                                                       data-phone_number="asdf"
                                                                       data-email="adf"
                                                                       data-school_job_id="sdf"
                                                                       data-teacher_speciality_id="sdfsd"><i
                                                                            class="fas fa-trash-alt me-1"></i>
                                                                        تعديل</a>
                                                                    <a class="dropdown-item text-red" href="#" data-bs-toggle="modal"
                                                                       data-bs-target="#delete_admin_modalcod11"><i
                                                                            class="fas fa-trash-alt me-1"></i>
                                                                        حذف</a>
                                                                </div>
                                                            </div>

                                                            <!-- Delete Modal -->
                                                            <div class="modal fade" id="delete_admin_modalcod11" tabindex="-1"
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
                                                                                           value="cod11">
                                                                                </div>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <div class="right-side">
                                                                                    <button type="button" data-code="cod11"
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
                                                    <tr id="row_cod11">
                                                        <td class="">
                                                            1111
                                                        </td>
                                                        <td class="">
                                                            222
                                                        </td>
                                                        <td class="">
                                                            333
                                                        </td>
                                                        <td class="">
                                                            444
                                                        </td>
                                                        <td class="">
                                                            555
                                                        </td>
                                                        <td class="">
                                                            6666
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
                                                                       data-code="cod11" data-name="rr"
                                                                       data-identification_number="ff"
                                                                       data-phone_number="asdf"
                                                                       data-email="adf"
                                                                       data-school_job_id="sdf"
                                                                       data-teacher_speciality_id="sdfsd"><i
                                                                            class="fas fa-trash-alt me-1"></i>
                                                                        تعديل</a>
                                                                    <a class="dropdown-item text-red" href="#" data-bs-toggle="modal"
                                                                       data-bs-target="#delete_admin_modalcod11"><i
                                                                            class="fas fa-trash-alt me-1"></i>
                                                                        حذف</a>
                                                                </div>
                                                            </div>

                                                            <!-- Delete Modal -->
                                                            <div class="modal fade" id="delete_admin_modalcod11" tabindex="-1"
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
                                                                                           value="cod11">
                                                                                </div>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <div class="right-side">
                                                                                    <button type="button" data-code="cod11"
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
                                                    <tr id="row_cod11">
                                                        <td class="">
                                                            1111
                                                        </td>
                                                        <td class="">
                                                            222
                                                        </td>
                                                        <td class="">
                                                            333
                                                        </td>
                                                        <td class="">
                                                            444
                                                        </td>
                                                        <td class="">
                                                            555
                                                        </td>
                                                        <td class="">
                                                            6666
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
                                                                       data-code="cod11" data-name="rr"
                                                                       data-identification_number="ff"
                                                                       data-phone_number="asdf"
                                                                       data-email="adf"
                                                                       data-school_job_id="sdf"
                                                                       data-teacher_speciality_id="sdfsd"><i
                                                                            class="fas fa-trash-alt me-1"></i>
                                                                        تعديل</a>
                                                                    <a class="dropdown-item text-red" href="#" data-bs-toggle="modal"
                                                                       data-bs-target="#delete_admin_modalcod11"><i
                                                                            class="fas fa-trash-alt me-1"></i>
                                                                        حذف</a>
                                                                </div>
                                                            </div>

                                                            <!-- Delete Modal -->
                                                            <div class="modal fade" id="delete_admin_modalcod11" tabindex="-1"
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
                                                                                           value="cod11">
                                                                                </div>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <div class="right-side">
                                                                                    <button type="button" data-code="cod11"
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


                                                    </tbody>

                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Accordion Item #2
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Accordion Item #3
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">3...</div>
                     </div>





                </div>
            </div>

        </div>

    </div>
@endsection

<!-- js insert -->
@section('js')

    {{-- swiper --}}
    <script src="https://fastly.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
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


        // Calendar
        fetchCalander();

        function fetchCalander(month = {{ date('m') }}, year = {{ date('Y') }}) {

            var url =
                "{{ route('school_route.calander_tasks_ajax', [':month', ':year']) }}";
            url = url.replace(':month', month).replace(':year', year)
            ;
            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    $("#calander_cont").html(data);
                }
            });
        }

        //reinsert the calander when the month arrows are clicked
        $(document).on('click', '#change_month', function() {
            var month = $(this).data('month');
            var year = $(this).data('year');
            fetchCalander(month, year)
        });
    </script>



@endsection
