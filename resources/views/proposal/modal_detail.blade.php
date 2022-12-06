<div class="card-body">

    <div class="row invoice-spacing">
        <div class="col-md-4 col-12 p-0 mt-xl-0 mt-2">
            <h4>Data Mahasiswa</h4>
            <input type="hidden" name="proposal_id" value="{{ $output['proposal']->id }}">
            <div class="mt-2">
                <h5 class="mb-75">Nama Mahasiswa:</h5>
                <p class="card-text">{{ $output['proposal']->nama_mahasiswa }}</p>
            </div>
            <div class="mt-2">
                <h5 class="mb-75">NIM:</h5>
                <p class="card-text">{{ $output['proposal']->nim }}</p>
            </div>
            <div class="mt-2">
                <h5 class="mb-75">Prodi:</h5>
                <p class="card-text">{!! $output['proposal']->prodi_mahasiswa->nama_prodi ?? '<em class="text-danger">data Prodi tidak tersedia</em>' !!}</p>
            </div>

        </div>
        <div class="col-md-8 col-12 p-0 mt-xl-0 mt-2">
            <h4>Data Proposal</h4>
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="mt-2">
                        <h5 class="mb-75">Tanggal Proposal:</h5>
                        <p class="card-text">{{ get_indo_date($output['proposal']->date) }}</p>
                    </div>
                    <div class="mt-2">
                        <h5 class="mb-75">Judul Proposal:</h5>
                        <p class="card-text">{{ $output['proposal']->judul_proposal }}</p>
                    </div>
                    <div class="mt-2">
                        <h5 class="mb-75">Ketua Pelaksana:</h5>
                        <p class="card-text">{{ $output['proposal']->ketua_pelaksana }}</p>
                    </div>
                    <div class="mt-2">
                        <h5 class="mb-75">Tanggal Kegiatan:</h5>
                        <p class="card-text">{{ get_indo_date($output['proposal']->tanggal_mulai) }} s/d
                            {{ get_indo_date($output['proposal']->tanggal_akhir) }}</p>
                    </div>
                    <div class="mt-2">
                        <h5 class="mb-75">Anggaran Pengajuan:</h5>
                        <p class="card-text">{{ rupiah($output['proposal']->anggaran_pengajuan) }}</p>
                    </div>
                    @if ($output['proposal']->laporan_deadline && $output['proposal']->current_status != 'completed')
                        <div class="mt-2">
                            <h5 class="mb-75">
                                <div class="position-relative d-inline-block">
                                    <i data-feather="alert-circle" class="font-medium-5 text-warning"></i>
                                </div> Deadline Upload Laporan:
                            </h5>
                            <p class="card-text">{{ get_indo_date($output['proposal']->laporan_deadline) }}</p>

                        </div>
                    @endif
                </div>
                <div class="col-md-6 col-12">
                    @if ($output['proposal']->fakultas_user_name)
                        <div class="mt-2">
                            <h5 class="mb-75">Approve Fakultas:</h5>
                            <p class="card-text">{{ $output['proposal']->fakultas_user_name }}</p>
                        </div>
                    @endif

                    @if ($output['proposal']->kemahasiswaan_user_name)
                        <div class="mt-2">
                            <h5 class="mb-75">Approve Kemahasiswaan:</h5>
                            <p class="card-text">{{ $output['proposal']->kemahasiswaan_user_name }}</p>
                        </div>
                    @endif

                    @if ($output['proposal']->laporan_kemahasiswaan_user_name)
                        <div class="mt-2">
                            <h5 class="mb-75">Approve Laporan:</h5>
                            <p class="card-text">{{ $output['proposal']->laporan_kemahasiswaan_user_name }}</p>
                        </div>
                    @endif

                    <div class="mt-2">
                        <h5 class="mb-75">Status:</h5>
                        <p class="card-text">{!! trans('serba.' . $output['proposal']->current_status) !!}</p>
                    </div>

                    @if ($output['proposal']->next_approval != 'completed')
                        <div class="mt-2">
                            <h5 class="mb-75">Approval Berikutnya:</h5>
                            <p class="card-text">{{ ucfirst($output['proposal']->next_approval) }}</p>
                        </div>
                    @endif

                    @if ($output['proposal']->reject_note)
                        <div class="mt-2">
                            <h5 class="mb-75">Note:</h5>
                            <p class="card-text">{{ $output['proposal']->reject_note }}</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home"
                    role="tab" aria-selected="true">File Proposal</a>
            </li>
            @if (isset($output['is_pdf']) && $output['proposal']->file_laporan)
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile"
                        role="tab" aria-selected="false">File Laporan</a>
                </li>
            @endif
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
                @if (isset($output['is_pdf']) && $output['is_pdf']['file_proposal'])
                    <object data="{{ URL::asset($output['proposal']->file_proposal) }}" type="application/pdf"
                        frameborder="0" width="100%" height="600px" style="padding: 20px;">
                        <p>Oops! Your browser doesn't support PDFs!</p>
                        <p><a href="{{ URL::asset($output['proposal']->file_proposal) }}">Download Instead</a></p>
                    </object>
                @else
                    <img src="{{ URL::asset($output['proposal']->file_proposal) }}" class="img-fluid"
                        style="max-height: 100%" alt="image surat tugas">
                @endif
            </div>
            @if (isset($output['is_pdf']) && $output['proposal']->file_laporan)
                <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
                    @if ($output['is_pdf']['file_laporan'])
                        <object data="{{ URL::asset($output['proposal']->file_laporan) }}" type="application/pdf"
                            frameborder="0" width="100%" height="600px" style="padding: 20px;">
                            <p>Oops! Your browser doesn't support PDFs!</p>
                            <p><a href="{{ URL::asset($output['proposal']->file_laporan) }}">Download Instead</a></p>
                        </object>
                    @else
                        <img src="{{ URL::asset($output['proposal']->file_laporan) }}" class="img-fluid"
                            style="max-height: 100%" alt="image surat tugas">
                    @endif
                </div>
            @endif
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
