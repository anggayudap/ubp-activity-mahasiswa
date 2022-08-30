@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
                    <div class="col-12">
                        <div class="alert alert-primary" role="alert">
                            <div class="alert-body">
                                <strong>Info:</strong> This layout can be useful for getting started with empty content section. Please check
                                the&nbsp;<a class="text-primary" href="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/documentation/documentation-layout-empty.html" target="_blank">Layout empty documentation</a>&nbsp; for more details.
                            </div>
                        </div>
                    </div>
                </div>
@stop

@push('styles')
    {{-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('vuexy/vendors/css/charts/apexcharts.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('vuexy/vendors/css/extensions/toastr.min.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('vuexy/css/pages/dashboard-ecommerce.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('vuexy/css/plugins/charts/chart-apex.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('vuexy/css/plugins/extensions/ext-component-toastr.css') }}"> --}}
@endpush

@push('scripts')
    {{-- <script src="{{ URL::asset('vuexy/vendors/js/vendors.min.js') }}"></script> --}}
    {{-- <script src="{{ URL::asset('vuexy/vendors/js/charts/apexcharts.min.js') }}"></script> --}}
    {{-- <script src="{{ URL::asset('vuexy/vendors/js/extensions/toastr.min.js') }}"></script> --}}
    {{-- <script src="{{ URL::asset('vuexy/js/core/app-menu.js') }}"></script> --}}
    {{-- <script src="{{ URL::asset('vuexy/js/core/app.js') }}"></script> --}}
    {{-- <script src="{{ URL::asset('vuexy/js/scripts/pages/dashboard-ecommerce.js') }}"></script> --}}
@endpush