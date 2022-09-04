@extends('layouts.master')

@section('title', 'Master Data User')
@section('menu-title', 'Kelola Data User')


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
                                    <th>{{ __('Nama') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Role') }}</th>
                                    <th>{{ __('Login Terkahir') }}</th>
                                    <th>{{ __('Aksi') }}</th>
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
            ajax: "{{ route('master.user.index') }}",
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'last_login_at',
                    name: 'last_login_at'
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
    </script>
@endpush
