<div class="card-body">
    <form id="form" action="{{ route('proposal.submit_laporan') }}" method="post" class="form"
        enctype="multipart/form-data" novalidate>
        @csrf
        {{-- @method('PUT') --}}
        <input type="hidden" name="id" value="{{ $output['proposal']->id }}">
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <div class="col-sm-3 col-form-label">
                        <label for="first-name">Upload File Laporan Proposal</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file-laporan" name="file_laporan"
                                accept="application/pdf" required/>
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group row">
                        <em>Ket : Upload file menggunakan format pdf. Maks. size 5mb.</em>
                        @if ($output['proposal']->file_proposal)
                            <em>File laporan sebelumnya akan diganti dengan file laporan yang baru.</em>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12"><button type="submit" class="btn btn-success waves-effect waves-float waves-light">
                    <i data-feather="upload" class="mr-25"></i>Upload</button></div>
        </div>
    </form>
</div>
<script>
    if (feather) {
        feather.replace({
            width: 14,
            height: 14
        });
    }
</script>
