@extends('layouts.master_table')

@section('title', 'View Report Detail Kompetisi')
@section('menu-title', 'View Report Detail Kompetisi')

@section('content')
    <div class="content-header row">
        <div class="col-12 d-flex  justify-content-md-center align-self-center">
            <h1>Report :: Detail Kompetisi</h1>
        </div>

    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12 p-4">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Kompetisi</th>
                                <th>Skema Kompetisi</th>
                                <th>Dosen Pembimbing</th>
                                <th>Nama Ketua</th>
                                <th>Prodi</th>
                                <th>Nama Anggota</th>
                                <th>File</th>
                                <th>Dosen Penilai</th>
                                <th>Catatan</th>
                                <th>Tanggal Approval</th>
                                <th>Nama Approval</th>
                                <th>Status</th>
                                <th>Keputusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                                
                            @endphp
                            @forelse ($output['result'] as $participant)
                                @php
                                    $member_ketua = $participant->member->filter(function ($value, $key) {
                                        return $value->status_keanggotaan == 'ketua';
                                    });
                                    $member_ketua->all();
                                    $member_ketua = $member_ketua->first();
                                    
                                    $member_anggota = $participant->member->filter(function ($value, $key) {
                                        return $value->status_keanggotaan == 'anggota';
                                    });
                                    $member_anggota = $member_anggota->all();
                                @endphp
                                <tr>
                                    <td class="text-nowrap">{{ $i }}</td>
                                    <td>{{ $participant->kompetisi->nama_kompetisi }}</td>
                                    <td>{{ $participant->nama_skema }}</td>
                                    <td>{{ $participant->nama_dosen_pembimbing }}<br>({{ $participant->nip_dosen_pembimbing }})
                                    </td>
                                    <td>{{ $member_ketua->nama_mahasiswa }}<br>({{ $member_ketua->nim }})</td>
                                    <td>{{ $member_ketua->prodi_mahasiswa->nama_prodi }}</td>
                                    <td>
                                        <ul>

                                            @foreach ($member_anggota as $anggota)
                                                <li>{{ $anggota->nama_mahasiswa }}<br>({{ $anggota->nim }})</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td><a target="_blank" href="{{ asset($participant->file_upload) }}"
                                            class="btn btn-success"><i data-feather="file"></i></a></td>
                                    <td>{{ $participant->nama_dosen_penilai }}<br>({{ $participant->nip_dosen_penilai }})
                                    </td>
                                    <td>{!! $participant->catatan !!}</td>
                                    <td>{{ get_indo_date($participant->tanggal_approval) }}</td>
                                    <td>{{ $participant->nama_approval }}</td>
                                    <td>{!! trans('serba.' . $participant->status) !!}</td>
                                    <td>{!! $participant->keputusan ? trans('serba.' . $participant->keputusan) : '-' !!}</td>


                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="14" class="text-center">
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
