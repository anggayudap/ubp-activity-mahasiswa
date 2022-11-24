@extends('layouts.master_table')

@section('title', 'View Report Proposal Kegiatan')
@section('menu-title', 'View Report Proposal Kegiatan')

@section('content')
    <div class="content-header row">
        <div class="col-12 d-flex  justify-content-md-center align-self-center">
            <h1>Report Proposal Kegiatan</h1>
        </div>

    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12 p-4">
                <div class="table-responsive">
                    <table class="table table-hover-animation">
                        <thead>
                            <tr>
                                <th rowspan="2">#</th>
                                <th rowspan="2">NIM</th>
                                <th rowspan="2">Nama Mahasiswa</th>
                                <th rowspan="2">Prodi</th>
                                <th rowspan="2">Tanggal Proposal</th>
                                <th rowspan="2">Judul Proposal</th>
                                <th rowspan="2">Anggaran Pengajuan</th>
                                <th rowspan="2">Lampiran Proposal</th>
                                <th rowspan="2">Status</th>
                                <th colspan="2">Approval Fakultas</th>
                                <th colspan="2">Approval Kemahasiswaan</th>
                                <th rowspan="2">Note Reject</th>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @forelse ($output['result'] as $proposal)
                                <tr class="text-nowrap">
                                    <td class="text-nowrap">{{ $i }}</td>
                                    <td>{{ $proposal->nim }}</td>
                                    <td>{{ $proposal->nama_mahasiswa }}</td>
                                    <td>{{ $proposal->prodi_mahasiswa->nama_prodi ?? $proposal->prodi }}</td>
                                    <td>{{ get_date($proposal->date) }}</td>
                                    <td>{{ $proposal->judul_proposal }}</td>
                                    <td>{{ rupiah($proposal->anggaran_pengajuan) }}</td>
                                    <td></td>
                                    <td>{!! trans('serba.' . $proposal->current_status) !!}</td>
                                    <td>{{ get_date_time($proposal->fakultas_approval_date) }}</td>
                                    <td>{{ $proposal->fakultas_user_name }}</td>
                                    <td>{{ get_date_time($proposal->kemahasiswaan_approval_date) }}</td>
                                    <td>{{ $proposal->kemahasiswaan_user_name }}</td>
                                    <td>{{ $proposal->reject_note }}</td>


                                    {{-- <td>{{ $kegiatan->nim }}</td>
                                    <td>{{ $kegiatan->nama_mahasiswa }}</td>
                                    <td>{{ $kegiatan->prodi_mahasiswa->nama_prodi }}</td>
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
                                    <td>{!! trans('serba.' . $kegiatan->approval) !!}</td>
                                    <td>{{ $kegiatan->prestasi }}</td>
                                    <td>{{ $kegiatan->keterangan }}</td> --}}
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
