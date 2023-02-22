@extends('layouts.master')

@section('title', 'Form Registrasi Kompetisi : ' . $data->nama_kompetisi)

@section('content')
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <form action="{{ route('kompetisi.register_submit') }}" method="post" class="form form-horizontal "
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        @if ($additional['is_update'])
                            {{-- @method('PUT') --}}
                            @php
                                $data_participant = $data->participant->first();
                                
                                $nim_ketua_old = null;
                                $nim_anggota_old = [];
                                foreach ($data_participant->member as $key => $value) {
                                    if ($value['status_keanggotaan'] == 'anggota') {
                                        $nim_anggota_old[] = $value->nim;
                                    } else {
                                        $nim_ketua_old = $value->nim;
                                    }
                                }
                                
                            @endphp
                        @endif

                        <input type="hidden" name="method" value="{{ $additional['is_update'] ? 'update' : 'create' }}">
                        <input type="hidden" name="kompetisi_id"
                            value="{{ isset($data) ? $data->id : $additional['kompetisi']->id }}" />
                        <input type="hidden" name="participant_id"
                            value="{{ $additional['is_update'] ? $data_participant->id : null }}" />

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Judul</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="judul" class="form-control" name="judul"
                                            placeholder="Masukan judul"
                                            value="{{ $additional['is_update'] ? $data_participant->judul : old('judul') }}"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Tahun</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <select name="tahun" id="tahun" class="form-control" required>
                                            <option value="">Pilih tahun</option>
                                            @for ($i = 2022; $i <= date('Y'); $i++)
                                                <option value="{{ $i }}"
                                                    {{ $additional['is_update'] && $data_participant->tahun == $i ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Skema Kompetisi</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="skema" id="skema" class="form-control" required>
                                            <option value="">Pilih skema kompetisi</option>
                                            @foreach ($data->skema as $data_skema)
                                                <option value="{{ $data_skema->nama_skema }}"
                                                    {{ $additional['is_update'] && $data_participant->nama_skema == $data_skema->nama_skema ? 'selected' : '' }}>
                                                    {{ $data_skema->nama_skema }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Dosen Pembimbing</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="old_dosen_pembimbing"
                                            value="{{ $additional['is_update'] ? $data_participant->id_dosen_pembimbing : '' }}"
                                            disabled>
                                        <select class="select2-data-dosen form-control" name="dosen_pembimbing"
                                            id="dosen-pembimbing">
                                            <option value="">Pilih nama dosen</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Daftar Anggota</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Status</th>
                                                        <th>(NIM) Nama Mahasiswa</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Ketua</td>
                                                        <td>
                                                            <input type="hidden" name="old_nim_ketua"
                                                                value="{{ $additional['is_update'] ? $nim_ketua_old : '' }}"
                                                                disabled>
                                                            <select class="form-control" name="ketua" id="ketua">
                                                                <option value="">Silahkan input NIM atau Nama
                                                                    Mahasiswa</option>"
                                                            </select>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr id="member-1">
                                                        <td>Anggota</td>
                                                        <td>
                                                            <input type="hidden" name="old_nim_anggota_1"
                                                                value="{{ $additional['is_update'] && isset($nim_anggota_old[0]) ? $nim_anggota_old[0] : '' }}"
                                                                disabled>
                                                            <select class="select2-data-ajax form-control" id="anggota-1"
                                                                name="anggota[1]" id="anggota-satu">
                                                                <option value="">Silahkan input NIM atau Nama
                                                                    Mahasiswa</option>"
                                                            </select>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr id="member-2">
                                                        <td>Anggota</td>
                                                        <td>
                                                            <input type="hidden" name="old_nim_anggota_2"
                                                                value="{{ $additional['is_update'] && isset($nim_anggota_old[1]) ? $nim_anggota_old[1] : '' }}"
                                                                disabled>
                                                            <select class="select2-data-ajax form-control" id="anggota-2"
                                                                name="anggota[2]" id="anggota-dua">
                                                                <option value="">Silahkan input NIM atau Nama
                                                                    Mahasiswa</option>"
                                                            </select>
                                                        </td>
                                                        <td><button type="button" class="btn-danger btn-sm"
                                                                onclick="javascript:delete_anggota('2')"><i
                                                                    data-feather='trash-2'></i></button></td>
                                                    </tr>
                                                    <tr id="member-3">
                                                        <td>Anggota</td>
                                                        <td>
                                                            <input type="hidden" name="old_nim_anggota_3"
                                                                value="{{ $additional['is_update'] && isset($nim_anggota_old[2]) ? $nim_anggota_old[2] : '' }}"
                                                                disabled>
                                                            <select class="select2-data-ajax form-control" id="anggota-3"
                                                                name="anggota[3]" id="anggota-tiga">
                                                                <option value="">Silahkan input NIM atau Nama
                                                                    Mahasiswa</option>"
                                                            </select>
                                                        </td>
                                                        <td><button type="button" class="btn-danger btn-sm"
                                                                onclick="javascript:delete_anggota('3')"><i
                                                                    data-feather='trash-2'></i></button></td>
                                                    </tr>
                                                    <tr id="member-4">
                                                        <td>Anggota</td>
                                                        <td>
                                                            <input type="hidden" name="old_nim_anggota_4"
                                                                value="{{ $additional['is_update'] && isset($nim_anggota_old[3]) ? $nim_anggota_old[3] : '' }}"
                                                                disabled>
                                                            <select class="select2-data-ajax form-control" id="anggota-4"
                                                                name="anggota[4]" id="anggota-empat">
                                                                <option value="">Silahkan input NIM atau Nama
                                                                    Mahasiswa</option>"
                                                            </select>
                                                        </td>
                                                        <td><button type="button" class="btn-danger btn-sm"
                                                                onclick="javascript:delete_anggota('4')"><i
                                                                    data-feather='trash-2'></i></button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>File Upload</label>
                                    </div>
                                    <div class="col-sm-9">

                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file-kompetisi"
                                                name="file_kompetisi" accept="application/pdf,.zip" />
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group row">
                                    <em>Ket : Upload file menggunakan format <b>pdf</b> atau <b>zip</b>. Maks. size
                                        5mb.</em>
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
        let selectKetua = $('select#ketua');
        let selectAnggota = $('.select2-data-ajax');
        let selectDosen = $('.select2-data-dosen');
        const dataMahasiswa = @json($additional['mahasiswa']);
        const dataDosen = @json($additional['dosen']);
        const nimKetua = @json(session('user.id'));
        const isUpdate = @json($additional['is_update']);

        const oldDosenPembimbing = $('input[name="old_dosen_pembimbing"]').val();
        const oldNimKetua = $('input[name="old_nim_ketua"]').val();
        const oldNimAnggota1 = $('input[name="old_nim_anggota_1"]').val();
        const oldNimAnggota2 = $('input[name="old_nim_anggota_2"]').val();
        const oldNimAnggota3 = $('input[name="old_nim_anggota_3"]').val();
        const oldNimAnggota4 = $('input[name="old_nim_anggota_4"]').val();


        $(document).ready(function() {
            const basicPickr = $('.flatpickr-basic');
            if (basicPickr.length) {
                basicPickr.flatpickr({
                    allowInput: true,
                });
            }

            // init select 2 anggota mahasiswa
            selectKetua.select2({
                width: '100%',
                data: dataMahasiswa,
                placeholder: 'Cari npm mahasiswa',
                minimumInputLength: 5,
            });


            selectAnggota.select2({
                width: '100%',
                data: dataMahasiswa,
                placeholder: 'Cari npm atau nama mahasiswa',
                minimumInputLength: 5,
            });

            selectDosen.select2({
                width: '100%',
                data: dataDosen,
                placeholder: 'Cari nama dosen pembimbing',
                minimumInputLength: 2,
            });

            if (isUpdate) {
                // jika method update
                // if (oldDosenPembimbing.length) {
                selectDosen.val(oldDosenPembimbing).trigger('change');
                // }
                selectKetua.val(oldNimKetua).trigger('change');
                $('select#anggota-1').val(oldNimAnggota1).trigger('change');
                $('select#anggota-2').val(oldNimAnggota2).trigger('change');
                $('select#anggota-3').val(oldNimAnggota3).trigger('change');
                $('select#anggota-4').val(oldNimAnggota4).trigger('change');
            } else {
                // jika method create
                selectKetua.val(nimKetua).trigger('change');
                selectKetua.attr('readonly', true);
            }

        });

        function delete_anggota(id) {
            $('#member-' + id).remove();
        }
    </script>
@endpush
