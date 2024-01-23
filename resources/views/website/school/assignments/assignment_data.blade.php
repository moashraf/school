@extends('website.school.layouts.master', ['no_header' => true, 'no_transparent_header' => false])
@php
    $initialTab = 'committees'; // Replace 'committees' with the actual tab ID you want to set from the backend
 $firstCommitteeShown = false;
 $firstTeamShown = false;
if ( request()->teams){
    $initialTab = 'teams';
}
    $tabs = [
    ['label' => 'إدارة المدرسة', 'content' => 'SchoolAdministration'],
    ['label' => 'المعلمين', 'content' => 'Teachers'],
    ['label' => 'منسوبي المدرسة', 'content' => 'SchoolStaff'],
    ['label' => 'اللجان و الفرق ', 'content' => 'CommitteesAndTeams'],
    ['label' => 'التكليفات العامة ', 'content' => 'GeneralAssignments'],
];

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
    <div style="height: 60px;"></div>

    <div class="page_top_nevg">
        <a href="#">التكليفات</a></div>
    </div>

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
