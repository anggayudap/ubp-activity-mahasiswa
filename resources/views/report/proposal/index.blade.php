@extends('layouts.master')

@section('title', 'Report Proposal Kegiatan')


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
                            action="{{ route('report.proposal.submit') }}" method="post"
                            target="javascript:window.open('','targetNew')" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-3 col-form-label">
                                            <label>Tipe</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="tipe" id="tipe" required>
                                                <option>Pilih tipe</option>
                                                <option value="summary">Summary Pengambilan Barang</option>
                                                <option value="pengambilan">Detail Pengambilan Barang</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 col-form-label">
                                            <label>Departemen</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="select2 form-control" name="mahasiswa" id="mahasiswa">
                                                @foreach ($data['mahasiswa'] as $mahasiswa)
                                                    <option value="{{ $mahasiswa->user_id }}">{{ $mahasiswa->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 col-form-label">
                                            <label>Status Permintaan</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="status[]" id="status" multiple="multiple">
                                                <option value="pending">Pending</option>
                                                <option value="menunggu_persetujuan">Menunggu Persetujuan</option>
                                                <option value="siap_diambil">Siap Diambil</option>
                                                <option value="selesai">Selesai</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 col-form-label">
                                            <label>Dari Tanggal</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" id="start-date" class="form-control flatpickr-basic"
                                                name="start_date" required value="{{ date('Y-m-d') }}" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 col-form-label">
                                            <label>Sampai Tanggal</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" id="end-date" class="form-control flatpickr-basic"
                                                name="end_date" required value="{{ date('Y-m-d') }}" />
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
                                    <button type="submit" name="submit" value="excel" class="btn btn-success mr-1"><i
                                            data-feather="download" class="mr-1"></i>Excel</button>
                                    <button type="submit" name="submit" value="view" class="btn btn-primary mr-1"><i
                                            data-feather="file-text" class="mr-1"></i>View</button>
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
                basicPickr.flatpickr();
            }
        });
    </script>
@endpush
