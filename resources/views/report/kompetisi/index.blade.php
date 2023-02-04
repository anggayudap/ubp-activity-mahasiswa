@extends('layouts.master')

@section('title', 'Report Kompetisi Kegiatan')
@section('menu-title', 'Report Kompetisi Kegiatan')


@section('content')
    <section>
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Filter Report </h4>
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal form-validate form-repeater need-validation"
                            action="{{ route('report.kompetisi.submit') }}" method="post"
                            target="javascript:window.open('','targetNew')" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-12">

                                    <div class="form-group row">
                                        <div class="col-md-3 col-form-label">
                                            <label>Tipe</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="type" required>
                                                <option value="detail_kompetisi" selected>Detail Kompetisi</option>
                                                <option value="detail_review">Detail Hasil Review</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-3 col-form-label">
                                            <label>NIM - Nama Mahasiswa</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="select2 form-control" name="nim" id="nim">
                                                <option value="all">SEMUA MAHASISWA</option>
                                                @if (isset($data['mahasiswa']))
                                                    @foreach ($data['mahasiswa'] as $nim => $value)
                                                        <option value="{{ $nim }}">
                                                            {{ $value->nim . ' - ' . $value->nama_mahasiswa }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-3 col-form-label">
                                            <label>Dosen Pembimbing</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="select2 form-control dropdown-dosen" name="dosen_pembimbing"
                                                id="dosen-pembimbing">
                                                <option value="all">SEMUA DOSEN</option>
                                                @if (isset($data['dosen']))
                                                    @foreach ($data['dosen'] as $nip => $value)
                                                        <option value="{{ $nip }}">
                                                            {{ $value->nip . ' - ' . $value->nama }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-3 col-form-label">
                                            <label>Dosen Penilai</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="select2 form-control dropdown-dosen" name="dosen_penilai"
                                                id="dosen-penilai">
                                                <option value="all">SEMUA DOSEN</option>
                                                @if (isset($data['dosen']))
                                                    @foreach ($data['dosen'] as $nip => $value)
                                                        <option value="{{ $nip }}">
                                                            {{ $value->nip . ' - ' . $value->nama }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-3 col-form-label">
                                            <label>Status Kompetisi <em>(Pilih satu atau lebih)</em></label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="status[]" id="status"
                                                data-live-search="true" multiple="multiple" required>
                                                <option value="pending">Pending</option>
                                                <option value="reject">Rejected/Ditolak</option>
                                                <option value="in_review">Dalam proses Review</option>
                                                <option value="reviewed">Sudah Direview</option>
                                                <option value="completed">Selesai</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-3 col-form-label">
                                            <label>Tanggal Kompetisi Dari</em></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" id="kompetisi-date-start"
                                                class="form-control flatpickr-basic" name="kompetisi_date_start"
                                                value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-3 col-form-label">
                                            <label>Tanggal Kompetisi Sampai</em></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" id="kompetisi-date-end"
                                                class="form-control flatpickr-basic" name="kompetisi_date_end"
                                                value="{{ date('Y-m-d') }}" required>
                                        </div>
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

                                <div class="col-md-6 offset-md-3">
                                    <button type="submit" name="submit" value="view" class="btn btn-primary mr-1"><i
                                            data-feather="file-text" class="mr-1"></i>Lihat Report</button>
                                    <button type="submit" name="submit" value="export" class="btn btn-success mr-1"><i
                                            data-feather="download" class="mr-1"></i>Export Excel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
@stop

@push('styles')
    {{-- write css script here --}}
    <link rel="stylesheet" href="{{ URL::asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/form.css') }}">
@endpush

@push('scripts')
    {{-- write js script here --}}
    <script src="{{ URL::asset('js/table.js') }}"></script>
    <script src="{{ URL::asset('js/form.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            'use strict';

            var basicPickr = $('.flatpickr-basic');
            // load flatpickr
            if (basicPickr.length) {
                basicPickr.flatpickr({
                    allowInput: true,
                });
            }

            const dropdownNim = document.querySelector('select#nim');
            $(dropdownNim).select2({
                width: '100%',
                placeholder: 'Cari npm atau nama mahasiswa',
                minimumInputLength: 3,
            });

            $('select.dropdown-dosen').select2({
                width: '100%',
                placeholder: 'Cari nip atau nama dosen',
                minimumInputLength: 3,
            });

            const dropdownStatus = document.querySelector('select#status');
            $(dropdownStatus).multiselect({
                nonSelectedText: 'Pilih satu atau lebih',
                buttonTextAlignment: 'left',
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                includeSelectAllOption: true,
                buttonWidth: '100%'
            });
        });
    </script>
@endpush
