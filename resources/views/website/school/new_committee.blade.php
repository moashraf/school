@extends('website.school.layouts.master', ['no_header' => true, 'no_transparent_header' => false])
@php

    $action = isset($item_val['id']) ? route('school_route.Committees_and_teams_meetings.update', $item_val['id']) : route('school_route.Committees_and_teams_meetings.store');
    $method = isset($item_val['id']) ? 'PUT' : 'POST';
@endphp
@section('title', 'انشاء لجنة/فرقه')
@section('topbar', 'انشاء لجنة/فرقه')


@section('fixedcontent')
    <!-- Your fixed content here -->
@endsection

<!-- content insert -->
@section('content')
    <div class="container-fluid px-4 px-md-5 py-3 py-md-4">
        <div class="row">
            <div class="row main_cot_bg p-2 align-items-center mb-4" style=" font-size: .9rem;  background-color: #0A3A81;">
                <div class="col-12 col-xl-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-s2 active"  style="color: white;" aria-current="page">المدرسه</li>
                            <li class="breadcrumb-item text-s2" style="color: white;">اللجان</li>
                            <li class="breadcrumb-item text-s2" style="color: white;">انشاء لجنة/فرقه</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="custom-form">
                @csrf
                @if(isset($item_val['id']))
                    @method($method) <!-- Laravel's method spoofing for PUT request -->
                @endif
                @csrf <!-- CSRF Token for Laravel protection -->
            <div class="col-12 mb-3 mb-md-0">
                <div class="main_cot_bg p-3 py-3 h-100">
                            <div class="container form-container">
                                <div class="card custom-card">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="card-body custom-card-body">

                                                    <input type="hidden" id="school_id" name="school_id" value="{{ $current_school}}" class="  form-control">
                                                    <input type="hidden" id="author" name="author" value="{{$current_user_id}}" class="  form-control">
                                                <div class="  form-group">
                                                    <div class="row">
                                                        <div class="col-md-3 align-self-center ">
                                                            <label  for="committee" class="form-label" >اسم اللجنة/الفرقه   </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input   required type="text" id="title" name="title" value="{{ isset($item_val)  ?$item_val['title']:''}}" class="  form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3 align-self-center">
                                                                <label for="type" class="form-label">لجنة/فرقه</label>
                                                            </div>
                                                            <div class="col-md-9">

                                                                <select required name="classification" id="classification" class="form-control custom-select">
                                                                    <option value="">اختر لجنة/فرقه</option>
                                                                    @foreach ([1=>'لجنة', 2=>'فرقه'] as $index=>$value)
                                                                        <option value="{{ $index }}">{{ $value }}</option>
                                                                    @endforeach
                                                                    <!-- Other options -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="row form-group" style="padding-top: 51px;">
                                                        <div class="col-md-6">
                                                            <button style="color: #0A3A81; border: 1px solid #e6a935; width: 50%;" type="reset" class="col-md-3 btn btn-default custom-reset-button">إنهاء</button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button style="background-color: #0A3A81; width: 50%;" type="submit" class="col-md-3 float-end btn btn-primary custom-submit-button" >انشاء</button>
                                                        </div>
                                                    </div>

                                            </div>
                                        </div>
                                        <div class="col-md-4"></div>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
            </form>
        </div>

    </div>
@endsection

