@extends('layouts.master')

@section('title', 'Detail Kompetisi')

@section('content')
    <div class="content-body">
        <div class="blog-detail-wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row pb-2">
                                <div class="col-md-7 col-12">
                                    <h2>{{ $data['kompetisi']->nama_kompetisi }}</h2>
                                    {!! $data['kompetisi']->deskripsi_kompetisi !!}
                                    
                                </div>

                                <div class="col-md-5 col-12 text-right">
                                    <div class="media">
                                        <div class="media-body">
                                            <span>Tanggal Pendaftaran</span>
                                            <span>{{ get_indo_date($data['kompetisi']->tanggal_mulai_pendaftaran) }} s/d
                                                {{ get_indo_date($data['kompetisi']->tanggal_akhir_pendaftaran) }}</span>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-body">
                                            <span>Diposting oleh</span>
                                            <span class="text-muted ml-50 mr-25">:</span>
                                            <span>{{ $data['kompetisi']->user_name_created }}</span>
                                        </div>
                                    </div>
                                    {{-- @if ($additional['prepost_vacancy']) --}}
                                    {{-- <button
                                        class="btn btn-block btn-secondary">Register</button> --}}
                                    {{-- @else
                                        @if ($vacancy['is_active'])
                                            <button class="btn btn-block btn-primary">Lowongan ini sedang tayang</button>
                                        @else
                                            <button class="btn btn-block btn-danger">Lowongan ini tidak aktif</button>
                                        @endif
                                    @endif --}}
                                </div>
                            </div>

                            <div class="row pb-2">
                                <div class="col-12">
                                    <h2>Skema Kompetisi</h2>
                                    <ul>
                                        @foreach ($data['kompetisi']->skema as $skema)
                                            <li>{{ $skema->nama_skema }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="row pb-2">
                                <div class="col-12">
                                    <h2>Daftar Program Studi</h2>
                                    <ul>
                                        @foreach ($data['prodi'] as $prodi)
                                            <li>{{ $prodi->nama_prodi }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="row pb-2">
                                <div class="col-12">
                                    @if ($data['has_registered'])
                                    <button type="button" class="btn btn-secondary btn-lg" disabled>Anda sudah melakukan Registrasi</button>
                                
                                    @else   
                                    <a type="button" class="btn btn-success btn-lg" href="{{ route('kompetisi.register_form', Crypt::encrypt($data['kompetisi']->id)) }}">REGISTRASI</a>
                                    @endif
                                </div>
                            </div>

                            

                            <div class="row pb-2">
                                <div class="col-12">

                                    {{-- <h2>Informasi Tambahan</h2>
                                    <div class="row col-12">
                                        <div class="col-12 col-md-6 mb-50">
                                            <h5>Tingkat Pekerjaan</h5>
                                            <span>{{ ucfirst($vacancy['level']) }}</span>
                                        </div>
                                        <div class="col-12 col-md-6 mb-50">
                                            <h5>Kualifikasi Pendidikan</h5>
                                            <span>{{ implode(', ', $additional['educationalfull_stage']) }}</span>
                                        </div>
                                        <div class="col-12 col-md-6 mb-50">
                                            <h5>Pengalaman Kerja (Min)</h5>
                                            <span>{{ $vacancy['experience_min'] }} tahun</span>
                                        </div>
                                        <div class="col-12 col-md-6 mb-50">
                                            <h5>Jenis Pekerjaan</h5>
                                            <span>{{ ucfirst($vacancy['type']) }}</span>
                                        </div>
                                        <div class="col-12 col-md-6 mb-50">
                                            <h5>Spesialisasi Pekerjaan</h5>
                                            <span>{{ $vacancy['specialization'] }}</span>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

@stop


@push('styles')
@endpush

@push('scripts')
    <script type="text/javascript">
        // $('.manual').on('click', function() {
        //     $(this).tooltip('show');
        // });
        // $('.manual').on('mouseout', function() {
        //     $(this).tooltip('hide');
        // });

        // $('img').addClass('img-fluid');
        // $('img').css({
        //     'max-width': '70%'
        // });

        // function copyLink(idRefferal) {
        //     let link = document.getElementById('link-' + idRefferal);

        //     if (window.isSecureContext && navigator.clipboard) {
        //         navigator.clipboard.writeText(link.value);
        //     } else {
        //         unsecuredCopyToClipboard(link.value);
        //     }
        // }

        // function unsecuredCopyToClipboard(text) {
        //     const textArea = document.createElement("textarea");
        //     textArea.value = text;
        //     document.body.appendChild(textArea);
        //     textArea.focus();
        //     textArea.select();
        //     try {
        //         document.execCommand('copy');
        //     } catch (err) {
        //         console.error('Unable to copy to clipboard', err);
        //     }
        //     document.body.removeChild(textArea);
        // }
    </script>
@endpush
