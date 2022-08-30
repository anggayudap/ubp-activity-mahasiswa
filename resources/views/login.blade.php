@extends('layouts.master_auth')

@section('title', 'Halaman Login')

@section('content')
    <div class="auth-wrapper auth-v1 px-2">
        <div class="auth-inner py-2">
            <!-- Login basic -->
            <div class="card mb-0">
                <div class="card-body">
                    <h4 class="card-title mb-1">Sistem Informasi Kegiatan Mahasiswa</h4>
                    <p class="card-text mb-2">Silahkan login menggunakan akun SIPT anda</p>

                    <form class="auth-login-form mt-2" action="{{ route('login_submit') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="john@example.com" value="{{ old('email') }}"
                                aria-describedby="email" tabindex="1" autofocus />
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                                <label for="password">Password</label>
                                <a target="_blank" href="https://sipt2.ubpkarawang.ac.id/forgot-password">
                                    <small>Lupa password?</small>
                                </a>
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input type="password" class="form-control form-control-merge" id="password"
                                    name="password" tabindex="2"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="login-password" />
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="remember-me" tabindex="3" />
                                <label class="custom-control-label" for="remember-me"> Remember Me </label>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block" tabindex="4">Sign in</button>

                    </form>

                </div>
            </div>
            <!-- /Login basic -->
        </div>
    </div>
@stop

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('vuexy/css/pages/page-auth.css') }}">
@endpush

@push('scripts')
    <script src="{{ URL::asset('vuexy/js/scripts/pages/page-auth-login.js') }}"></script>
@endpush
