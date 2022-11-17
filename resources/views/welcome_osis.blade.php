@extends('layouts.default')

@section('content')

@if (session()->has('welcome'))
<div class="container" style="margin-top: 50px;">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="card-title lead text-center">Ketua OSIS & Wakil Ketua OSIS <br> {{ ConfigVoting::getConfig()->title_prefix }} <br> Masa Bakti {{ ((int)now()->format('Y') - 1) . '/' . now()->format('Y') }}</h6>
                </div>
                <div class="card-body">
                    <img class="card-img-top" src="{{ asset('images/static/osis_lalu.jpeg') }}" alt="">
                </div>
                <div class="card-footer text-center">
                    <form method="post" action="{{ route('next') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary rd-btn">SIAPAKAH SELANJUTNYA ?</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if (session()->has('next'))
<div class="container" style="margin-top: 50px;">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="card-title lead text-center">Ketua OSIS & Wakil Ketua OSIS <br> {{ ConfigVoting::getConfig()->title_prefix }} <br> Masa Bakti {{ ConfigVoting::getConfig()->title_prefix }}</h6>
                </div>
                <div class="card-body">
                    <img class="card-img-top" src="{{ asset('images/static/whoisnext.jpeg') }}" alt="">
                </div>
                <div class="card-footer text-center">
                    <form method="post" action="{{ route('letsgo') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary rd-btn">PILIH OSIS UNTUK SELANJUTNYA</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div style="margin-bottom: 50px;"></div>

<div class="footer-basic">
    <footer>
        <p class="copyright text-white">
            <b>{{ strtoupper(ConfigVoting::getConfig()->title) }} <br> {{ strtoupper(ConfigVoting::getConfig()->title_prefix) }}</b>
        </p>
    </footer>
</div>

@stop
