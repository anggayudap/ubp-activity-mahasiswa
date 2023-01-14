<div class="card-body">

    <div class="row invoice-spacing">
        <div class="col-md-4 col-12 p-0 mt-xl-0 mt-2">
            <h4>Data Registrasi</h4>
            {{-- {{ dd($output) }} --}}
            {{-- <input type="hidden" name="proposal_id" value="{{ $output['proposal']->id }}"> --}}
            <div class="mt-2">
                <h5 class="mb-75">Tanggal Registrasi:</h5>
                <p class="card-text">{{ get_indo_date($output->created_at) }}</p>
            </div>
            <div class="mt-2">
                <h5 class="mb-75">Judul:</h5>
                <p class="card-text">{{ $output->judul }}</p>
            </div>
            <div class="mt-2">
                <h5 class="mb-75">Tahun:</h5>
                <p class="card-text">{{ $output->tahun }}</p>
            </div>
            <div class="mt-2">
                <h5 class="mb-75">Nama Dosen Pembimbing:</h5>
                <p class="card-text">{{ $output->nama_dosen_pembimbing }}</p>
            </div>
            <div class="mt-2">
                <h5 class="mb-75">Nama Anggota:</h5>
                <p class="card-text">
                <ul>
                    @foreach ($output->member->sortByDesc('status_keanggotaan')->values()->all() as $anggota)
                        <li>{{ $anggota->nim }} :: {{ $anggota->nama_mahasiswa }}
                            {{ $anggota->status_keanggotaan == 'ketua' ? '(Ketua)' : '' }}</li>
                    @endforeach
                </ul>
                </p>
            </div>
            {{-- <div class="mt-2">
                <h5 class="mb-75">Prodi:</h5>
                <p class="card-text">{!! $output['proposal']->prodi_mahasiswa->nama_prodi ?? '<em class="text-danger">data Prodi tidak tersedia</em>' !!}</p>
            </div> --}}

        </div>
        <div class="col-md-4 col-12 p-0 mt-xl-0 mt-2">
            <h4>Data Kompetisi</h4>
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="mt-2">
                        <h5 class="mb-75">Nama Kompetisi:</h5>
                        <p class="card-text">{{ $output['kompetisi']->nama_kompetisi }}</p>
                    </div>
                    <div class="mt-2">
                        <h5 class="mb-75">Skema Terpilih:</h5>
                        <p class="card-text">{{ $output->nama_skema }}</p>
                    </div>
                    <div class="mt-2">
                        <h5 class="mb-75">Status:</h5>
                        <p class="card-text">{!! trans('serba.' . $output->status) !!}</p>
                    </div>
                    @if ($output->review)
                        <div class="mt-2">
                            <h5 class="mb-75">Review:</h5>
                            <p class="card-text">{{ $output->review }}</p>
                        </div>
                    @endif
                    @if ($output->catatan)
                        <div class="mt-2">
                            <h5 class="mb-75">Catatan:</h5>
                            <p class="card-text">{{ $output->catatan }}</p>
                        </div>
                    @endif


                </div>
            </div>
        </div>
        <div class="col-md-4 col-12 p-0 mt-xl-0 mt-2">
            <h4>Lampiran File</h4>
            <div class="row">
                <div class="col-md-12 col-12">
                    @if (isset($additional['is_pdf']))
                        <object data="{{ URL::asset($output->file_upload) }}" type="application/pdf" frameborder="0"
                            width="100%" height="600px" style="padding: 20px;">
                            <p>Oops! Lampiran file dalam bentuk zi!</p>
                            <p><a href="{{ URL::asset($output->file_upload) }}">Download Instead</a></p>
                        </object>
                    @else
                        <img src="{{ URL::asset($output->file_upload) }}" class="img-fluid" style="max-height: 100%"
                            alt="image surat tugas">
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    if (feather) {
        feather.replace({
            width: 14,
            height: 14
        });
    }
</script>
