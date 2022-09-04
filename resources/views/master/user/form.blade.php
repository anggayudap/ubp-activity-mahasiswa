@extends('layouts.master')

@section('title', 'Form Data User')
@section('menu-title', 'Master Data User User')


@section('content')
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ isset($data['user']) ? 'Edit' : 'Tambah' }} Data User</h4>
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($data['user']) ? route('master.user.update', $data['user']->id) : route('master.user.store') }}"
                        method="post" class="form form-horizontal need-validation" novalidate>
                        @csrf
                        @if (isset($data['user']))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">{{ __('Nama User') }}</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="name" class="form-control" name="name"
                                            {{ isset($data['user']) ? 'disabled' : '' }}
                                            value="{{ isset($data['user']) ? $data['user']->name : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="name">{{ __('Email') }}</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="email" class="form-control" name="email"
                                            {{ isset($data['user']) ? 'disabled' : '' }}
                                            value="{{ isset($data['user']) ? $data['user']->email : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label for="code">{{ __('Role User') }}</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="role" id="role">
                                            @foreach ($data['role'] as $item)
                                                <option {{ $data['user']->role == $item->name ? 'selected' : '' }}
                                                    value="{{ $item->name }}">{{ $item->description }}</option>
                                            @endforeach
                                            <option></option>
                                        </select>
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
