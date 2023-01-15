@extends('layouts.master')

@section('title', 'Form Penilaian Akhir Kompetisi')

@section('content')
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">Data Registrasi</h4>
                            <div class="form-group row">
                                <div class="col-sm-3 col-form-label">
                                    <label>Tanggal Registrasi</label>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <p class="card-text">{{ get_indo_date($output->created_at) }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 col-form-label">
                                    <label>Judul</label>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <p class="card-text">{{ $output->judul }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 col-form-label">
                                    <label>Tahun</label>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <p class="card-text">{{ $output->tahun }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 col-form-label">
                                    <label>Nama Dosen Pembimbing</label>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <p class="card-text">{{ $output->nama_dosen_pembimbing }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 col-form-label">
                                    <label>Nama Anggota</label>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <p class="card-text">
                                    <ul>
                                        @foreach ($output->member->sortByDesc('status_keanggotaan')->values()->all() as $anggota)
                                            <li>{{ $anggota->nim }} :: {{ $anggota->nama_mahasiswa }}
                                                {{ $anggota->status_keanggotaan == 'ketua' ? '(Ketua)' : '' }}</li>
                                        @endforeach
                                    </ul>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 col-form-label">
                                    <label>Nama Dosen Penilai</label>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <p class="card-text">{{ $output->nama_dosen_penilai }}</p>
                                </div>
                            </div>


                            <h4 class="card-title">Data Kompetisi</h4>
                            <div class="form-group row">
                                <div class="col-sm-3 col-form-label">
                                    <label>Nama Kompetisi</label>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <p class="card-text">{{ $output['kompetisi']->nama_kompetisi }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 col-form-label">
                                    <label>Skema Terpilih</label>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <p class="card-text">{{ $output->nama_skema }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 col-form-label">
                                    <label>Status</label>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <p class="card-text">{!! trans('serba.' . $output->status) !!}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 col-form-label">
                                    <label>Lampiran File</label>
                                </div>
                                <div class="col-sm-9 d-flex align-items-center">
                                    @if ($additional['is_pdf'])
                                        <object data="{{ URL::asset($output->file_upload) }}" type="application/pdf"
                                            frameborder="0" width="100%" height="600px" style="padding: 20px;">
                                            <p>Oops! Lampiran file dalam bentuk arsip zip!</p>
                                            <p><a href="{{ URL::asset($output->file_upload) }}">Download Instead</a>
                                            </p>
                                        </object>
                                    @else
                                    <p>File lampiran yang di upload menggunakan format arsip ZIP. Klik button dibawah untuk mendownload file arsip.</p>
                                    <a href="{{ URL::asset($output->file_upload) }}" class="btn btn-primary"><i data-feather="download" class="mr-50"></i>Download Arsip</a>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3 col-form-label">
                                    <label>Review & Nilai</label>
                                </div>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Review</th>
                                                    <th>Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 0;
                                                @endphp
                                                @forelse ($output->review as $item)
                                                    <tr>
                                                        <td>{{ ++$i }}</td>
                                                        <td>{{ $item->teks_review }}</td>
                                                        <td>{{ $item->skor_review }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3">Tidak ada review yang diplotting.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>

                            <form id="form" action="{{ route('kompetisi.submit_result') }}" method="post"
                                class="form form-horizontal" enctype="multipart/form-data" novalidate>
                                @csrf
                                <input type="hidden" name="participant_id" value="{{ $output->id }}">
                                <h4 class="card-title">Input Penilaian Akhir</h4>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Penilaian Akhir</label>
                                    </div>
                                    <div class="col-sm-9 d-flex align-items-center">
                                        <select class="form-control" name="keputusan" id="keputusan" required>
                                            <option>Pilih</option>
                                            <option value="lolos">Lolos</option>
                                            <option value="tidak_lolos">Tidak Lolos</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Catatan</label>
                                    </div>
                                    <div class="col-sm-9 d-flex align-items-center">
                                        <input name="catatan" type="hidden">
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
                                                    {!! $output->catatan . '<br><br>' !!}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="col-sm-6 offset-sm-3">
                                    <button type="submit" class="btn btn-success waves-effect waves-float waves-light"
                                        onclick="submitConfirm();">
                                        <i data-feather="save" class="mr-25"></i>Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

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
                basicPickr.flatpickr();
            }

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
                let catatanEl = document.querySelector('input[name=catatan]');
                catatanEl.value = blogEditor.root.innerHTML;

                return true;
            };
        });

        function submitConfirm() {
            document.querySelector("#form").addEventListener("submit", function(event) {
                event.preventDefault();
                Swal.fire({
                    width: 680,
                    title: 'Submit penilaian akhir kompetisi ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.value) {
                        this.submit();
                    }
                });
            });
        }
    </script>
@endpush
