@extends('website.school.layouts.master', ['no_header' => true, 'no_transparent_header' => false])
@php
    $initialTab = 'committees'; // Replace 'committees' with the actual tab ID you want to set from the backend
 $firstCommitteeShown = false;
 $firstTeamShown = false;
if ( request()->teams){
    $initialTab = 'teams';
}
    $tabs =
    [
        [
            'id' => 'committees',        // Unique ID for the tab
            'label' => 'اجتماعات اللجان'
        ],
        [
            'id' => 'teams',
            'label' => 'اجتماعات الفرق',
        ],
    ];
    $classifications =
    [
        ['id' => 1, 'label' => 'committees'],
        ['id' => 2, 'label' => 'teams']
    ];

     $table_header =   [ 'م'  ,'الاجتماع'  ,'تاريخ الاجتماع'  ,'نوع الاجتماع'  ,'الفصل الدراسي'  ,'حالة الاجتماع'  ,'تاريخ الإنشاء'  ,''   ] ;
@endphp
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
            <a href="#">اجتماعات اللجان و الفرق</a>
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
                    @foreach ($classifications as $index => $classification)

                    <div class="tab-pane fade <?= ($index + 0) === 0 ? 'show active' : ''; ?>" id="pills-content<?= $index + 0 ?>" role="tabpanel"
                         aria-labelledby="pills-tab<?= $index ?>">


                             @foreach ($Committees_and_teams as $key => $item)
                                @if ($item->classification == $classification['id'])

                                <div class="sprint_3">
                                    <div class="lam_accordion accordion" style="position: relative;">
                                        <div class="header" id="visitsSection-{{$item->id}}" data-bs-toggle="collapse"
                                             data-bs-target="#visitCollapse-{{$item->id}}" aria-expanded="false"
                                             aria-controls="visitCollapse-{{$item->id}}">
                                            <p style="font-size: 20px; font-weight: 700;">
                                                {{ $item->title   }}
                                            </p>
                                            <div class="d-flex align-items-center gap-5">
                    <span class="accordion-button custom-accordion-button collapsed" data-bs-toggle="collapse"
                          data-bs-target="#visitCollapse-{{$item->id}}" aria-expanded="false"
                          aria-controls="visitCollapse-{{$item->id}}"></span>
                                            </div>
                                        </div>

                                        <div style="position: absolute; left:8rem; top:0.5rem; cursor: pointer;">
                                            <a  href="{{ route('school_route.meetings.create',  ['Committees_id'=>$item ->id]  ) }} " >
                                                <button class="lam_accordion_btn">
                                                    <i class="fa fa-plus fa-m text-white" style="margin-left: 10px;" aria-hidden="true"></i>
                                                    انشاء اجتماع جديد
                                                </button>
                                            </a>
                                        </div>
                                        <div class="collapse accordion-collapse

                                         @if (($item->classification == 1 && !$firstCommitteeShown) || ($item->classification == 2 && !$firstTeamShown))
                                show
                                @if($item->classification == 1) @php $firstCommitteeShown = true; @endphp @endif
                                @if($item->classification == 2) @php $firstTeamShown = true; @endphp @endif
                            @endif"
                                             style="background-color: white; border-radius: 10px;"
                                             id="visitCollapse-{{$item->id}}" aria-labelledby="visitsSection-{{$item->id}}"
                                             data-bs-parent="#accordionExample">
                                            <div class="lam_accordion_body" style="padding:24px 0; background-color:#F1F1F1">
                                                <!-- Start Header of table -->
                                                <div class="row"
                                                     style="color:#0A3A81;font-weight: 700; background-color: #EAB977; margin: 0; border-radius: 10px 10px 0px 0px; text-align: center; align-items: center; min-height: 53px;">
                                                         @foreach ($table_header as   $header)
                                                        <p class="col"> {{ $header }}</p>
                                                    @endforeach
                                                </div>
                                                <!-- End Header of table -->
                                                <!-- Start of Data Table -->

                                                @foreach ($item->get_meetings as $key_val => $item_val)

                                                <div class="lam_accordion_row">
                                                    <div class="row" style="margin: 0; text-align: center; align-items: center; min-height: 53px;">

                                                        <p class="col">     {{ $key_val+1   }} </p>
                                                        <p class="col">      {{ $item_val->title   }} </p>
                                                        <p class="col">     {{ \Carbon\Carbon::parse($item_val->start_date)->format('Y/m/d') }}   </p>
                                                        <p class="col">  {{ $item_val->type?'طارئ':'دوري'   }}    </p>
                                                        <p class="col">      {{ $item_val->Semester   }}  </p>
                                                        <p class="col">    @if($item_val->status)
                                                                مكتمل
                                                            @else
                                                                غير مكتمل
                                                            @endif
                                                        </p>
                                                        <p class="col">   {{ \Carbon\Carbon::parse($item_val->created_at)->format('Y/m/d') }}   </p>


                                                        <div class="col dropdown">
                                                            <i class="dot-icon fas fa-ellipsis-v fs-6 fa-fw text-gray-700 triple-dot-size cursor-pointer"
                                                               id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                <li>
                                                                    <a class="dropdown-item" href="../ClassroomVisits/index.php">
                                                                        <img src="http://localhost/lam-ui-last/assets/icons/WatchIcon.svg" width="20"
                                                                             height="20" style="margin-left: 5px;" />
                                                                        مشاهدة
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="#">
                                                                        <img src="http://localhost/lam-ui-last/assets/icons/print-icon.svg" width="20"
                                                                             height="20" style="margin-left: 5px;" />
                                                                        تحميل
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="#">
                                                                        <img src="http://localhost/lam-ui-last/assets/icons/print-icon.svg" width="20"
                                                                             height="20" style="margin-left: 5px;" />
                                                                        طباعة
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="#" data-bs-target="#EditVisit-{{$item->id}}"
                                                                       data-bs-toggle="modal">
                                                                        <img src="http://localhost/lam-ui-last/assets/icons/edit-icon2.svg" width="20"
                                                                             height="20" style="margin-left: 5px;" />
                                                                        تعديل
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="#" data-bs-target="#Delete-Visit"
                                                                       data-bs-toggle="modal">
                                                                        <img src="http://localhost/lam-ui-last/assets/icons/delete-icon.svg" width="20"
                                                                             height="20" style="margin-left: 5px;" />
                                                                        حذف
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                    <!-- End of Data Table -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 @endif
                              @endforeach

                    </div>
                    @endforeach
                </div>
            </div>


        <!-- Delete Modal -->
        <div class="modal fade" id="delete_admin_modal" tabindex="-1"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable delete-meeting-modal">
                <div class="modal-content b-r-s-cont border-0">
                    <div>
                        <button type="button" class="close-modal" data-bs-dismiss="modal"  aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form action="{{ route('school_route.meetings.destroy', $item_val['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <!-- Modal content -->
                        <div class="modal-body px-4">
                            <div class="modal-body delete-conf-input text-center py-0">
                                <p class="mb-0">هل انت متاكد من حذف  الاجتماع</p>
                                <br>
                                <input type="hidden" name="meeting_id" id="modalMeetingId">

                            </div>
                        </div>

                        <div class="modal-footer" >

                                <button type="submit"  class="btn btn-primary width-220 default-blue-bg-color">حذف
                                </button>
                                <button type="button" class="btn btn-primary width-220 default-blue-bg-color"
                                        data-bs-dismiss="modal">الغاء الامر</button>

                        </div>
                    </form>
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

    </script>



@endsection
