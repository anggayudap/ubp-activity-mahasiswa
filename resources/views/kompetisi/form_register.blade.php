@extends('layouts.master')

@section('title', 'Form Registrasi Kompetisi : ' . $data['kompetisi']->nama_kompetisi)

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
                        @if (isset($data['kompetisi_participant']))
                            @method('PUT')
                        @endif
                        <input type="hidden" name="kompetisi_id" value="{{ $data['kompetisi']->id }}" />
                        <input type="hidden" name="type"
                            value="{{ isset($data['kompetisi_participant']) ? 'update' : 'store' }}" />
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Judul</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="judul" class="form-control" name="judul"
                                            placeholder="Judul"
                                            value="{{ isset($data['kompetisi_participant']) ? $data['kompetisi_participant']->judul : old('judul') }}"
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
                                            @for ($i = 2022; $i <= date('Y'); $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
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
                                            @foreach ($data['kompetisi']->skema as $data_skema)
                                                <option value="{{ $data_skema->skema_id }}">{{ $data_skema->nama_skema }}</option>
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
                                        <select class="select2-data-dosen form-control"
                                                                name="dosen_pembimbing" id="select2-ajax"></select>
                                        {{-- <input type="text" id="dosen_pembimbing" class="form-control" name="dosen_pembimbing"
                                            placeholder="Dosen Pembimbing"
                                            value="{{ isset($data['kompetisi_participant']) ? $data['kompetisi_participant']->dosen_pembimbing : old('dosen_pembimbing') }}"
                                            required> --}}
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
                                                        <td><select class="form-control" name="ketua"
                                                                id="ketua"></select></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr id="member-1">
                                                        <td>Anggota</td>
                                                        <td><select class="select2-data-ajax form-control"
                                                                name="anggota[1]" id="select2-ajax"></select></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr id="member-2">
                                                        <td>Anggota</td>
                                                        <td><select class="select2-data-ajax form-control"
                                                                name="anggota[2]" id="select2-ajax"></select></td>
                                                        <td><button type="button" class="btn-danger btn-sm"
                                                                onclick="javascript:delete_anggota('2')"><i
                                                                    data-feather='trash-2'></i></button></td>
                                                    </tr>
                                                    <tr id="member-3">
                                                        <td>Anggota</td>
                                                        <td><select class="select2-data-ajax form-control"
                                                                name="anggota[3]" id="select2-ajax"></select></td>
                                                        <td><button type="button" class="btn-danger btn-sm"
                                                                onclick="javascript:delete_anggota('3')"><i
                                                                    data-feather='trash-2'></i></button></td>
                                                    </tr>
                                                    <tr id="member-4">
                                                        <td>Anggota</td>
                                                        <td><select class="select2-data-ajax form-control"
                                                                name="anggota[4]" id="select2-ajax"></select></td>
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
        const dataMahasiswa = @json($data['mahasiswa']);
        const dataDosen = @json($data['dosen']);
        const nimKetua = @json(session('user.id'));

        // console.log(nimKetua);

        $(document).ready(function() {
            const basicPickr = $('.flatpickr-basic');
            if (basicPickr.length) {
                basicPickr.flatpickr();
            }
            
            // init select 2 anggota mahasiswa
            selectKetua.select2({
                width: '100%',
                data: dataMahasiswa,
                placeholder: 'Search for a repository',
                minimumInputLength: 11,
            });
            selectKetua.val(nimKetua).trigger('change');
            selectKetua.attr('readonly', true);

            selectAnggota.select2({
                width: '100%',
                data: dataMahasiswa,
                placeholder: 'Cari data mahasiswa',
                minimumInputLength: 11,
            });

            selectDosen.select2({
                width: '100%',
                data: dataDosen,
                placeholder: 'cari data dosen pembimbing',
                minimumInputLength: 2,
            });



        });

        function delete_anggota(id) {
            $('#member-' + id).remove();
        }
    </script>
@endpush
