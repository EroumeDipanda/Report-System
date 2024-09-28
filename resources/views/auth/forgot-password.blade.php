{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('auth')

    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">

            <div class="content-wrapper full-page-wrapper d-flex align-items-center auth"
                style="background-image: url('{{ asset('backend/assets/images/auth/lockscreen-bg.jpg') }}'); background-size: cover; background-position: center;">
                <div class="card card-faded col-lg-4 mx-auto">
                        {{-- <div class="mt-4 ms-4 me-4 text-center">
                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </div> --}}
                        <div class="mt-4 ms-4 me-4 text-center">
                            Vous avez oublié votre mot de passe ? Aucun problème. Indiquez-nous simplement votre adresse email et nous vous enverrons un lien de réinitialisation de mot de passe par email, vous permettant de choisir un nouveau mot de passe.
                        </div>
                    <div class="card-body ">

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

                        <form class="forms-sample" action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control p_input" id="email" name="email"
                                    placeholder="Entrez votre addresse email" :value="old('email')" required autofocus>
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-success pt-2 pb-2" style="width: 100%;">Lien de
                                    réinitialisation de mot de passe</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
    </div>
@endsection
