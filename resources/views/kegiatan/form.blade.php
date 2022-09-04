@extends('layouts.master')
@if (isset($data))
    @section('title', 'Form Edit Kegiatan Mahasiswa')
@else
    @section('title', 'Form Tambah Kegiatan Mahasiswa')
@endif
{{-- @section('menu-title', 'Master Data Departemen') --}}


@section('content')
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <form action="{{ isset($data) ? route('kegiatan.update', $data->id) : route('kegiatan.store') }}"
                        method="post" class="form form-horizontal need-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                        @if (isset($data))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Nama Kegiatan</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="nama-kegiatan" class="form-control" name="nama_kegiatan"
                                            placeholder="Nama Kegiatan"
                                            value="{{ isset($data) ? $data->nama_kegiatan : old('nama_kegiatan') }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Tanggal Mulai Kegiatan</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="tanggal-mulai" class="form-control flatpickr-basic"
                                            name="tanggal_mulai" placeholder="Tanggal Mulai Kegiatan"
                                            value="{{ isset($data) ? $data->tanggal_mulai : old('tanggal_mulai') }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Tanggal Akhir Kegiatan</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="tanggal-akhir" class="form-control flatpickr-basic"
                                            name="tanggal_akhir" placeholder="Tanggal Akhir Kegiatan"
                                            value="{{ isset($data) ? $data->tanggal_akhir : old('tanggal_akhir') }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Klasifikasi Kegiatan</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="klasifikasi_id" id="klasifikasi-id" required>
                                            <option>Pilih Klasifikasi</option>
                                            @foreach ($klasifikasi as $group => $item)
                                                <optgroup label="{{ $group }}">
                                                    @foreach ($klasifikasi[$group] as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name_kegiatan }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">URL/Link Pendaftaran</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="tanggal-akhir" class="form-control " name="tanggal_akhir"
                                            placeholder="URL/Link Pendaftaran"
                                            value="{{ isset($data) ? $data->tanggal_akhir : old('tanggal_akhir') }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Surat Tugas</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="surat_tugas"
                                                accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" />
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Foto Kegiatan</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="foto_kegiatan"
                                                accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" />
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Bukti Kegiatan (sertifikat, dll)</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="bukti_sertifikat"
                                                accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" />
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Keterangan</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="keterangan" class="form-control " name="keterangan"
                                            placeholder="Keterangan"
                                            value="{{ isset($data) ? $data->keterangan : old('keterangan') }}" required>
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
    <link rel="stylesheet" href="{{ URL::asset('css/form.css') }}">
@endpush

@push('scripts')
    <script src="{{ URL::asset('js/form.js') }}"></script>

    <script>
        $(document).ready(function() {
            const basicPickr = $('.flatpickr-basic');
            if (basicPickr.length) {
                basicPickr.flatpickr();
            }
            // console.log('nice');
        });
    </script>
@endpush
