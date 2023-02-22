<div class="card-body">

    <div class="row invoice-spacing">
        <div class="col-md-6 col-12 p-0 mt-xl-0 mt-2">
            <h4>Data Registrasi Kompetisi</h4>
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
                <h5 class="mb-75">NIDN Dosen Pembimbing:</h5>
                <p class="card-text">{{ $output->nidn_dosen_pembimbing }}</p>
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
                    @if ($output->note_reject && $output->status == 'reject')
                        <div class="mt-2">
                            <h5 class="mb-75">Note Reject:</h5>
                            <p class="card-text">{{ $output->note_reject }}</p>
                        </div>
                    @endif
                    @if ($output->nama_dosen_penilai)
                    <div class="mt-2">
                        <h5 class="mb-75">Nama Dosen Penilai/Reviewer:</h5>
                        <p class="card-text">{{ $output->nama_dosen_penilai }}</p>
                    </div>
                    <div class="mt-2">
                        <h5 class="mb-75">NIDN Dosen Penilai/Reviewer:</h5>
                        <p class="card-text">{{ $output->nidn_dosen_penilai }}</p>
                    </div>
                    @endif
                    @if ($output->review)
                        <div class="mt-2">
                            <h5 class="mb-75">Hasil Review:</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Review</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($output->review as $item)
                                            <tr>
                                                <td>{{ $item->teks_review }}</td>
                                                <td>{!! ($item->skor_review) ?: '<em>(belum dinilai)</em>' !!}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">Tidak ada review yang diplotting.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    @if ($output->catatan)
                        <div class="mt-2">
                            <h5 class="mb-75">Catatan:</h5>
                            <p class="card-text">{!! $output->catatan !!}</p>
                        </div>
                    @endif


                </div>
            </div>

        </div>
        {{-- <div class="col-md-4 col-12 p-0 mt-xl-0 mt-2">
            
        </div> --}}
        <div class="col-md-6 col-12 p-0 mt-xl-0 mt-2">
            <h4>Lampiran File</h4>
            <div class="row">
                <div class="col-md-12 col-12">
                    @if ($additional['is_pdf'])
                        <object data="{{ URL::asset($output->file_upload) }}" type="application/pdf" frameborder="0"
                            width="100%" height="600px" style="padding: 20px;">
                            <p>Oops! Lampiran file dalam bentuk arsip zip!</p>
                            <p><a href="{{ URL::asset($output->file_upload) }}">Download Instead</a></p>
                        </object>
                    @else
                        <p>File lampiran yang di upload menggunakan format arsip ZIP. Klik button dibawah untuk mendownload file arsip.</p>
                        <br>
                        <a href="{{ URL::asset($output->file_upload) }}" class="btn btn-primary"><i data-feather="download" class="mr-50"></i>Download Arsip</a>
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
