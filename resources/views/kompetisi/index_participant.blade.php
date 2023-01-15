@extends('layouts.master')

@section('title', $data['heading'])


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
                                    <th>{{ __('Nama Kompetisi') }}</th>
                                    <th>{{ __('Skema Kompetisi') }}</th>
                                    <th>{{ __('Dosen Pembimbing') }}</th>
                                    <th>{{ __('Nama Ketua') }}</th>
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
            // $('#detail-kompetisi-participant').remove();
            $('#detail-kompetisi-participant').load(base_url + '/kompetisi/participant/modal_detail/' + id);
        }
    </script>
@endpush
