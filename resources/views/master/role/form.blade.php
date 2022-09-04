@extends('layouts.master')

@section('title', 'Form Data Role')
@section('menu-title', 'Master Data Role User')


@section('content')
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ isset($data) ? 'Edit' : 'Tambah' }} Data Role</h4>
                </div>
                <div class="card-body">
                    <form action="{{ isset($data) ? route('master.role.update', $data->id) : route('master.role.store') }}"
                        method="post" class="form form-horizontal need-validation" novalidate>
                        @csrf
                        @if (isset($data))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">{{ __('Nama Role') }}</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="name" class="form-control" name="name"
                                            {{ isset($data) ? 'readonly' : '' }}
                                            value="{{ isset($data) ? $data->name : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="code">{{ __('Deskripsi Role') }}</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="description" class="form-control" name="description"
                                            value="{{ isset($data) ? $data->description : '' }}">
                                    </div>
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
@endpush

@push('scripts')
@endpush
