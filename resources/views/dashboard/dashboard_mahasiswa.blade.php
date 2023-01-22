<div class=" col-md-12 col-12">
    <div class="card card-statistics">
        <div class="card-body statistics-body">
            {{-- KEGIATAN --}}
            <div class="row pb-3">
                <div class="col-12">
                    <h3 class="card-title">Kegiatan Mahasiswa</h3>
                </div>
                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-2">
                    <div class="media">
                        <a href="{{ route('kegiatan.list') }}" class="avatar bg-light-primary mr-2">
                            <div class="avatar-content">
                                <i data-feather="inbox" class="font-medium-5"></i>
                            </div>
                        </a>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $result['kegiatan']->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Total Kegiatan Diinput</p>
                        </div>
                    </div>
                </div>

                @php
                    $filtered = $result['kegiatan']->filter(function ($value, $key) {
                        return $value->status == 'review';
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
                            <p class="card-text font-small-3 mb-0">Kegiatan Belum Dinilai</p>
                        </div>
                    </div>
                </div>

                @php
                    $filtered = $result['kegiatan']->filter(function ($value, $key) {
                        return $value->approval == 'reject';
                    });
                @endphp
                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                    <div class="media">
                        <div class="avatar bg-light-danger mr-2">
                            <div class="avatar-content">
                                <i data-feather="activity" class="font-medium-5"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Kegiatan Direject</p>
                        </div>
                    </div>
                </div>

                @php
                    $filtered = $result['kegiatan']->filter(function ($value, $key) {
                        return $value->status == 'completed' && $value->approval == 'approve';
                    });
                @endphp
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="media">
                        <div class="avatar bg-light-success mr-2">
                            <div class="avatar-content">
                                <i data-feather="user-check" class="font-medium-5"></i>

                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Kegiatan Sudah Dinilai</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PROPOSAL --}}
            <div class="row pb-3">
                <div class="col-12">
                    <h3 class="card-title">Proposal Kegiatan</h3>
                </div>
                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-2">
                    <div class="media">
                        <a href="{{ route('kegiatan.list') }}" class="avatar bg-light-primary mr-2">
                            <div class="avatar-content">
                                <i data-feather="inbox" class="font-medium-5"></i>
                            </div>
                        </a>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $result['proposal']->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Total Proposal Diinput</p>
                        </div>
                    </div>
                </div>

                @php
                    $filtered = $result['proposal']->filter(function ($value, $key) {
                        return $value->current_status == 'pending' && $value->next_approval == 'fakultas';
                    });
                @endphp
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="media">
                        <div class="avatar bg-light-warning mr-2">
                            <div class="avatar-content">
                                <i data-feather="edit" class="font-medium-5"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Pending Approval DPM</p>
                        </div>
                    </div>
                </div>

                @php
                    $filtered = $result['proposal']->filter(function ($value, $key) {
                        return $value->current_status == 'pending' && $value->next_approval == 'kemahasiswaan';
                    });
                @endphp
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="media">
                        <div class="avatar bg-light-warning mr-2">
                            <div class="avatar-content">
                                <i data-feather="edit" class="font-medium-5"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Pending Approval Kemahasiswaan</p>
                        </div>
                    </div>
                </div>

                @php
                    $filtered = $result['proposal']->filter(function ($value, $key) {
                        return $value->current_status == 'laporan_diupload' && $value->next_approval == 'kemahasiswaan';
                    });
                @endphp
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="media">
                        <div class="avatar bg-light-warning mr-2">
                            <div class="avatar-content">
                                <i data-feather="edit" class="font-medium-5"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Pending Approval Laporan</p>
                        </div>
                    </div>
                </div>

                @php
                    $filtered = $result['proposal']->filter(function ($value, $key) {
                        return $value->current_status == 'upload_laporan' && !$value->file_laporan;
                    });
                @endphp
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="media">
                        <div class="avatar bg-light-danger mr-2">
                            <div class="avatar-content">
                                <i data-feather="upload" class="font-medium-5"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">
                                {{ $filtered->min('laporan_deadline') ? get_indo_date($filtered->min('laporan_deadline')) : '-' }}
                            </h4>
                            <p class="card-text font-small-3 mb-0">Deadline Upload Laporan</p>
                        </div>
                    </div>
                </div>

                @php
                    $filtered = $result['proposal']->filter(function ($value, $key) {
                        return $value->current_status == 'reject';
                    });
                @endphp
                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                    <div class="media">
                        <div class="avatar bg-light-danger mr-2">
                            <div class="avatar-content">
                                <i data-feather="activity" class="font-medium-5"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Proposal Direject</p>
                        </div>
                    </div>
                </div>

                @php
                    $filtered = $result['proposal']->filter(function ($value, $key) {
                        return $value->current_status == 'completed' && $value->next_approval == 'completed';
                    });
                @endphp
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="media">
                        <div class="avatar bg-light-success mr-2">
                            <div class="avatar-content">
                                <i data-feather="user-check" class="font-medium-5"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Proposal Selesai</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOMPETISI --}}
            <div class="row pb-3">
                <div class="col-12">
                    <h3 class="card-title">Kompetisi</h3>
                </div>
                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-2">
                    <div class="media">
                        <a href="{{ route('kompetisi.history') }}" class="avatar bg-light-warning mr-2">
                            <div class="avatar-content">
                                <i data-feather="user-check" class="font-medium-5"></i>
                            </div>
                        </a>
                        <div class="media-body my-auto">
                            @php
                                $filtered = $result['kompetisi']->filter(function ($value, $key) {
                                    return $value->status == 'pending';
                                });
                            @endphp
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Pending ACC Kemahasiswaan</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-2">
                    <div class="media">
                        <a href="{{ route('kompetisi.history') }}" class="avatar bg-light-danger mr-2">
                            <div class="avatar-content">
                                <i data-feather="user-x" class="font-medium-5"></i>
                            </div>
                        </a>
                        <div class="media-body my-auto">
                            @php
                                $filtered = $result['kompetisi']->filter(function ($value, $key) {
                                    return $value->status == 'reject';
                                });
                            @endphp
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Reject ACC Kemahasiswaan</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-2">
                    <div class="media">
                        <a href="{{ route('kompetisi.history') }}" class="avatar bg-light-info mr-2">
                            <div class="avatar-content">
                                <i data-feather="edit" class="font-medium-5"></i>
                            </div>
                        </a>
                        <div class="media-body my-auto">
                            @php
                                $filtered = $result['kompetisi']->filter(function ($value, $key) {
                                    return $value->status == 'in_review';
                                });
                            @endphp
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Dalam proses Review</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-2">
                    <div class="media">
                        <a href="{{ route('kompetisi.history') }}" class="avatar bg-light-primary mr-2">
                            <div class="avatar-content">
                                <i data-feather="check-circle" class="font-medium-5"></i>
                            </div>
                        </a>
                        <div class="media-body my-auto">
                            @php
                                $filtered = $result['kompetisi']->filter(function ($value, $key) {
                                    return $value->status == 'completed';
                                });
                            @endphp
                            <h4 class="font-weight-bolder mb-0">{{ $filtered->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Selesai Dinilai & Direview</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
