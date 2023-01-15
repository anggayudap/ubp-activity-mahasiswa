<div class=" col-md-12 col-12">
    <div class="card card-statistics">
        <div class="card-header">
            <h4 class="card-title">Statistik Dosen</h4>
        </div>
        <div class="card-body statistics-body">
            <div class="row pb-3">
                <div class="col-12">
                    <h3 class="card-title">Kompetisi</h3>
                </div>

                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-2">
                    <div class="media">
                        <a class="avatar bg-light-warning mr-2" href="{{ route('kompetisi.review.list') }}">
                            <div class="avatar-content">
                                <i data-feather="edit" class="font-medium-5"></i>
                            </div>
                        </a>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{ $result['kompetisi_review_dosen']->count() }}</h4>
                            <p class="card-text font-small-3 mb-0">Kompetisi Menunggu Penilaian & Review</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
