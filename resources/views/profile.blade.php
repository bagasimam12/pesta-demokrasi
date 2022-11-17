@extends('layouts.default')

@section('headscript')
@endsection

@section('content')
    <div class="profile-card d-flex justify-content-center">
    <div class="card mb-3" style="max-width: 600px;">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="{{ asset('images/static/user-profile.png') }}" class="img-fluid rounded-start p-2" alt="user-profile">
          </div>
          <div class="col-md-8">
            <div class="card-body">
                <div class="name mt-3">
                <h3 class="name"><strong>{{ Auth::user()->name }}</strong></h3>
                <h6 class="type text-uppercase"><strong>{{ Auth::user()->user_type }}</strong></h6>
                </div>
                <div class="data mt-3">
              <p class="card-text m-0"><strong>NIS/NIP :</strong><span class="fst-italic"> {{ Auth::user()->uuid }}</span></p>
              <p class="card-text"><strong>Kelas : </strong><span class="fst-italic"> 
                <?php
                    if (Auth::user()->kelas_id == 1) {
                        echo ' X AK 1';
                    } elseif (Auth::user()->kelas_id == 2) {
                        echo ' X AK 2';
                    } elseif (Auth::user()->kelas_id == 3) {
                        echo ' X AK 3';
                    } elseif (Auth::user()->kelas_id == 4) {
                        echo ' X AP 1';
                    } elseif (Auth::user()->kelas_id == 5) {
                        echo ' X AP 2';
                    } elseif (Auth::user()->kelas_id == 6) {
                        echo ' X AP';
                    } elseif (Auth::user()->kelas_id == 7) {
                        echo ' X FS 1';
                    } elseif (Auth::user()->kelas_id == 8) {
                        echo ' X FS 2';
                    } elseif (Auth::user()->kelas_id == 9) {
                        echo ' X MPLB 1';
                    } elseif (Auth::user()->kelas_id == 10) {
                        echo ' X MPLB 2';
                    } elseif (Auth::user()->kelas_id == 11) {
                        echo ' X MPLB 3';
                    } elseif (Auth::user()->kelas_id == 12) {
                        echo ' X PM 1';
                    } elseif (Auth::user()->kelas_id == 13) {
                        echo ' X PM 2';
                    } elseif (Auth::user()->kelas_id == 14) {
                        echo ' X PPLG 1';
                    } elseif (Auth::user()->kelas_id == 15) {
                        echo ' X PPLG 2';
                    } elseif (Auth::user()->kelas_id == 16) {
                        echo ' X TE 1';
                    } elseif (Auth::user()->kelas_id == 17) {
                        echo ' X TE 2';
                    } elseif (Auth::user()->kelas_id == 18) {
                        echo ' X TKJ 1';
                    } elseif (Auth::user()->kelas_id == 19) {
                        echo ' X TKJ 2';
                    } elseif (Auth::user()->kelas_id == 20) {
                        echo ' XI AK 1';
                    } elseif (Auth::user()->kelas_id == 21) {
                        echo ' XI AK 2';
                    } elseif (Auth::user()->kelas_id == 22) {
                        echo ' XI AK 3';
                    } elseif (Auth::user()->kelas_id == 23) {
                        echo ' XI APAT 1';
                    } elseif (Auth::user()->kelas_id == 24) {
                        echo ' XI APAT 2';
                    } elseif (Auth::user()->kelas_id == 25) {
                        echo ' XI APAT 3';
                    } elseif (Auth::user()->kelas_id == 26) {
                        echo ' XI BDP 1';
                    } elseif (Auth::user()->kelas_id == 27) {
                        echo ' XI BDP 2';
                    } elseif (Auth::user()->kelas_id == 28) {
                        echo ' XI OTKP 1';
                    } elseif (Auth::user()->kelas_id == 29) {
                        echo ' XI OTKP 2';
                    } elseif (Auth::user()->kelas_id == 30) {
                        echo ' XI OTKP 3';
                    } elseif (Auth::user()->kelas_id == 31) {
                        echo ' XI RPL 1';
                    } elseif (Auth::user()->kelas_id == 32) {
                        echo ' XI RPL 2';
                    } elseif (Auth::user()->kelas_id == 33) {
                        echo ' XI TB 1';
                    } elseif (Auth::user()->kelas_id == 34) {
                        echo ' XI TB 2';
                    } elseif (Auth::user()->kelas_id == 35) {
                        echo ' XI TKJ 1';
                    } elseif (Auth::user()->kelas_id == 36) {
                        echo ' XI TKJ 2';
                    } elseif (Auth::user()->kelas_id == 37) {
                        echo ' XI TMT 1';
                    } elseif (Auth::user()->kelas_id == 38) {
                        echo ' XI TMT 2';
                    } elseif (Auth::user()->kelas_id == 39) {
                        echo ' XII AK 1';
                    } elseif (Auth::user()->kelas_id == 40) {
                        echo ' XII AK 2';
                    } elseif (Auth::user()->kelas_id == 41) {
                        echo ' XII AK 3';
                    } elseif (Auth::user()->kelas_id == 42) {
                        echo ' XII APAT 1';
                    } elseif (Auth::user()->kelas_id == 43) {
                        echo ' XII APAT 2';
                    } elseif (Auth::user()->kelas_id == 44) {
                        echo ' XII APAT 3';
                    } elseif (Auth::user()->kelas_id == 45) {
                        echo ' XII BDP 1';
                    } elseif (Auth::user()->kelas_id == 46) {
                        echo ' XII BDP 2';
                    } elseif (Auth::user()->kelas_id == 47) {
                        echo ' XII OTKP 1';
                    } elseif (Auth::user()->kelas_id == 48) {
                        echo ' XII OTKP 2';
                    } elseif (Auth::user()->kelas_id == 49) {
                        echo ' XII OTKP 3';
                    } elseif (Auth::user()->kelas_id == 50) {
                        echo ' XII RPL 1';
                    } elseif (Auth::user()->kelas_id == 51) {
                        echo ' XII RPL 2';
                    } elseif (Auth::user()->kelas_id == 52) {
                        echo ' XII TB 1';
                    } elseif (Auth::user()->kelas_id == 53) {
                        echo ' XII TB 2';
                    } elseif (Auth::user()->kelas_id == 54) {
                        echo ' XII TKJ 1';
                    } elseif (Auth::user()->kelas_id == 55) {
                        echo ' XII TKJ 2';
                    } elseif (Auth::user()->kelas_id == 56) {
                        echo ' XII TMT 1';
                    } elseif (Auth::user()->kelas_id == 57) {
                        echo ' XII TMT 2';
                    } elseif (Auth::user()->kelas_id == 58) {
                        echo ' XIII TMT 1';
                    } elseif (Auth::user()->kelas_id == 59) {
                        echo ' XIII TMT 2';
                    }
                    ?></span>
              </p>
            </div>
            </div>
          </div>
        </div>
        <div class="row p-3 pt-0">
            <div class="col-md-6 pb-md-0 pb-2"><button data-bs-toggle="modal" data-bs-target="#modalLogout" type="button" class="btn btn-danger btn-sm w-100">Kembali</button></div>
            <div class="col-md-6 text-md-end"><form action="{{ route('agreement') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm w-100">Lanjut</button>
            </form></div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalLogout" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalLogout" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLogout">Konfirmasi Ulang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="lead">Apakah kamu yakin untuk keluar?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('logout') }}" method="get">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Yakin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            background: rgba( 255, 255, 255, 0.3 );
box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
backdrop-filter: blur( 2.5px );
-webkit-backdrop-filter: blur( 2.5px );
border-radius: 10px;
border: 1px solid rgba( 255, 255, 255, 0.18 );
}
.profile-card{
    margin-top: 7rem !important;
}
        @media only screen and (max-width: 600px) {
            .profile-card{
                margin-top: 0 !important;
            }
        }
    </style>
@endsection

@push('footscript')
    <script>
        $(document).ready(function() {
            $('#modalLogout').on('show.bs.modal', function(e) {
                var modal = $(this);
                var button = $(e.relatedTarget);
            });
        });
    </script>
@endpush
