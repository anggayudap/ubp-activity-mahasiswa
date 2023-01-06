@extends('layouts.master')

@section('title', 'Form Data Skema')
@section('menu-title', 'Master Data Skema')


@section('content')
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ isset($data) ? 'Edit' : 'Tambah' }} Data Skema</h4>
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($data) ? route('master.skema.update', $data->id) : route('master.skema.store') }}"
                        method="post" class="form form-horizontal need-validation" novalidate>
                        @csrf
                        @if (isset($data))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Nama Skema</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="nama-skema" class="form-control" name="nama_skema"
                                            placeholder="Nama Skema" value="{{ isset($data) ? $data->nama_skema : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="code">Deskripsi Skema (opsional)</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="deskripsi-skema" class="form-control"
                                            name="deskripsi_skema" placeholder="Deskripsi Skema"
                                            value="{{ isset($data) ? $data->deskripsi_skema : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="code">Status</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select name="aktif" id="aktif" class="form-control">
                                            <option value="1"
                                                {{ isset($data) && $data->aktif == 1 ? 'selected' : '' }}>Aktif</option>
                                            <option value="0"
                                                {{ isset($data) && $data->aktif == 0 ? 'selected' : '' }}>Tidak Aktif
                                            </option>
                                        </select>

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
