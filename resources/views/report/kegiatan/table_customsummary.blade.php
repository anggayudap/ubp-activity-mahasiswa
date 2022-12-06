@extends('layouts.master_table')

@section('title', 'View Report Kegiatan Mahasiswa')
@section('menu-title', 'View Report Kegiatan Mahasiswa')

@section('content')
    <div class="content-header row">
        <div class="col-12 d-flex  justify-content-md-center align-self-center">
            <h1>Report :: Custom Summary Kegiatan Mahasiswa</h1>
        </div>

    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12 p-4">
                <div class="table-responsive">
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th scope="col" rowspan="2">Nama Prodi (Kode)</th>
                                <th scope="col" rowspan="2" class="text-center">Total Kegiatan</th>
                                <th scope="col" colspan="3" class="text-center">Tingkat</th>
                                <th scope="col" rowspan="2">Detail</th>
                            </tr>
                            <tr>
                                <th scope="col" class="text-center">Povinsi/Wilayah</th>
                                <th scope="col" class="text-center">Nasional</th>
                                <th scope="col" class="text-center">Internasional</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_kegiatan = 0;
                                $total_lokal = 0;
                                $total_nasional = 0;
                                $total_internasional = 0;
                            @endphp
                            @forelse ($output['result']->groupBy('prodi') as $kode_prodi => $kegiatan)
                                @php
                                    $total_kegiatan += $kegiatan->count();
                                    $total_lokal += $output['cakupans'][$kode_prodi]['lokal'];
                                    $total_nasional += $output['cakupans'][$kode_prodi]['nasional'];
                                    $total_internasional += $output['cakupans'][$kode_prodi]['internasional'];
                                @endphp
                                <tr class="text-nowrap">
                                    <td>{!! $kegiatan[0]->prodi_mahasiswa->nama_prodi ?? '<em class="text-danger">Tidak ada data prodi</em>' !!} ({{ $kegiatan[0]->prodi }})</td>
                                    <td class="text-center">{{ $kegiatan->count() }}</td>
                                    <td class="text-center">{{ $output['cakupans'][$kode_prodi]['lokal'] }}</td>
                                    <td class="text-center">{{ $output['cakupans'][$kode_prodi]['nasional'] }}</td>
                                    <td class="text-center">{{ $output['cakupans'][$kode_prodi]['internasional'] }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($kegiatan as $value)
                                                <li>{{ $value->nama_kegiatan }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <h4 class="text-danger">Tidak ada data yang dapat ditampilkan.</h4>
                                    </td>
                                </tr>
                            @endforelse
                        <tfoot>
                            <tr>
                                <th class="text-right">TOTAL</th>
                                <th class="text-center">{{ $total_kegiatan }}</th>
                                <th class="text-center">{{ $total_lokal }}</th>
                                <th class="text-center">{{ $total_nasional }}</th>
                                <th class="text-center">{{ $total_internasional }}</th>
                                <td>&nbsp;</td>
                            </tr>
                        </tfoot>

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

        .table>tbody>tr>td {
            vertical-align: top !important;
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
