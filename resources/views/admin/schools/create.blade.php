@extends('layouts.app')

@section('title', __('messages.school.register'))

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="col-md-12 grid-margin">
                    <div class="container">
                        <div class="card p-4 shadow-sm pt-5">
                            <h3 class="card-title text-center mb-4">{{ __('messages.school.register') }}</h3>
                            <form class="forms-sample" action="{{ route('schools.store') }}" method="POST" enctype="multipart/form-data" style="width: 80%; margin: 0 auto;">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('messages.school.school_name') }}</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('messages.school.enter_school_name') }}" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">{{ __('messages.school.email') }}</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('messages.school.enter_email') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="code_school" class="form-label">{{ __('messages.school.pass_code') }}</label>
                                            <input type="text" class="form-control" id="code_school" name="code_school" value="{{ $schoolCode }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">{{ __('messages.school.address') }}</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="{{ __('messages.school.enter_address') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contact" class="form-label">{{ __('messages.school.contact') }}</label>
                                        <input type="tel" class="form-control" id="contact" name="contact" placeholder="{{ __('messages.school.enter_contact') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="photo" class="form-label">{{ __('messages.school.photo') }}</label>
                                    <input type="file" class="form-control" id="photo" name="photo">
                                </div>
                                <div class="text-center mt-3 mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-3 mb-4">{{ __('messages.school.register') }}</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


