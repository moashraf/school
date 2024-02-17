@extends('website.school.layouts.master', ['no_header' => true, 'no_transparent_header' => false])
@section('title', 'اللجان والفرق | منصة لام')
@section('topbar', 'اللجان والفرق | منصة لام')

<!-- css insert -->
@section('css')

    {{--    <!-- swiper -->--}}
    {{--    <link rel="stylesheet" href="https://fastly.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />--}}

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


    <div class="page_top_nevg">
        <a href="#">التكليفات</a>
    </div>
    <div class="sprint-4">
    <div class="nav_tabs nav-tabs-main  ">
        <ul class="nav nav-pills" id="pills-tab" role="tablist">
            @foreach ($assignmentClassifications as $index => $tab)
                <li class="nav-item" role="presentation">
                    <button class="nav-link  <?= ($index + 0) === 0 ? 'active' : ''; ?>"
                            id="pills-tab<?= $index ?>" data-bs-toggle="pill"
                            data-bs-target="#pills-content<?= $index + 0 ?>"
                            type="button"
                            role="tab"
                            aria-controls="pills-content<?= $index ?>"
                            aria-selected="<?= ($index + 0) === 0 ? 'true' : 'false'; ?>">
                        {{ $tab['name']  }}
                    </button>
                </li>
            @endforeach
        </ul>
        <div class="tab-content tab-content-main" id="pills-tabContent">

            @foreach ($assignmentClassifications as $index => $assignmentClassification)

                <div class="tab-pane fade <?= ($index + 0) === 0 ? 'show active' : ''; ?>" id="pills-content<?= $index + 0 ?>" role="tabpanel"
                     aria-labelledby="pills-tab<?= $index ?>">

                        <div class="container-fluid px-4 px-md-5 py-3 py-md-4">
                            <div class="school_administration">
                                <h1 style="font-size: 22px; font-weight: 700; text-align: center;">تكليفات {{$assignmentClassification['name']}} </h1>

                                @foreach ($assignmentClassification['assignment_items'] as $key => $assignment_item)

                                <!-- Start of Accordion-تكليف مدير المدرسة -->
                                <div class="lam_accordion accordion" style="position: relative;">
                                    <div class="header" id="AssignmentOfTheSchoolDirector" data-bs-toggle="collapse"
                                         data-bs-target="#AssignmentOfTheSchoolDirectorCollapse{{$assignment_item['id']}}" aria-expanded="false"
                                         aria-controls="AssignmentOfTheSchoolDirectorCollapse{{$assignment_item['id']}}">
                                        <p style="font-size: 20px; font-weight: 700;">{{$assignment_item['name']}}</p>
                                        <div class="d-flex align-items-center gap-5">
                                              <span class="accordion-button custom-accordion-button collapsed" data-bs-toggle="collapse"
                                                    data-bs-target="#AssignmentOfTheSchoolDirectorCollapse{{$assignment_item['id']}}" aria-expanded="false"
                                                    aria-controls="AssignmentOfTheSchoolDirectorCollapse{{$assignment_item['id']}}">
                                              </span>
                                        </div>
                                    </div>

                                    @if($assignmentClassification['id']!==4)
                                    <div style="position: absolute; left:6rem; top:0.5rem; cursor: pointer;">
                                        <!-- If you will use this button for popup window put this data-bs-target="#Plan-Visit" data-bs-toggle="modal" -->
                                        <a
                                            href="{{ route('school_route.single_assignment.create',  ['assignment_item_id'=>$assignment_item['id']]  ) }}">
                                            <button class="lam_accordion_btn">
                                                <i class="fa fa-plus fa-m text-white" style="margin-left: 10px;" aria-hidden="true"></i>
                                                انشاء تكليف جديد
                                            </button>
                                        </a>
                                    </div>
                                    @endif

                                    <div class="collapse accordion-collapse" style="background-color: white; border-radius: 10px;"
                                         id="AssignmentOfTheSchoolDirectorCollapse{{$assignment_item['id']}}" aria-labelledby="AssignmentOfTheSchoolDirector"
                                         data-bs-parent="#accordionExample">
                                        <div class="lam_accordion_body" style="padding:24px 0; background-color:#F1F1F1">
                                            <!-- Start Header of table -->
                                            @if($assignmentClassification['id']!==4)
                                            <div class="row"
                                                 style="color:#0A3A81;font-weight: 700; background-color: #EAB977; margin: 0; border-radius: 10px 10px 0px 0px; text-align: center; align-items: center; min-height: 53px;">
                                                <p class="col-1">م</p>
                                                <p class="col">اسم الشخص المكلف</p>
                                                <p class="col">رقم السجل المدني</p>
                                                <p class="col">تاريخ التكلف</p>
                                                <p class="col">خيارات</p>
                                            </div>
                                            @else
                                                <div class="row"
                                                     style="color:#0A3A81;font-weight: 700; background-color: #EAB977; margin: 0; border-radius: 10px 10px 0px 0px; text-align: center; align-items: center; min-height: 53px;">
                                                    <p class="col-1">م</p>
                                                    <p class="col">اسم اللجنة</p>
                                                    <p class="col">تاريخ التكلف</p>
                                                    <p class="col">خيارات</p>
                                                </div>
                                            @endif

                                            <!-- End Header of table -->
                                            <!-- Start of Data Table -->
                                            @if(!empty($assignment_item['single_assignments']) && $assignmentClassification['id']!==4)
                                            @foreach ($assignment_item['single_assignments'] as $var => $single_assignment)
                                                    @if(!empty($single_assignment['assigned_users']))
                                                    @foreach ($single_assignment['assigned_users'] as $v => $single_assignment_user)
                                            <div class="lam_accordion_row">
                                                <div class="row" style="margin: 0; text-align: center; align-items: center; min-height: 53px;">
                                                    <p class="col-1">{{$v+1}}</p>
                                                    <p class="col">{{$single_assignment_user['user']['first_name']}}</p>
                                                    <p class="col">{{$single_assignment_user['user']['identification_number']}}</p>
                                                    <p class="col">{{$single_assignment['assignment_start_date']}}</p>
                                                    <div class="col dropdown">
                                                        <i class="dot-icon fas fa-ellipsis-v fs-6 fa-fw text-gray-700 triple-dot-size cursor-pointer"
                                                           id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                            <li>
                                                                <a class="dropdown-item" href="../ClassroomVisits/index.php">
                                                                    <img src="http://localhost/lam-ui-last/assets/icons/BlueDownload.svg" width="20" height="20"
                                                                         style="margin-left: 5px;" />
                                                                    تحميل
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#">
                                                                    <img src="http://localhost/lam-ui-last/assets/icons/print-icon.svg" width="20" height="20"
                                                                         style="margin-left: 5px;" />
                                                                    طباعه
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item"   href="{{url('/school/single_assignment/'.$single_assignment['id'].'/edit')}}"  >
                                                                    <img
                                                                        src="{{ URL::asset('/icons/edit-icon2.svg') }}" width="20"
                                                                        height="20" style="margin-left: 5px;" />
                                                                    تعديل
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#"  data-bs-toggle="modal" onclick="addAssignedUserToModal(this)" data-user-name ="{{$single_assignment_user['user']['first_name']}}" data-assignment-user-id="{{$single_assignment_user['id']}}">
                                                                    <img src="http://localhost/lam-ui-last/assets/icons/delete-icon.svg" width="20" height="20"
                                                                         style="margin-left: 5px;" />
                                                                    حذف
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            @endforeach
                                                    @endif
                                            @endforeach
                                            <!-- End of Data Table -->


                                            @elseif($assignmentClassification['id']===4)
                                                @foreach ($assignment_item['single_assignments'] as $var => $single_assignment)
                                                            <div class="lam_accordion_row">
                                                                <div class="row" style="margin: 0; text-align: center; align-items: center; min-height: 53px;">
                                                                    <p class="col-1">{{$var+1}}</p>
                                                                    <p class="col">{{$single_assignment['title']}}    </p>

                                                                    @if((isset( $single_assignment['get_single_assignment']['id']) ==0)  )
                                                                        <p class="col">   لايوجد تكليف   </p>

                                                                    @else
                                                                        <p class="col">{{  $single_assignment['get_single_assignment']['assignment_start_date']  }}</p>

                                                                    @endif

                                                                    @if((isset( $single_assignment['get_single_assignment']['id']) ==0)  )
                                                                        <div class="col dropdown">

                                                                            <!-- If you will use this button for popup window put this data-bs-target="#Plan-Visit" data-bs-toggle="modal" -->
                                                                            <a
                                                                                href="{{ route('school_route.create_single_assignment_committe_team',  ['committe_team_id'=>$single_assignment['id']]  ) }}">
                                                                                <button class="lam_accordion_btn">
                                                                                    <i class="fa fa-plus fa-m text-white" style="margin-left: 10px;" aria-hidden="true"></i>
                                                                                    انشاء تكليف جديد
                                                                                </button>
                                                                            </a>
                                                                        </div>

                                                                    @else
                                                                        <div class="col dropdown">
                                                                            <i class="dot-icon fas fa-ellipsis-v fs-6 fa-fw text-gray-700 triple-dot-size cursor-pointer"
                                                                               id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                                                                <li>
                                                                                    <a class="dropdown-item" href="../ClassroomVisits/index.php">
                                                                                        <img src="http://localhost/lam-ui-last/assets/icons/BlueDownload.svg" width="20" height="20"
                                                                                             style="margin-left: 5px;" />
                                                                                        تعديل
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a class="dropdown-item" href="../ClassroomVisits/index.php">
                                                                                        <img src="http://localhost/lam-ui-last/assets/icons/BlueDownload.svg" width="20" height="20"
                                                                                             style="margin-left: 5px;" />
                                                                                        تحميل
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a class="dropdown-item" href="#">
                                                                                        <img src="http://localhost/lam-ui-last/assets/icons/print-icon.svg" width="20" height="20"
                                                                                             style="margin-left: 5px;" />
                                                                                        طباعه
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a class="dropdown-item" href="#" data-bs-target="#Delete-Visit" data-bs-toggle="modal">
                                                                                        <img src="http://localhost/lam-ui-last/assets/icons/delete-icon.svg" width="20" height="20"
                                                                                             style="margin-left: 5px;" />
                                                                                        حذف
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>


                                                                    @endif


                                                                </div>
                                                            </div>
                                                @endforeach

                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Accordion-تكليف مدير المدرسة -->
                                @endforeach
                            </div>
                        </div>



                </div>
            @endforeach

        </div>
    </div>
    </div>
    </div>
    <div class="modal fade" id="Delete-Visit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content b-r-s-cont border-0">
                <!-- Header of Modal -->
                <div class="modal-header no-header-modal">
                    <h5 class="modal-title text-center" id="exampleModalLabel"></h5>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form action="{{route('school_route.assignment_users.destroy',1)}}" method="POST">
                    @csrf
                    @method('DELETE')
                <!-- Modal content -->
                <div class="modal-body px-5 py-3" style="margin-bottom: 50px;">
                    <div class="content">
                        <h1 class="title text-center"> تنبيه</h1>
                        <img src="http://localhost/lam-ui-last/assets/images/warning-sign.png" alt="Warning-Sign" width="100" height="100">
                        <p class="warning-content mt-10" id="delete-user-text">
                            هل تريد حذف المستخدم من التكليف
                        </p>
                        <input type="hidden" name="assignment-user-id" id="assignment-user-id">
                        <div class="btn-section">
                            <button class="btn-accept" type="submit">موافق</button>
                            <button class="btn-delete" aria-label="Close" data-bs-dismiss="modal">إلغاء</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<!-- js insert -->
@section('js')

    {{-- swiper --}}
    <script src="https://fastly.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        // JavaScript Function to Print Meeting
        function printMeeting(meetingId) {
            // Open the meeting detail page in a new window/tab
            var printWindow = window.open('meetings/'+meetingId+'/print-pdf');

            // Wait for the page to load
            printWindow.onload = function() {
                // Trigger the print dialog
                printWindow.print();

                // Optional: Close the new window/tab after a delay
                setTimeout(function() {
                    printWindow.print();
                    printWindow.close();
                }, 2000);
            };
        }

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

        $('#delete_admin_modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var meetingId = button.data('meeting-id');

            var modal = $(this);
            modal.find('#modalMeetingId').val(meetingId);
        });
        $('#Delete-Visit .btn-delete').click(function(event) {
            event.preventDefault(); // Prevent default form submission
            $('#Delete-Visit').modal('hide');
        });
        // $('#Delete-Visit .btn-accept').click(function() {
        //     // Get the user ID to be deleted
        //     var userId = $('#hidden-user-id').val();
        //
        //     // Send an AJAX request to delete the user
        //     $.ajax({
        //         url: '/delete-user/' + userId, // Adjust the URL endpoint as per your route setup
        //         type: 'DELETE',
        //         success: function(response) {
        //             // Handle success response (e.g., remove the user from the table)
        //             // Reload or update the table after successful deletion
        //         },
        //         error: function(xhr, status, error) {
        //             // Handle error response
        //         }
        //     });
        //
        //     // Close the modal
        //     $('#Delete-Visit').modal('hide');
        // });

        function addAssignedUserToModal(element){

            var userID = $(element).data('assignment-user-id');
            var userName = $(element).data('user-name');
            $('#assignment-user-id').val(userID);
            $('#delete-user-text').text(`هل تري حذف المستخدم ${userName}`)
            $('#Delete-Visit').modal('show');
        }

    </script>



@endsection
