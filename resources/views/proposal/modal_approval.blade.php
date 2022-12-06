<div class="card-body">
    <form id="form" action="#" method="post" class="form" enctype="multipart/form-data" novalidate>
        {{-- @csrf --}}
        {{-- @method('PUT') --}}
        <div class="row invoice-spacing">
            <div class="col-xl-6 p-0 mt-xl-0 mt-2">
                <h4>Data Mahasiswa</h4>
                <input type="hidden" name="proposal_id" value="{{ $output['proposal']->id }}">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="pr-1">Nama Mahasiswa</td>
                            <td><span class="font-weight-bold">{{ $output['proposal']->nama_mahasiswa }}</span></td>
                        </tr>
                        <tr>
                            <td class="pr-1">NIM</td>
                            <td><span class="font-weight-bold">{{ $output['proposal']->nim }}</span></td>
                        </tr>
                        <tr>
                            <td class="pr-1">Prodi</td>
                            <td>{{ $output['proposal']->prodi_mahasiswa->nama_prodi }}</td>
                        </tr>
                        <tr>
                            <td class="pr-1">Tanggal</td>
                            <td>
                                <input type="text" id="date" name="date" class="form-control flatpickr-basic"
                                    value="{{ $output['proposal']->date }}" required>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="col-xl-6 p-0 mt-xl-0 mt-2">
                <h4>Data Proposal</h4>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="pr-1">Judul Proposal</td>
                            <td>
                                <input type="text" id="judul-proposal" class="form-control" name="judul_proposal"
                                    placeholder="Judul Proposal" value="{{ $output['proposal']->judul_proposal }}"
                                    required>
                            </td>
                        </tr>
                        <tr>
                            <td class="pr-1">Ketua Pelaksana</td>
                            <td>
                                <input type="text" id="ketua-pelaksana" class="form-control" name="ketua_pelaksana"
                                    placeholder="Ketua Pelaksana" value="{{ $output['proposal']->ketua_pelaksana }}"
                                    required>
                            </td>
                        </tr>
                        <tr>
                            <td class="pr-1">Anggaran Pengajuan</td>
                            <td>
                                <input type="number" id="anggaran-pengajuan" class="form-control"
                                    name="anggaran_pengajuan" placeholder="Anggaran Pengajuan"
                                    value="{{ $output['proposal']->anggaran_pengajuan }}" required>

                            </td>
                        </tr>

                        <tr>
                            <td class="pr-1">Status</td>
                            <td>{!! trans('serba.' . $output['proposal']->current_status) !!}</td>
                        </tr>

                        @if ($output['proposal']->next_approval != 'completed')
                            <tr>
                                <td class="pr-1">Approval Berikutnya</td>
                                <td>{{ ucfirst($output['proposal']->next_approval) }}</td>
                            </tr>
                        @endif

                        @if ($output['proposal']->reject_note)
                            <tr>
                                <td class="pr-1">Note</td>
                                <td>{{ $output['proposal']->reject_note }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
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
<script type="text/javascript">
    const basicPickr = $('.flatpickr-basic');
    if (basicPickr.length) {
        basicPickr.flatpickr();
    }
</script>
