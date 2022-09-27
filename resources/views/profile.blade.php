@extends('layouts.master')

@section('title', 'Profile')

@section('content')
    <div class="row">
        <!-- User Card starts-->
        <div class="col-12">
            <div class="card user-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-12 d-flex flex-column justify-content-between border-container-lg">
                            <div class="user-avatar-section">
                                <div class="d-flex justify-content-start">

                                    <div class="d-flex flex-column ml-1">
                                        <div class="user-info mb-1">
                                            <h2 class="mb-0">{{ session('user.nama') }}</h2>
                                            <h4 class="mb-0">{{ session('user.id') }}</h4>
                                            <span class="card-text">{{ session('user.email') }}</span>
                                        </div>
                                        <div class="d-flex flex-wrap">

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                            <div class="user-info-wrapper">
                                <div class="d-flex flex-wrap">
                                    <div class="user-info-title mr-2">
                                        <i data-feather="user" class="mr-1"></i>
                                        <span class="card-text user-info-title font-weight-bold mb-0">Akun</span>
                                    </div>
                                    <p class="card-text mb-0">{{ session('user.role') }}
                                        {{ session('user.employee') ? '(' . session('user.employee') . ')' : '' }}</p>
                                </div>
                                <div class="d-flex flex-wrap my-50">
                                    <div class="user-info-title mr-2">
                                        <i data-feather="check" class="mr-1"></i>
                                        <span class="card-text user-info-title font-weight-bold mb-0">Status</span>
                                    </div>
                                    <p class="card-text mb-0">Active</p>
                                </div>
                                <div class="d-flex flex-wrap my-50">
                                    <div class="user-info-title mr-2">
                                        <i data-feather="star" class="mr-1"></i>
                                        <span class="card-text user-info-title font-weight-bold mb-0">Role</span>
                                    </div>
                                    @php
                                        $user = Auth::user();
                                    @endphp
                                    <p class="card-text mb-0">{{ $user->getRoleNames()->implode(', ') }}</p>
                                </div>
                                <div class="d-flex flex-wrap my-50">
                                    <div class="user-info-title mr-2">
                                        <i data-feather="flag" class="mr-1"></i>
                                        <span class="card-text user-info-title font-weight-bold mb-0">Prodi</span>
                                    </div>
                                    <p class="card-text mb-0">{{ session('user.prodi') }}</p>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="user-info-title mr-2">
                                        <i data-feather="phone" class="mr-1"></i>
                                        <span class="card-text user-info-title font-weight-bold mb-0">Contact</span>
                                    </div>
                                    <p class="card-text mb-0">(123) 456-7890</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
