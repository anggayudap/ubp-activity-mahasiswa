@extends('layouts.master_table')

@section('title', 'View Report Detail Review')
@section('menu-title', 'View Report Detail Review')

@section('content')
    <div class="content-header row">
        <div class="col-12 d-flex  justify-content-md-center align-self-center">
            <h1>Report :: Detail Review</h1>
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
                                <th>Judul Kompetisi Penilaian</th>
                                <th>Dosen Pembimbing</th>
                                <th>Nama Ketua</th>
                                <th>Prodi</th>
                                <th>Nama Anggota</th>
                                <th>File</th>
                                <th>Dosen Penilai</th>
                                <th>Aspek Review</th>
                                <th>Penilaian Review</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                                $rowspan = 1;
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
                                    
                                    if ($participant->review->count()) {
                                        $rowspan = $participant->review->count();
                                    }
                                @endphp

                                <tr>
                                    <td rowspan="{{ $rowspan }}" class="text-nowrap">{{ $i }}</td>
                                    <td rowspan="{{ $rowspan }}">{{ $participant->kompetisi->nama_kompetisi }}</td>
                                    <td rowspan="{{ $rowspan }}">{{ $participant->nama_skema }}</td>
                                    <td rowspan="{{ $rowspan }}">{{ $participant->judul }}</td>
                                    <td rowspan="{{ $rowspan }}">
                                        {{ $participant->nama_dosen_pembimbing }}<br>({{ $participant->nip_dosen_pembimbing }})
                                    </td>
                                    <td rowspan="{{ $rowspan }}">
                                        {{ $member_ketua->nama_mahasiswa }}<br>({{ $member_ketua->nim }})
                                    </td>
                                    <td rowspan="{{ $rowspan }}">
                                        {{ $member_ketua->prodi_mahasiswa ? $member_ketua->prodi_mahasiswa->nama_prodi : $member_ketua->prodi }}
                                    </td>
                                    <td rowspan="{{ $rowspan }}">
                                        <ul>

                                            @foreach ($member_anggota as $anggota)
                                                <li>{{ $anggota->nama_mahasiswa }}<br>({{ $anggota->nim }})</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td rowspan="{{ $rowspan }}"><a target="_blank"
                                            href="{{ asset($participant->file_upload) }}" class="btn btn-success"><i
                                                data-feather="file"></i></a></td>
                                    <td rowspan="{{ $rowspan }}">
                                        {{ $participant->nama_dosen_penilai }}<br>({{ $participant->nip_dosen_penilai }})
                                    </td>
                                    {{-- not tested --}}
                                    @if ($participant->review->count() > 0)
                                        @foreach ($participant->review as $index => $item)
                                            @if ($index > 0)
                                <tr>
                            @endif
                            <td>({{ $index + 1 }}) {{ $item->teks_review }}</td>
                            <td>{{ $item->skor_review }}</td>
                            </tr>
                            @if ($index == $participant->review->count())
                            @endif
                            @endforeach
                        @else
                            <td class="font-italic" rowspan="{{ $rowspan }}">belum ploting review & dosen penilai</td>
                            <td class="font-italic" rowspan="{{ $rowspan }}">belum ploting review & dosen penilai</td>
                            </tr>
                            @endif
                            @php
                                $i++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">
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
