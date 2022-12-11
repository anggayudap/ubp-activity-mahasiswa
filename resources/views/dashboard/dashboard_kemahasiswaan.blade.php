<div class=" col-md-12 col-12">
    <div class="card card-statistics">
        <div class="card-header">
            <h4 class="card-title">Statistik Kemahasiswaan</h4>
        </div>
        <div class="card-body statistics-body">
            <div class="row pb-3">
                <div class="col-12">
                    <h3 class="card-title">Kegiatan Mahasiswa</h3>
                </div>
                
                @php
                    $filtered = $result['kegiatan_kemahasiswaan']->filter(function ($value, $key) {
                        return !$value->approval;
                    });
                @endphp
                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-2">
                    <div class="media">
                        <div class="avatar bg-light-warning mr-2">
                            <div class="avatar-content">
                                <i data-feather="edit" class="font-medium-5"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Kegiatan Menunggu Approval</p>
                        </div>
                    </div>
                </div>

                @php
                    $filtered = $result['kegiatan_kemahasiswaan']->filter(function ($value, $key) {
                        return $value->status == 'completed' && $value->approval == 'approve';
                    });
                @endphp
                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-2">
                    <div class="media">
                        <div class="avatar bg-light-success mr-2">
                            <div class="avatar-content">
                                <i data-feather="check" class="font-medium-5"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Total Kegiatan Diapprove</p>
                        </div>
                    </div>
                </div>


                @php
                    $filtered = $result['kegiatan_kemahasiswaan']->filter(function ($value, $key) {
                        return $value->status == 'completed' && $value->approval == 'reject';
                    });
                @endphp
                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-2">
                    <div class="media">
                        <div class="avatar bg-light-danger mr-2">
                            <div class="avatar-content">
                                <i data-feather="activity" class="font-medium-5"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Total Kegiatan Direject</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row pb-3">
                <div class="col-12">
                    <h3 class="card-title">Proposal Kegiatan</h3>
                </div>

                @php
                    $filtered = $result['proposal_kemahasiswaan']->filter(function ($value, $key) {
                        return $value->current_status == 'pending' && $value->next_approval == 'kemahasiswaan';
                    });
                @endphp
                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-2">
                    <div class="media">
                        <div class="avatar bg-light-warning mr-2">
                            <div class="avatar-content">
                                <i data-feather="edit" class="font-medium-5"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Proposal Menunggu Approval</p>
                        </div>
                    </div>
                </div>

                @php
                    $filtered = $result['proposal_kemahasiswaan']->filter(function ($value, $key) {
                        return $value->current_status == 'laporan_diupload' && $value->next_approval == 'kemahasiswaan';
                    });
                @endphp
                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-2">
                    <div class="media">
                        <div class="avatar bg-light-warning mr-2">
                            <div class="avatar-content">
                                <i data-feather="edit" class="font-medium-5"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Laporan Menunggu Approval</p>
                        </div>
                    </div>
                </div>

                @php
                    $filtered = $result['proposal_kemahasiswaan']->filter(function ($value, $key) {
                        return $value->current_status == 'reject' && $value->next_approval == 'kemahasiswaan';
                    });
                @endphp
                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-2">
                    <div class="media">
                        <div class="avatar bg-light-danger mr-2">
                            <div class="avatar-content">
                                <i data-feather="activity" class="font-medium-5"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Proposal Telah Direject</p>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-2">
                    <div class="media">
                        <div class="avatar bg-light-primary mr-2">
                            <div class="avatar-content">
                                <i data-feather="inbox" class="font-medium-5"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $result['proposal_kemahasiswaan']->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Total Proposal</p>
                        </div>
                    </div>
                </div> --}}

                
                

            </div>
        </div>
    </div>
</div>
