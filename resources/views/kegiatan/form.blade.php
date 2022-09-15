@extends('layouts.master')
@if (isset($data['kegiatan']))
    @section('title', 'Form Edit Kegiatan Mahasiswa')
@else
    @section('title', 'Form Tambah Kegiatan Mahasiswa')
@endif
{{-- @section('menu-title', 'Master Data Departemen') --}}


@section('content')
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <form action="{{ isset($data['kegiatan']) ? route('kegiatan.update', $data->id) : route('kegiatan.store') }}"
                        method="post" class="form form-horizontal " enctype="multipart/form-data" novalidate>
                        @csrf
                        @if (isset($data['kegiatan']))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Periode</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="periode_id" id="periode-id" required>
                                            <option value="">Pilih Periode</option>
                                                    @foreach ($data['periode'] as $value)
                                                        <option value="{{ $value->id }}">{{ $value->periode_awal . ' - ' . $value->periode_akhir }}
                                                        </option>
                                                    @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12"><hr></div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Nama Kegiatan</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="nama-kegiatan" class="form-control" name="nama_kegiatan"
                                            placeholder="Nama Kegiatan"
                                            value="{{ isset($data['kegiatan']) ? $data->nama_kegiatan : old('nama_kegiatan') }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Tanggal Mulai Kegiatan</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="tanggal-mulai" class="form-control flatpickr-basic"
                                            name="tanggal_mulai" placeholder="Tanggal Mulai Kegiatan"
                                            value="{{ isset($data['kegiatan']) ? $data->tanggal_mulai : old('tanggal_mulai') }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Tanggal Akhir Kegiatan</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="tanggal-akhir" class="form-control flatpickr-basic"
                                            name="tanggal_akhir" placeholder="Tanggal Akhir Kegiatan"
                                            value="{{ isset($data['kegiatan']) ? $data->tanggal_akhir : old('tanggal_akhir') }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Klasifikasi Kegiatan</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="klasifikasi_id" id="klasifikasi-id" required>
                                            <option value="">Pilih Klasifikasi</option>
                                            @foreach ($data['klasifikasi'] as $group => $item)
                                                <optgroup label="{{ $group }}">
                                                    @foreach ($data['klasifikasi'][$group] as $value)
                                                        <option value="{{ $value->id }}">{{ $value->name_kegiatan }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">URL/Link Pendaftaran</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <textarea type="text" id="url-event" class="form-control " name="url_event"
                                            placeholder="URL/Link Pendaftaran" required>{{ isset($data['kegiatan']) ? $data->tanggal_akhir : old('tanggal_akhir') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Keterangan</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <textarea id="keterangan" class="form-control " name="keterangan" required>
                                            {{ isset($data) ? $data->keterangan : old('keterangan') }}
                                            </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Surat Tugas</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <img id="surat-tugas-preview" class="img-fluid my-1 col-sm-5">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file-surat-tugas"
                                                name="surat_tugas" onchange="javascript:previewImage('surat-tugas')"
                                                accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" />
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Foto Kegiatan</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <img id="foto-kegiatan-preview" class="img-fluid my-1 col-sm-5">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file-foto-kegiatan"
                                                name="foto_kegiatan" onchange="javascript:previewImage('foto-kegiatan')"
                                                accept="image/jpeg,image/gif,image/png,image/x-eps" />
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">Bukti Kegiatan (sertifikat, dll)</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <img id="bukti-kegiatan-preview" class="img-fluid my-1 col-sm-5">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file-bukti-sertifikat"
                                                name="bukti_sertifikat" />
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <em>Ket : Upload file menggunakan format gambar / pdf. Maks. size 5mb.</em>
                                </div>
                            </div>



                            <div class="col-sm-9 offset-sm-3">
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
        $(document).ready(function() {
            const basicPickr = $('.flatpickr-basic');
            if (basicPickr.length) {
                basicPickr.flatpickr();
            }
            // console.log('nice');
        });

        function previewImage(type = null) {
            const image = document.querySelector('#file-' + type);
            const imgPreview = document.querySelector('#' + type + '-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            if (image.files[0].type.match('image.*')) {
                oFReader.onload = function(oFREvent) {
                    imgPreview.src = oFREvent.target.result;
                }
            }

        }
    </script>
@endpush
