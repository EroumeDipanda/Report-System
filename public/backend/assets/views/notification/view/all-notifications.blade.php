@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="">TOUTES NOTIFICATIONS</h1>
        <form action="{{ route('notifications.destroyAll') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-inverse-danger pt-2 pb-2">Tout Supprimer</button>
        </form>
    </div>


    @forelse ($notifications as $notification)
        <div class="card mb-3 shadow-sm border-0">
            <div class="card-body d-flex align-items-start">
                <div class="icon me-3">
                    @if (isset($notification->data['user_name']))
                        <i class="mdi mdi-file-upload text-success" style="font-size: 24px;"></i>
                    @else
                        <i class="mdi mdi-alert text-danger" style="font-size: 24px;"></i>
                    @endif
                </div>
                <div class="flex-grow-1">
                    <h5 class="card-title mb-1">{{ $notification->data['message'] }}</h5>
                    @if (isset($notification->data['file_type']) && isset($notification->data['user_name']))
                        <p class="card-text text-muted small">
                            Type de Fichier: {{ $notification->data['file_type'] }} | Chargé par: {{ $notification->data['user_name'] }}
                        </p>
                    @endif
                    <p class="text-muted small mb-0">
                        {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                    </p>
                </div>
                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="ms-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Supprimer</button>
                </form>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center" role="alert">
            Aucune notification disponible.
        </div>
    @endforelse
</div>
@endsection
