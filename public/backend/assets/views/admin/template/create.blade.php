@extends('layouts.app')

@section('title', __('messages.template.register_title'))

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="col-md-12 grid-margin">
                    <div class="container">
                        <div class="card p-4 shadow-sm pt-5">
                            <h3 class="card-title text-center mb-4">{{ __('messages.template.register_title') }}</h3>
                            <form class="forms-sample" action="{{ route('template.store') }}" method="POST"
                                enctype="multipart/form-data" style="width: 80%; margin: 0 auto;">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label">{{ __('messages.template.form.file_type') }}</label>
                                        <select class="form-select" name="file_type">
                                            <option selected>{{ __('messages.template.form.select_template') }}</option>
                                            <option value="classes">{{ __('messages.template.form.classes') }}</option>
                                            <option value="subjects">{{ __('messages.template.form.subjects') }}</option>
                                            <option value="teachers">{{ __('messages.template.form.teachers') }}</option>
                                            <option value="students">{{ __('messages.template.form.students') }}</option>
                                            <option value="marks">{{ __('messages.template.form.marks') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3 d-flex">
                                    <div class="col-md-12 mb-1">
                                        <label class="form-label" for="file">{{ __('messages.template.form.file') }}</label>
                                        <input class="form-control" type="file" id="file" name="file">
                                    </div>
                                </div>
                                <div class="text-center mt-3 mb-4">
                                    <button type="submit" class="btn btn-inverse-success btn-lg w-100">{{ __('messages.template.save_button') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#file').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
