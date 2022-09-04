@extends('layouts.master')

@section('title', 'Form Data Klasifikasi Kegiatan')
@section('menu-title', 'Master Data Klasifikasi Kegiatan')


@section('content')
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ isset($data) ? 'Edit' : 'Tambah' }} Data Klasifikasi Kegiatan</h4>
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($data) ? route('master.klasifikasi.update', $data->id) : route('master.klasifikasi.store') }}"
                        method="post" class="form form-horizontal need-validation" novalidate>
                        @csrf
                        @if (isset($data))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">{{ __('Nama Kegiatan') }}</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="name-kegiatan" class="form-control" name="name_kegiatan"
                                            value="{{ isset($data) ? $data->name_kegiatan : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">{{ __('Grup Kegiatan') }}</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="geoup-kegiatan" class="form-control" name="group_kegiatan"
                                            value="{{ isset($data) ? $data->group_kegiatan : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">{{ __('Nama Alternatif') }}</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="alternate-name-kegiatan" class="form-control"
                                            name="alternate_name_kegiatan"
                                            value="{{ isset($data) ? $data->alternate_name_kegiatan : '' }}">
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit"
                                    class="btn btn-primary mr-1 waves-effect waves-float waves-light">Submit
                                </button>
                                <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if ($errors->any())
                <div class="card mt-2">
                    <div class="card-body">
                        <h5>Terdapat kesalahan: </h5>
                        <div class="text-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>

@stop

@push('styles')
@endpush

@push('scripts')
@endpush
