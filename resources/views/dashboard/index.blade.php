@extends('layouts.master')

@php
    $role_names = [];
    $user = Auth::user();
    foreach ($user->getRoleNames() as $value) {
        $role_names[] = Str::ucfirst($value);
    }
@endphp

@section('title', 'Dashboard ' . implode(' & ', $role_names))

@section('content')
    <div class="row">
        @hasrole('mahasiswa')
            @include('dashboard.dashboard_mahasiswa')
        @endhasrole

        @hasrole('dosen')
            @include('dashboard.dashboard_dosen')
        @endhasrole

        @hasrole('dpm')
            @include('dashboard.dashboard_dpm')
        @endhasrole

        @hasrole('kemahasiswaan')
            @include('dashboard.dashboard_kemahasiswaan')
        @endhasrole
    </div>
@stop

@push('styles')
@endpush

@push('scripts')
@endpush
