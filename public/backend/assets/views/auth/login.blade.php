@extends('layouts.guest')

@section('title', 'Login')

@section('auth')

    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">

            <div class="content-wrapper full-page-wrapper d-flex align-items-center auth" style="background-image: url('{{ asset('backend/assets/images/auth/lockscreen-bg.jpg') }}'); background-size: cover; background-position: center;">
                <div class="card card-faded col-lg-4 mx-auto">

                    <div class="card-body px-5 py-5">
                        <div class="row">
                            @if (session('error'))
                                <div class="text-danger text-center mt-3 mb-3" style="font-weight: bolder">
                                    {!! session('error') !!}
                                </div>
                            @endif
                        </div>
                        <h3 class="card-title text-center mb-3 pb-3 text-success">LOGIN MOBISCHO</h3>
                        <form class="forms-sample" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Nom Utilisateur <span class="text-danger">*</span></label>
                                <input type="text" class="form-control p_input" id="login" name="login"
                                    placeholder="Entrez le nom d'utilisateur" :value="old('login')" required autofocus>
                                <x-input-error :messages="$errors->get('login')" class="mt-2 text-danger" />
                            </div>
                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control p_input" id="password" name="password"
                                    placeholder="Password" required autocomplete="current-password">
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between">
                                <div class="form-check">
                                    <label class="form-check-label" for="remember_me">
                                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                        Remember me </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="forgot-pass" href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success btn-block enter-btn"
                                    style="width: 50%;">Login</button>
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
