@extends('layouts.master')
@if (isset($data['proposal']))
    @section('title', 'Buat Proposal Kegiatan')
@else
    @section('title', 'Form Buat Proposal Kegiatan')
@endif
{{-- @section('menu-title', 'Master Data Departemen') --}}


@section('content')
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($data['proposal']) ? route('proposal.update', $data['proposal']->id) : route('proposal.store') }}"
                        method="post" class="form form-horizontal " enctype="multipart/form-data" novalidate>
                        @csrf
                        @if (isset($data['proposal']))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Tanggal Proposal</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="date" class="form-control flatpickr-basic"
                                            name="date" placeholder="Tanggal Proposal"
                                            value="{{ isset($data['proposal']) ? $data['proposal']->date : old('date') }}"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Judul Proposal</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="judul-proposal" class="form-control" name="judul_proposal"
                                            placeholder="Judul Proposal"
                                            value="{{ isset($data['proposal']) ? $data['proposal']->judul_proposal : old('judul_proposal') }}"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Ketua Pelaksana</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="ketua-pelaksana" class="form-control"
                                            name="ketua_pelaksana" placeholder="Ketua Pelaksana"
                                            value="{{ isset($data['proposal']) ? $data['proposal']->ketua_pelaksana : old('ketua_pelaksana') }}"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Tanggal Mulai Kegiatan</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="start-date" class="form-control flatpickr-basic"
                                            name="tanggal_mulai" placeholder="Tanggal Mulai"
                                            value="{{ isset($data['proposal']) ? $data['proposal']->tanggal_mulai : old('tanggal_mulai') }}"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Tanggal Akhir Kegiatan</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="end-date" class="form-control flatpickr-basic"
                                            name="tanggal_akhir" placeholder="Tanggal Akhir"
                                            value="{{ isset($data['proposal']) ? $data['proposal']->tanggal_akhir : old('tanggal_akhir') }}"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Anggaran Pengajuan</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" id="anggaran-pengajuan" class="form-control"
                                            name="anggaran_pengajuan" placeholder="Anggaran Pengajuan"
                                            value="{{ isset($data['proposal']) ? $data['proposal']->anggaran_pengajuan : old('anggaran_pengajuan') }}"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">File Proposal</label>
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file-proposal"
                                                name="file_proposal" accept="application/pdf" />
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group row">
                                    <em>Ket : Upload file menggunakan format pdf. Maks. size 5mb.</em>
                                </div>
                            </div>



                            <div class="col-sm-6 offset-sm-3">
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
