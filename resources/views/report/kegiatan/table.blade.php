@extends('layouts.master_table')

@section('title', 'View Report Kegiatan Mahasiswa')
@section('menu-title', 'View Report Kegiatan Mahasiswa')

@section('content')
    <div class="content-header row">
        <div class="col-12 d-flex  justify-content-md-center align-self-center">
            <h1>Report Kegiatan Mahasiswa</h1>
        </div>

    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12 p-4">
                <div class="table-responsive">
                    <table class="table table-hover-animation">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Nama Mahasiswa</th>
                                <th scope="col">Prodi</th>
                                <th scope="col">Periode</th>
                                <th scope="col">Tahun</th>
                                <th scope="col">Nama Kegiatan</th>
                                <th scope="col">Klasifikasi</th>
                                <th scope="col">Tanggal Kegiatan</th>
                                <th scope="col">Cakupan</th>
                                <th scope="col">Link Kegiatan</th>
                                <th scope="col">Surat Tugas</th>
                                <th scope="col">Foto Kegiatan</th>
                                <th scope="col">Bukti Kegiatan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Approval</th>
                                <th scope="col">Prestasi</th>
                                <th scope="col">Keterangan</th>
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
                                    <td>{{ $kegiatan->nama_mahasiswa }}</td>
                                    <td>{{ $kegiatan->prodi_mahasiswa->nama_prodi ?? $kegiatan->prodi }}</td>
                                    <td>{{ $kegiatan->periode ? $kegiatan->periode->periode_awal . '-' . $kegiatan->periode->periode_akhir : '' }}
                                    </td>
                                    <td>{{ $kegiatan->tahun_periode }}</td>
                                    <td>{{ $kegiatan->nama_kegiatan }}</td>
                                    <td>{{ $kegiatan->klasifikasi->name_kegiatan }}</td>
                                    <td>{{ get_indo_date($kegiatan->tanggal_mulai) . ' s/d ' . get_indo_date($kegiatan->tanggal_akhir) }}
                                    </td>
                                    <td>{{ ucfirst($kegiatan->cakupan) }}</td>
                                    <td><a target="_blank" href="{{ $kegiatan->url_event }}" class="btn btn-primary"><i
                                                data-feather="link"></i></a></td>
                                    <td><a target="_blank" href="{{ asset($kegiatan->surat_tugas) }}"
                                            class="btn btn-primary"><i data-feather="file"></i></a></td>
                                    <td><a target="_blank" href="{{ $kegiatan->foto_kegiatan }}" class="btn btn-primary"><i
                                                data-feather="file"></i></a></td>
                                    <td><a target="_blank" href="{{ $kegiatan->bukti_kegiatan }}"
                                            class="btn btn-primary"><i data-feather="file"></i></a></td>
                                    <td>{!! trans('serba.' . $kegiatan->status) !!}</td>
                                    <td>{!! ($kegiatan->approval) ? trans('serba.' . $kegiatan->approval) : '&nbsp;' !!}</td>
                                    <td>{{ $kegiatan->prestasi }}</td>
                                    <td>{{ $kegiatan->keterangan }}</td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="18" class="text-center">
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
        .table > thead > tr > th {
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
