@extends('layouts.master')

@section('title', 'Proposal Kegiatan')


@section('content')
    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">{{ $data['heading'] }}</h4>
                    </div>
                    <div class="card-datatable">
                        <table class="datatables-ajax table dataTable" id="DataTables_Table_0">
                            <thead>
                                <tr>
                                    <th>{{ __('Tanggal') }}</th>
                                    <th>{{ __('Judul Proposal') }}</th>
                                    <th>{{ __('Nama Mahasiswa') }}</th>
                                    <th>{{ __('Prodi') }}</th>
                                    <th>{{ __('Ketua Pelaksana') }}</th>
                                    <th>{{ __('Status Approval') }}</th>
                                    <th>{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade text-left" id="xlarge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel16">Detail Proposal Kegiatan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detail-proposal">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="xlarge-upload-laporan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel16">Upload Laporan Proposal Kegiatan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="upload-laporan-proposal">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="approval-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel16">Approval Proposal Kegiatan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="approval-proposal">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success waves-effect waves-float waves-light"
                        onclick="approveConfirm('{{ isset($data['approval']) ? $data['approval'] : '' }}');">
                        <i data-feather="check" class="mr-25"></i>Approve Proposal</button>
                    <button type="button" class="btn btn-danger waves-effect waves-float waves-light"
                        onclick="rejectConfirm('{{ isset($data['approval']) ? $data['approval'] : '' }}');">
                        <i data-feather="x" class="mr-25"></i>Reject Proposal</button>
                </div>
            </div>
        </div>
    </div>
@stop

@push('styles')
    <link rel="stylesheet" href="{{ URL::asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/form.css') }}">
@endpush

@push('scripts')
    {{-- write js script here --}}
    <script src="{{ URL::asset('js/table.js') }}"></script>
    <script src="{{ URL::asset('js/app.js') }}"></script>
    <script src="{{ URL::asset('js/form.js') }}"></script>

    <script type="text/javascript">
        // kalau pake yajra
        let table = $('.datatables-ajax').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route($data['datasource']) }}",
            columns: [{
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'judul_proposal',
                    name: 'judul_proposal'
                },
                {
                    data: 'nama_mahasiswa',
                    name: 'nama_mahasiswa'
                },
                {
                    data: 'prodi_mahasiswa.nama_prodi',
                    name: 'prodi_mahasiswa.nama_prodi'
                },
                {
                    data: 'ketua_pelaksana',
                    name: 'ketua_pelaksana'
                },
                {
                    data: 'next_approval',
                    name: 'next_approval'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            buttons: [],
            dom: '<"row d-flex justify-content-between align-items-center m-1"' +
                '<"col-lg-6 d-flex align-items-center"l<"dt-action-buttons text-xl-right text-lg-left text-lg-right text-left "B>>' +
                '<"col-lg-6 d-flex align-items-center justify-content-lg-end flex-lg-nowrap flex-wrap pr-lg-1 p-0"f<"invoice_status ml-sm-2">>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            drawCallback: function(settings) {
                feather.replace()
            }

        });

        function submit_delete(user_id) {
            event.preventDefault();
            Swal.fire({
                width: 680,
                title: 'Anda yakin ingin menghapus data terpilih?',
                text: "Data yang sudah di hapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value == true) {
                    $(`#form-delete-${user_id}`).submit();
                } else {
                    return false;
                }
            });
        }

        function detail(id) {
            // $('#detail-proposal').remove();
            $('#detail-proposal').load(base_url + '/proposal/modal_detail/' + id);
        }

        function upload_laporan(id) {
            // $('#upload-laporan-proposal').remove();
            $('#upload-laporan-proposal').load(base_url + '/proposal/upload_laporan/' + id);
        }

        function approval(id) {
            // $('#approval-proposal').remove();
            $('#approval-proposal').load(base_url + '/proposal/approval/' + id);
        }

        // function uploadLaporan() {
        //     event.preventDefault();
        //     Swal.fire({
        //         width: 680,
        //         title: 'Konfirmasi upload file laporan proposal?',
        //         // text: "Data yang sudah di hapus tidak bisa dikembalikan!",
        //         icon: 'question',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Ya',
        //         cancelButtonText: 'Tidak'
        //     }).then((result) => {
        //         const json_param = formConverter($('form').serializeArray());

        //         // $.ajaxSetup({
        //         //     headers: {
        //         //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         //     }
        //         // });
        //         // $.ajax({
        //         //     url: "{{ route('proposal.submit_approval') }}",
        //         //     method: 'POST',
        //         //     data: {
        //         //         data: json_param,
        //         //         type: 'approve',
        //         //         approval : approval,
        //         //     },
        //         //     success: function(data) {
        //         //         if (data.success) {
        //         //             successMessage(data.message, data.redirect);
        //         //         } else {
        //         //             errorMessage(data.message);
        //         //         }
        //         //     }
        //         // });
        //         console.log(json_param);
        //     });
        // }

        function approveConfirm(approval) {
            event.preventDefault();
            Swal.fire({
                width: 680,
                title: 'Anda yakin approve proposal ini?',
                // text: "Data yang sudah di hapus tidak bisa dikembalikan!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                const json_param = formConverter($('form').serializeArray());

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('proposal.submit_approval') }}",
                    method: 'POST',
                    data: {
                        data: json_param,
                        type: 'approve',
                        approval : approval,
                    },
                    success: function(data) {
                        if (data.success) {
                            successMessage(data.message, data.redirect);
                        } else {
                            errorMessage(data.message);
                        }
                    }
                });
            });
        }

        function rejectConfirm(approval) {
            event.preventDefault();

            $('#approval-modal').modal('hide');

            Swal.fire({
                width: 680,
                title: 'Anda yakin reject proposal ini?',
                text: 'Silahkan input note reject',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Ya',


            }).then((result) => {
                const json_param = formConverter($('form').serializeArray());

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('proposal.submit_approval') }}",
                    method: 'POST',
                    data: {
                        data: json_param,
                        type: 'reject',
                        approval : approval,
                        note: result.value,
                    },
                    success: function(data) {
                        if (data.success) {
                            successMessage(data.message, data.redirect);
                        } else {
                            errorMessage(data.message);
                        }
                    }
                });
            });

        }

        function formConverter(form) {
            const json = {};
            $.each(form, function() {
                json[this.name] = this.value || "";
            });

            return json;
        }
    </script>
@endpush
