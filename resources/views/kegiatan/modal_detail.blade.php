<div class="card-body">

    <div class="row invoice-spacing">
        <div class="col-xl-6 p-0 mt-xl-0 mt-2">
            <h4>Data Mahasiswa</h4>
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td class="pr-1">Nama Mahasiswa</td>
                        <td><span class="font-weight-bold">{{ $output['kegiatan']->nama_mahasiswa }}</span></td>
                    </tr>
                    <tr>
                        <td class="pr-1">NIM</td>
                        <td><span class="font-weight-bold">{{ $output['kegiatan']->nim }}</span></td>
                    </tr>
                    <tr>
                        <td class="pr-1">Prodi</td>
                        <td>{{ $output['kegiatan']->prodi }}</td>
                    </tr>
                    <tr>
                        <td class="pr-1">Periode Kegiatan</td>
                        <td>{{ $output['kegiatan']->periode->periode_awal . '-' . $output['kegiatan']->periode->periode_akhir }}
                        </td>
                    </tr>
                    <tr>
                        <td class="pr-1">Tahun Kegiatan</td>
                        <td>{{ $output['kegiatan']->tahun_periode }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xl-6 p-0 mt-xl-0 mt-2">
            <h4>Data Kegiatan</h4>
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td class="pr-1">Klasifikasi Kegiatan</td>
                        <td>{{ $output['kegiatan']->klasifikasi->name_kegiatan }}</td>
                    </tr>
                    <tr>
                        <td class="pr-1">Nama Kegiatan</td>
                        <td>{{ $output['kegiatan']->nama_kegiatan }}</td>
                    </tr>
                    <tr>
                        <td class="pr-1">Tanggal Kegiatan</td>
                        <td>{{ $output['kegiatan']->tanggal_mulai . ' s/d ' . $output['kegiatan']->tanggal_akhir }}</td>
                    </tr>

                    <tr>
                        <td class="pr-1">Link Event</td>
                        <td>{{ $output['kegiatan']->url_event }}</td>
                    </tr>
                    <tr>
                        <td class="pr-1">Status</td>
                        <td>{{ $output['kegiatan']->status }}</td>
                    </tr>
                    <tr>
                        <td class="pr-1">Keputusan Warek</td>
                        <td>{{ $output['kegiatan']->decision_warek }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card-body">
    <h4>Surat Tugas</h4>

    @if ($output['is_pdf']['surat_tugas'])
        <object data="{{ URL::asset($output['kegiatan']->surat_tugas) }}" type="application/pdf" frameborder="0"
            width="100%" height="600px" style="padding: 20px;">
            <p>Oops! Your browser doesn't support PDFs!</p>
            <p><a href="{{ URL::asset($output['kegiatan']->surat_tugas) }}">Download Instead</a></p>
        </object>
    @else
        <img src="{{ URL::asset($output['kegiatan']->surat_tugas) }}" class="img-fluid" style="max-height: 100%"
            alt="image surat tugas">
    @endif

</div>
<div class="card-body">
    <h4>Foto Kegiatan</h4>

    @if ($output['is_pdf']['foto_kegiatan'])
        <object data="{{ URL::asset($output['kegiatan']->foto_kegiatan) }}" type="application/pdf" frameborder="0"
            width="100%" height="600px" style="padding: 20px;">
            <p>Oops! Your browser doesn't support PDFs!</p>
            <p><a href="{{ URL::asset($output['kegiatan']->foto_kegiatan) }}">Download Instead</a></p>
        </object>
    @else
        <img src="{{ URL::asset($output['kegiatan']->foto_kegiatan) }}" class="img-fluid" style="max-height: 100%"
            alt="image surat tugas">
    @endif

</div>
<div class="card-body">
    <h4>Bukti Kegiatan</h4>

    @if ($output['is_pdf']['bukti_kegiatan'])
        <object data="{{ URL::asset($output['kegiatan']->bukti_kegiatan) }}" type="application/pdf" frameborder="0"
            width="100%" height="600px" style="padding: 20px;">
            <p>Oops! Your browser doesn't support PDFs!</p>
            <p><a href="{{ URL::asset($output['kegiatan']->bukti_kegiatan) }}">Download Instead</a></p>
        </object>
    @else
        <img src="{{ URL::asset($output['kegiatan']->bukti_kegiatan) }}" class="img-fluid" style="max-height: 100%"
            alt="image surat tugas">
    @endif

</div>
