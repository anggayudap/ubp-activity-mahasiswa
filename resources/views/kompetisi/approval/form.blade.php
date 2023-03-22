@extends('layouts.master')

@section('title', 'Form Approval Kompetisi')

@section('content')
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">Data Registrasi Kompetisi</h4>
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
                                        <p>File lampiran yang di upload menggunakan format arsip ZIP. Klik button dibawah
                                            untuk mendownload file arsip.</p>
                                        <br>
                                        <a href="{{ URL::asset($output->file_upload) }}" class="btn btn-primary"><i
                                                data-feather="download" class="mr-50"></i>Download Arsip</a>
                                    @endif
                                </div>
                            </div>

                            <form id="form" action="{{ route('kompetisi.submit_approval') }}" method="post"
                                class="form form-horizontal" enctype="multipart/form-data" novalidate>
                                @csrf
                                <input type="hidden" name="participant_id" value="{{ $output->id }}">
                                <h4 class="card-title">Plotting Dosen Penilai dan Review</h4>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Dosen Penilai</label>
                                    </div>
                                    <div class="col-sm-9 d-flex align-items-center">
                                        <select class="select2-data-dosen form-control" name="dosen_penilai"
                                            id="select2-ajax">
                                            @foreach ($additional['dosen'] as $id => $item)
                                                <option value="{{ $item['id'] }}">{{ $item['text'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Skema Terpilih</label>
                                    </div>
                                    <div class="col-sm-9 d-flex align-items-center">
                                        <p class="card-text">{{ $output->nama_skema }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Daftar Review</label>
                                    </div>
                                    <div class="col-sm-9 d-flex align-items-center">
                                        @if ($additional['review'])
                                            <ol class="list-group list-group-flush">
                                                @foreach ($additional['review'] as $id => $item)
                                                    <li class="list-group-item">{{ ++$id }}&#41;. {{ $item->review->teks_review }}</li>   
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-danger">Maaf, belum ada daftar review yang ditambahkan pada skema berikut : {{ $output->nama_skema }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-form-label">
                                        <em>Note : untuk mengelola data daftar review silahkan akses menu <a target="_blank"
                                                href="{{ route('master.skema.index') }}">Master Skema</a></em>
                                    </div>
                                </div>

                                <div class="col-sm-6 offset-sm-3">
                                    <button type="submit" {{ !$additional['review'] ? 'disabled' : '' }}
                                        class="btn btn-success waves-effect waves-float waves-light"
                                        onclick="approveConfirm();">
                                        <i data-feather="check" class="mr-25"></i>Approve</button>
                                    <button type="submit" {{ !$additional['review'] ? 'disabled' : '' }}
                                        name="approval_   reject" value="reject"
                                        class="btn btn-danger waves-effect waves-float waves-light"
                                        onclick="rejectConfirm();">
                                        <i data-feather="x" class="mr-25"></i>Reject</button>
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
@endpush

@push('scripts')
    <script src="{{ URL::asset('js/form.js') }}"></script>

    <script>
        let selectDosen = $('.select2-data-dosen');
        const dataDosen = @json($additional['dosen']);

        $(document).ready(function() {
            const basicPickr = $('.flatpickr-basic');
            if (basicPickr.length) {
                basicPickr.flatpickr({
                    allowInput: true,
                });
            }

            // init select2
            selectDosen.select2({
                width: '100%',
                // data: dataDosen,
                placeholder: 'Cari nama dosen penilai',
                minimumInputLength: 2,
            });

            // init bs-multiselect
            $('select#review').multiselect({
                nonSelectedText: 'Pilih satu atau lebih',
                buttonTextAlignment: 'left',
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                includeSelectAllOption: true,
                buttonWidth: '100%'
            });

        });

        function approveConfirm() {
            document.querySelector("#form").addEventListener("submit", function(event) {
                event.preventDefault();
                Swal.fire({
                    width: 680,
                    title: 'Anda yakin approve kompetisi ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.value) {
                        // add input hidden using js
                        var hiddenInput = document.createElement("input");
                        hiddenInput.setAttribute("type", "hidden");
                        hiddenInput.setAttribute("name", "approval");
                        hiddenInput.setAttribute("value", "approve");
                        this.appendChild(hiddenInput);

                        this.submit();
                    }
                });
            });
        }

        function rejectConfirm() {
            document.querySelector("#form").addEventListener("submit", function(event) {
                event.preventDefault();
                Swal.fire({
                    width: 680,
                    title: 'Anda yakin reject kompetisi ini?',
                    text: 'Silahkan input note reject',
                    input: 'text',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                }).then((result) => {
                    if (result.value) {
                        // add input hidden using js
                        var hiddenInput = document.createElement("input");
                        hiddenInput.setAttribute("type", "hidden");
                        hiddenInput.setAttribute("name", "approval");
                        hiddenInput.setAttribute("value", "reject");
                        this.appendChild(hiddenInput);

                        var hiddenInputNote = document.createElement("input");
                        hiddenInputNote.setAttribute("type", "hidden");
                        hiddenInputNote.setAttribute("name", "note");
                        hiddenInputNote.setAttribute("value", result.value);
                        this.appendChild(hiddenInputNote);

                        this.submit();
                    }
                });
            });
        }
    </script>
@endpush
