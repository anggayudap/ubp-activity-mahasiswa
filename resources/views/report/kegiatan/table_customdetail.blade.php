@extends('layouts.master_table')

@section('title', 'View Report Kegiatan Mahasiswa')
@section('menu-title', 'View Report Kegiatan Mahasiswa')

@section('content')
    <div class="content-header row">
        <div class="col-12 d-flex  justify-content-md-center align-self-center">
            <h1>Report :: Custom Detail Kegiatan Mahasiswa</h1>
        </div>

    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12 p-4">
                <div class="table-responsive">
                    <table class="table table-hover-animation">
                        <thead class="text-center">
                            <tr>
                                <th rowspan="2" scope="col">No.</th>
                                <th rowspan="2" scope="col">NIM</th>
                                <th rowspan="2" scope="col">Nama Kegiatan</th>
                                <th rowspan="2" scope="col">Waktu Penyelenggaraan<br>(YYYY)</th>
                                <th colspan="3" scope="col">Tingkat *)</th>
                                <th rowspan="2"scope="col">Prestasi Yang Dicapai</th>
                            </tr>
                            <tr>
                                <th scope="row">Povinsi/Wilayah</th>
                                <th scope="row">Nasional</th>
                                <th scope="row">Internasional</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @forelse ($output['result'] as $kegiatan)
                                <tr class="text-nowrap">
                                    <td class="text-nowrap">{{ $i }}</td>
                                    <td>{{ $kegiatan->nim }}</td>
                                    <td>{{ $kegiatan->nama_kegiatan }}</td>
                                    <td class="text-center">{{ $kegiatan->tahun_periode }}</td>
                                    <td class="text-center">{!! $kegiatan->cakupan == 'lokal' ? '<i data-feather="check"></i>' : '' !!}</td>
                                    <td class="text-center">{!! $kegiatan->cakupan == 'nasional' ? '<i data-feather="check"></i>' : '' !!}</td>
                                    <td class="text-center">{!! $kegiatan->cakupan == 'internasional' ? '<i data-feather="check"></i>' : '' !!}</td>
                                    <td>{{ $kegiatan->prestasi }}</td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <h4 class="text-danger">Tidak ada data yang dapat ditampilkan.</h4>
                                    </td>
                                </tr>
                            @endforelse


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('styles')
    {{-- write css script here --}}
    <link rel="stylesheet" href="{{ URL::asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/form.css') }}">
    <style>
        /* add vertical align in th */
        .table>thead>tr>th {
            vertical-align: middle;
        }
    </style>
@endpush

@push('scripts')
    {{-- write js script here --}}
    <script src="{{ URL::asset('js/table.js') }}"></script>
    <script src="{{ URL::asset('js/form.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            'use strict';


        });
    </script>
@endpush
