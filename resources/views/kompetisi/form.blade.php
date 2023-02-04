@extends('layouts.master')
@if (isset($data['kompetisi']))
    @section('title', 'Buat Kompetisi')
@else
    @section('title', 'Form Buat Kompetisi')
@endif
{{-- @section('menu-title', 'Master Data Departemen') --}}


@section('content')
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($data['kompetisi']) ? route('kompetisi.update', $data['kompetisi']->id) : route('kompetisi.store') }}"
                        method="post" class="form form-horizontal " enctype="multipart/form-data" novalidate>
                        @csrf
                        @if (isset($data['kompetisi']))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Nama Kompetisi</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="nama-kompetisi" class="form-control" name="nama_kompetisi"
                                            placeholder="Nama Kompetisi"
                                            value="{{ isset($data['kompetisi']) ? $data['kompetisi']->nama_kompetisi : old('nama_kompetisi') }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Deskripsi Kompetisi</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input name="deskripsi_kompetisi" type="hidden">
                                        <div id="snow-wrapper">
                                            <div id="snow-container">
                                                <div class="quill-toolbar">
                                                    <span class="ql-formats">
                                                        <select class="ql-header">
                                                            <option value="1">Heading</option>
                                                            <option value="2">Subheading</option>
                                                            <option selected>Normal</option>
                                                        </select>
                                                        <select class="ql-font">
                                                            <option selected>Sailec Light</option>
                                                            <option value="sofia">Sofia Pro</option>
                                                            <option value="slabo">Slabo 27px</option>
                                                            <option value="roboto">Roboto Slab</option>
                                                            <option value="inconsolata">Inconsolata</option>
                                                            <option value="ubuntu">Ubuntu Mono</option>
                                                        </select>
                                                    </span>
                                                    <span class="ql-formats">
                                                        <button class="ql-bold"></button>
                                                        <button class="ql-italic"></button>
                                                        <button class="ql-underline"></button>
                                                    </span>
                                                    <span class="ql-formats">
                                                        <button class="ql-list" value="ordered"></button>
                                                        <button class="ql-list" value="bullet"></button>
                                                    </span>
                                                    <span class="ql-formats">
                                                        <button class="ql-link"></button>
                                                        <button class="ql-image"></button>
                                                        <button class="ql-video"></button>
                                                    </span>
                                                    <span class="ql-formats">
                                                        <button class="ql-formula"></button>
                                                        <button class="ql-code-block"></button>
                                                    </span>
                                                    <span class="ql-formats">
                                                        <button class="ql-clean"></button>
                                                    </span>
                                                </div>
                                                <div class="editor">
                                                    {!! $data['kompetisi']->deskripsi_kompetisi ?? old('deskripsi_kompetisi') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>List Prodi</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <select id="list-prodi" name="list_prodi[]" multiple data-live-search="true"
                                            class="form-control" required>
                                            @foreach ($data['prodi'] as $prodi)
                                                <option {{ (isset($data['selected_prodi'])) && in_array($prodi->id, $data['selected_prodi']) ? 'selected' : '' }} value="{{ $prodi->id }}">
                                                    {{ $prodi->nama_prodi }}</option>
                                            @endforeach
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
                                        <select id="skema" name="skema[]" multiple data-live-search="true"
                                            class="form-control" required>
                                            @foreach ($data['skema'] as $skema)
                                                <option
                                                    {{ isset($data['selected_skema']) && in_array($skema->id, $data['selected_skema']) ? 'selected' : '' }}
                                                    value="{{ $skema->id }}">{{ $skema->nama_skema }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Tanggal Mulai Pendaftaran</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" id="tanggal_mulai_pendaftaran"
                                            class="form-control flatpickr-basic" name="tanggal_mulai_pendaftaran"
                                            placeholder="Tanggal Mulai Pendaftaran"
                                            value="{{ isset($data['kompetisi']) ? $data['kompetisi']->tanggal_mulai_pendaftaran : old('tanggal_mulai_pendaftaran') }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Tanggal Akhir Pendaftaran</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" id="tanggal_akhir_pendaftaran"
                                            class="form-control flatpickr-basic" name="tanggal_akhir_pendaftaran"
                                            placeholder="Tanggal Akhir Pendaftaran"
                                            value="{{ isset($data['kompetisi']) ? $data['kompetisi']->tanggal_akhir_pendaftaran : old('tanggal_akhir_pendaftaran') }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Status</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <select name="aktif" id="aktif" class="form-control">
                                            <option value="1"
                                                {{ isset($data['kompetisi']) && $data['kompetisi']->aktif == 1 ? 'selected' : '' }}>
                                                Aktif</option>
                                            <option value="0"
                                                {{ isset($data['kompetisi']) && $data['kompetisi']->aktif == 0 ? 'selected' : '' }}>
                                                Tidak Aktif
                                            </option>
                                        </select>

                                    </div>
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
    <link rel="stylesheet" href="{{ URL::asset('css/text_editor.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css2?family=Inconsolata&amp;family=Roboto+Slab&amp;family=Slabo+27px&amp;family=Sofia&amp;family=Ubuntu+Mono&amp;display=swap">
@endpush

@push('scripts')
    <script src="{{ URL::asset('js/form.js') }}"></script>
    <script src="{{ URL::asset('js/text_editor.js') }}"></script>

    <script>
        let editor = '#snow-container .editor';

        $(document).ready(function() {
            const basicPickr = $('.flatpickr-basic');
            if (basicPickr.length) {
                basicPickr.flatpickr({
                    allowInput: true,
                });
            }
            // console.log('nice');
            $('select[multiple]').multiselect({
                nonSelectedText: 'Pilih satu atau lebih',
                buttonTextAlignment: 'left',
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                includeSelectAllOption: true,
                buttonWidth: '100%'
            });
            // clear multislect bs
            // $('#category option:selected').each(function() {
            //                 $(this).prop('selected', false);
            //             });
            //             $('#category').multiselect('refresh');

            // Quill : Snow Editor
            let Font = Quill.import('formats/font');
            Font.whitelist = ['sofia', 'slabo', 'roboto', 'inconsolata', 'ubuntu'];
            Quill.register(Font, true);

            let blogEditor = new Quill(editor, {
                bounds: editor,
                modules: {
                    formula: true,
                    syntax: true,
                    toolbar: '#snow-container .quill-toolbar'
                },
                theme: 'snow'
            });

            // move quilleditor to input
            let form = document.querySelector('form');
            form.onsubmit = function() {
                // Populate hidden form on submit
                let jobDesc = document.querySelector('input[name=deskripsi_kompetisi]');
                // jobDesc.value = JSON.stringify(blogEditor.getContents());
                jobDesc.value = blogEditor.root.innerHTML;

                return true;
            };

        });
    </script>
@endpush
