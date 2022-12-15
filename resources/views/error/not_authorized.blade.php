@extends('layouts.master_auth')

@section('title', 'Error - Akses Tidak Diizinkan')

@section('content')
    <!-- Not authorized-->
    <div class="misc-wrapper">
        
        <div class="misc-inner p-2 p-sm-3">
            <div class="w-100 text-center">
                <h2 class="mb-1">Maaf, akses akun anda tidak diizinkan! 🔐</h2>
                <p class="mb-2">
                    Akun anda tidak mendapatkan akses ke aplikasi ini. Silahkan hubungi penyedia akun anda!
                </p><a class="btn btn-primary mb-1 btn-sm-block" href="{{ route('login') }}">Kembali ke Login</a><img
                    class="img-fluid" src="{{ URL::asset('vuexy/images/pages/not-authorized.svg') }}" alt="Not authorized page" />
            </div>
        </div>
    </div>
    <!-- / Not authorized-->
@stop

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('vuexy/css/pages/page-misc.css') }}">


@endpush

@push('scripts')
@endpush
