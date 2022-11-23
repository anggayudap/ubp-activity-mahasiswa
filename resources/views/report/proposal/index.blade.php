@extends('layouts.master')

@section('title', 'Report Proposal Kegiatan')
@section('menu-title', 'Report Proposal Kegiatan')


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
                                            <label>Prodi</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="prodi" id="prodi">
                                                <option value="all">SEMUA PRODI</option>
                                                @foreach ($data['fetch_prodi'] as $prodi)
                                                    <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-md-3 col-form-label">
                                            <label>Status Proposal <em>(Pilih satu atau lebih)</em></label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="status[]" id="status" multiple="multiple">
                                                <option value="wait_fakultas">Menunggu Approval Fakultas</option>
                                                <option value="wait_kemahasiswaan">Menunggu Approval Kemahasiswaan</option>
                                                <option value="reject">Reject</option>
                                                <option value="completed">Selesai</option>
                                            </select>
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
