@extends('layouts.app')

@section('title', __('messages.template.list_title'))

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="text-end mb-3">
                            @if (Auth::user()->role != 'user')
                                <a class="btn btn-success d-inline-flex align-items-center"
                                    href="{{ route('template.create') }}" style="font-size: 0.75rem;">
                                    {{ __('messages.template.create_button') }}<i class="ms-2 mdi mdi-plus-circle mdi-24px"></i>
                                </a>
                            @endif
                        </div>
                        <h3 class="card-title">{{ __('messages.template.list_title') }}</h3>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th class="">#</th>
                                        <th class="">{{ __('messages.template.table_headers.file_name') }}</th>
                                        <th class="">{{ __('messages.template.table_headers.type') }}</th>
                                        <th class="">{{ __('messages.template.table_headers.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($templates as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->file_name }}</td>
                                            <td>{{ $item->file_type }}</td>
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    @if (Auth::user()->role != 'user')
                                                        <form action="{{ route('template.delete', $item->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('{{ __('messages.template.delete_confirmation') }}');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger">{{ __('messages.template.delete') }}</button>
                                                        </form>
                                                    @endif
                                                    <a class="btn text-sem btn-success"
                                                        href="{{ route('template.download', $item->id) }}"
                                                        style="display: flex; align-items: center;">
                                                        {{ __('messages.template.download') }} <i class="ms-2 mdi mdi-download"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="{{ Auth::user()->role != 'user' ? '4' : '3' }}" class="text-center text-info">
                                            <h5>{{ __('messages.template.no_data_found') }}</h5>
                                        </td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
