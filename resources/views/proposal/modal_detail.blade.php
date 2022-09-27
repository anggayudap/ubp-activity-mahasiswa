<div class="card-body">

    <div class="row invoice-spacing">
        <div class="col-xl-6 p-0 mt-xl-0 mt-2">
            <h4>Data Mahasiswa</h4>
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
                        <td>{{ $output['proposal']->prodi }}</td>
                    </tr>
                    <tr>
                        <td class="pr-1">Tanggal</td>
                        <td>{{ get_indo_date($output['proposal']->date) }}
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
                        <td>{{ $output['proposal']->judul_proposal }}</td>
                    </tr>
                    <tr>
                        <td class="pr-1">Ketua Pelaksana</td>
                        <td>{{ $output['proposal']->ketua_pelaksana }}</td>
                    </tr>
                    <tr>
                        <td class="pr-1">Anggaran Pengajuan</td>
                        <td>{{ rupiah($output['proposal']->anggaran_pengajuan) }}</td>
                    </tr>

                    <tr>
                        <td class="pr-1">Status</td>
                        <td>{!! trans('serba.'.$output['proposal']->current_status) !!}</td>
                    </tr>

                    <tr>
                        <td class="pr-1">Approval Berikutnya</td>
                        <td>{{ ucfirst($output['proposal']->next_approval) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card-body">
    <h4>Proposal</h4>

    @if ($output['is_pdf']['file_proposal'])
        <object data="{{ URL::asset($output['proposal']->file_proposal) }}" type="application/pdf" frameborder="0"
            width="100%" height="600px" style="padding: 20px;">
            <p>Oops! Your browser doesn't support PDFs!</p>
            <p><a href="{{ URL::asset($output['proposal']->file_proposal) }}">Download Instead</a></p>
        </object>
    @else
        <img src="{{ URL::asset($output['proposal']->file_proposal) }}" class="img-fluid" style="max-height: 100%"
            alt="image surat tugas">
    @endif

</div>
