@extends('website.school.layouts.master', ['no_header' => true, 'no_transparent_header' => false])

@section('title', 'اجتماع جديد')
@section('topbar', 'اصنع اجتماعا جديد')

<!-- css insert -->
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/new_meeting.css') }}">
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

@section('content')
    <div class="container form-container">
        <div class="card custom-card">
            <div class="card-header custom-card-header">
                إنشاء اجتماع اللجنة الإدارية
            </div>
            <div class="card-body custom-card-body">
                <form action="" method="POST" class="custom-form">
                    @csrf <!-- CSRF Token for Laravel protection -->

                    <div class="row form-group">
                        <label  for="committee" class="form-label col-md-3">نوع الاجتماع:</label>
                        <select name="committee" id="committee" class="col-md-4 form-control custom-select">
                            <option value="">اختر نوع الاحتماع</option>
                            <option value="">طارئ</option>
                            <option value="">عمومي</option>
                            <!-- Other options -->
                        </select>
                    </div>
                    <div class="row form-group">
                        <label for="date" class="col-md-3 form-label">تاريخ الاجتماع:</label>
                        <input type="date" id="date" name="date" class="col-md-3 form-control">
                    </div>
                    <div class="row form-group">
                        <label for="time" class="form-label col-md-3">موعد الاجتماع:</label>
                            <input type="time" id="time" name="time" class="col-md-3 form-control">

                    </div>
                    <div class="row form-group">
                        <label for="agenda" class="form-label col-md-3">جدول الأعمال:</label>
                         <input type="agenda" id="agenda" name="agenda" class=" col-md-3 form-control">

                    </div>

                    <!-- Repeat for other fields with appropriate classes -->

                    <div class="row form-group">
                        <div class="col-md-6">
                            <button type="reset" class="col-md-3 btn btn-default  custom-reset-button">إنهاء</button>
                        </div>
                        <div class="col-md-6">
                        <button type="submit" class="col-md-3 float-end btn btn-primary custom-submit-button">التالي</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

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
