@extends('layouts.master')

@section('title', 'Detail & Tracking Kompetisi')

@section('content')
    <div class="content-body">
        <div class="blog-detail-wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Detail Kompetisi</h4>
                        </div>
                        <div class="card-body">
                            <div class="row pb-2">
                                <div class="col-md-8 col-12">
                                    <h5 class="mb-75">Nama Kompetisi</h5>
                                    <p class="card-text">
                                        {{ $data['kompetisi']->nama_kompetisi }}
                                    </p>
                                    <h5 class="mb-75">Deskripsi Kompetisi</h5>
                                    <p class="card-text">
                                        {!! $data['kompetisi']->deskripsi_kompetisi !!}
                                    </p>
                                    <h5 class="mb-75">Tanggal Posting</h5>
                                    <p class="card-text">
                                        {{ get_indo_date($data['kompetisi']->created_at) }}
                                    </p>
                                    <h5 class="mb-75">Diposting Oleh</h5>
                                    <p class="card-text">
                                        {{ $data['kompetisi']->user_name_created }}
                                    </p>
                                </div>
                                <div class="col-md-4 col-12">
                                    <h5 class="mb-75">Tanggal Mulai Pendaftaran</h5>
                                    <p class="card-text">
                                        {{ get_indo_date($data['kompetisi']->tanggal_mulai_pendaftaran) }}
                                    </p>
                                    <h5 class="mb-75">Tanggal Akhir Pendaftaran</h5>
                                    <p class="card-text">
                                        {{ get_indo_date($data['kompetisi']->tanggal_akhir_pendaftaran) }}
                                    </p>
                                    <h5 class="mb-75">Daftar Skema</h5>
                                    <ul>
                                        @foreach ($data['kompetisi']->skema as $skema)
                                            <li>
                                                <p class="card-text">{{ $skema->nama_skema }}</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <h5 class="mb-75">Daftar Prodi</h5>

                                    <ul>
                                        @foreach ($data['prodi'] as $prodi)
                                            <li>
                                                <p class="card-text">{{ $prodi->nama_prodi }}</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Tracking Kompetisi</h4>
                        </div>
                        <div class="card-body">
                            <section id="ajax-datatable">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">

                                            <div class="card-datatable">
                                                <table class="datatables-ajax table dataTable" id="DataTables_Table_0">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Tanggal') }}</th>
                                                            <th>{{ __('Nama Kompetisi') }}</th>
                                                            <th>{{ __('Skema Kompetisi') }}</th>
                                                            <th>{{ __('Dosen Pembimbing') }}</th>
                                                            <th>{{ __('Nama Ketua') }}</th>
                                                            <th>{{ __('Prodi Ketua') }}</th>
                                                            <th>{{ __('Jumlah Anggota') }}</th>
                                                            <th>{{ __('Status') }}</th>
                                                            <th>{{ __('Aksi') }}</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade text-left" id="xlarge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Detail History Kompetisi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="detail-kompetisi-participant">
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop


@push('styles')
    <link rel="stylesheet" href="{{ URL::asset('css/table.css') }}">
@endpush

@push('scripts')
    <script src="{{ URL::asset('js/table.js') }}"></script>
    <script src="{{ URL::asset('js/app.js') }}"></script>

    <script type="text/javascript">
        // kalau pake yajra
        let table = $('.datatables-ajax').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('kompetisi.tracking', $data['kompetisi']->id) }}",
            columns: [{
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'kompetisi.nama_kompetisi',
                    name: 'kompetisi.nama_kompetisi'
                },
                {
                    data: 'nama_skema',
                    name: 'nama_skema'
                },
                {
                    data: 'nama_dosen_pembimbing',
                    name: 'nama_dosen_pembimbing'
                },
                {
                    data: 'nama_ketua',
                    name: 'nama_ketua'
                },
                {
                    data: 'prodi_ketua',
                    name: 'prodi_ketua'
                },
                {
                    data: 'jumlah_anggota',
                    name: 'jumlah_anggota'
                },
                {
                    data: 'status',
                    name: 'status'
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

        function detail(id) {
            // $('#detail-kompetisi-participant').remove();
            $('#detail-kompetisi-participant').load(base_url + '/kompetisi/participant/modal_detail/' + id);
        }
    </script>
@endpush
