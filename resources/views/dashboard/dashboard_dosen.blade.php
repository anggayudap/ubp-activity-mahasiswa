<div class=" col-md-12 col-12">
    <div class="card card-statistics">
        <div class="card-header">
            <h4 class="card-title">Statistik Dosen (DPM)</h4>
        </div>
        <div class="card-body statistics-body">
            {{-- <div class="row pb-3">
                <div class="col-12">
                    <h3 class="card-title">Kegiatan Mahasiswa</h3>
                </div>
                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-2">
                    <div class="media">
                        <div class="avatar bg-light-primary mr-2">
                            <div class="avatar-content">
                                <i data-feather="inbox" class="font-medium-5"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $result['kegiatan_dosen']->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Total Kegiatan</p>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="row pb-3">
                <div class="col-12">
                    <h3 class="card-title">Proposal Kegiatan</h3>
                </div>
                {{-- <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-2">
                    <div class="media">
                        <div class="avatar bg-light-primary mr-2">
                            <div class="avatar-content">
                                <i data-feather="inbox" class="font-medium-5"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $result['proposal_dosen']->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Total Proposal</p>
                        </div>
                    </div>
                </div> --}}

                @php
                    $filtered = $result['proposal_dosen']->filter(function ($value, $key) {
                        return $value->current_status == 'pending' && $value->next_approval == 'fakultas';
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
                    $filtered = $result['proposal_dosen']->filter(function ($value, $key) {
                        return $value->current_status == 'reject' && $value->next_approval == 'fakultas';
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

            </div>
        </div>
    </div>
</div>
