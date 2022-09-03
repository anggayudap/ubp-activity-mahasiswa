@extends('layouts.master')

@section('title', 'Form Data Periode')
@section('menu-title', 'Master Data Periode')


@section('content')
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ isset($data) ? 'Edit' : 'Tambah' }} Data Periode</h4>
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($data) ? route('master.periode.update', $data->id) : route('master.periode.store') }}"
                        method="post" class="form form-horizontal need-validation" novalidate>
                        @csrf
                        @if (isset($data))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Periode Awal</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="periode-awal" class="form-control" name="periode_awal"
                                            placeholder="Periode Awal"
                                            value="{{ isset($data) ? $data->periode_awal : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="code">Kode</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="periode-akhir" class="form-control" name="periode_akhir"
                                            placeholder="Periode Akhir"
                                            value="{{ isset($data) ? $data->periode_akhir : '' }}">
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
