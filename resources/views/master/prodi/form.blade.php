@extends('layouts.master')

@section('title', 'Form Data Prodi')
@section('menu-title', 'Master Data Prodi')


@section('content')
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ isset($data) ? 'Edit' : 'Tambah' }} Data Prodi</h4>
                </div>
                <div class="card-body">
                    <form action="{{ isset($data) ? route('master.prodi.update', $data->id) : route('master.prodi.store') }}"
                        method="post" class="form form-horizontal need-validation" novalidate>
                        @csrf
                        @if (isset($data))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Kode Prodi</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="kode-prodi" class="form-control" name="kode_prodi"
                                            placeholder="Kode Prodi" value="{{ isset($data) ? $data->kode_prodi : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="code">Nama Prodi</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="nama-prodi" class="form-control" name="nama_prodi"
                                            placeholder="Nama Prodi" value="{{ isset($data) ? $data->nama_prodi : '' }}">
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
