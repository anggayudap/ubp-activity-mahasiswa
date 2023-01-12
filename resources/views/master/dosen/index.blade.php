@extends('layouts.master')

@section('title', 'Master Data Dosen')
@section('menu-title', 'Kelola Data Dosen')


@section('content')
    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">@yield('menu-title')</h4>
                    </div>
                    <div class="card-datatable">
                        <table class="datatables-ajax table dataTable" id="DataTables_Table_0">
                            <thead>
                                <tr>
                                    <th>{{ __('NIP') }}</th>
                                    <th>{{ __('NIDN') }}</th>
                                    <th>{{ __('Nama Dosen') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Kode Prodi') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@push('styles')
    {{-- write css script here --}}
    <link rel="stylesheet" href="{{ URL::asset('css/table.css') }}">
@endpush

@push('scripts')
    {{-- write js script here --}}
    <script src="{{ URL::asset('js/table.js') }}"></script>
    <script type="text/javascript">
        // kalau pake yajra
        var table = $('.datatables-ajax').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('master.dosen.index') }}",
            columns: [{
                    data: 'nip',
                    name: 'nip'
                },
                {
                    data: 'nidn',
                    name: 'nidn'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'prodi',
                    name: 'prodi'
                },
            ],
            buttons: [{
                text: 'Update data',
                className: 'btn btn-success btn-add-record ml-2',
                action: function(e, dt, button, config) {
                    window.location = "{{ route('master.dosen.update_dosen') }}";
                }
            }],
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
    </script>
@endpush
