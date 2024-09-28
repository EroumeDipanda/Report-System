{{-- <x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


@extends('layouts.guest')

@section('title', 'Reset Password')

@section('auth')

    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">

            <div class="content-wrapper full-page-wrapper d-flex align-items-center auth"
                style="background-image: url('{{ asset('backend/assets/images/auth/lockscreen-bg.jpg') }}'); background-size: cover; background-position: center;">
                <div class="card card-faded col-lg-4 mx-auto">
                    <div class="card-body ">

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

                        <form class="forms-sample" action="{{ route('password.store') }}" method="POST">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control p_input" id="email" name="email"
                                    placeholder="Entrez votre addresse email" value="{{ $email}}" required autofocus>
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label>Mot de passe <span class="text-danger">*</span></label>
                                <input type="password" class="form-control p_input" id="password" name="password"
                                    placeholder="Entrez votre mot de passe" :value="old('password', $request->password)" required autocomplete="new-password">
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group">
                                <label>Confirmer Mot de passe <span class="text-danger">*</span></label>
                                <input type="password" class="form-control p_input" name="password_confirmation"
                                    placeholder="Confirmer votre mot de passe" :value="old('password', $request->password)" required autocomplete="new-password">
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-success pt-2 pb-2" style="width: 100%;">
                                    Réinitialisation Mot de Passe</button>
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
