@extends('layouts.app')

@section('title', __('messages.classes.upload_file_title'))

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="col-md-12 grid-margin">
                <div class="container">
                    <div class="card p-4 shadow-sm pt-5">
                        <form action="{{ route('classes.store') }}" method="POST" enctype="multipart/form-data"
                            style="width: 80%; margin: 0 auto;">
                            @csrf
                            <h3>{{ __('messages.classes.select_file') }}</h3>
                            <div class="form-group">
                                <label for="file">{{ __('messages.classes.file') }}</label>
                                <input type="file" name="file" id="file" class="form-control" required>
                            </div>
                            <input type="hidden" name="user_id">
                            <button type="submit"
                                class="btn btn-primary">{{ __('messages.classes.upload_file_button_text') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
