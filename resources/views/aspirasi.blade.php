@extends('layouts.default')

@section('css')

@endsection

@section('content')

<section class="form-aspirasi text-white">
    <div class="container">
        <form action="{{ route('aspirasi') }}" method="post">
            @csrf
            <input type="hidden" name="voting" value="{{ $voting }}">
            <div class="col-md-12">
                <h1 class="text-center mt-2 mb-5"> <strong>Berikan Aspirasi Anda!</strong> </h1>
                <div class="card-body row d-flex justify-content-center gap-3">
                    <div class="col-md-5">
                        <p class="lead">Ketikan Ucapan Terima Kasih & Tanggapan untuk Pengurus OSIS Masa Bakti
                            2021/2022
                        </p>
                        <div class="form-group has-feedback">
                            <textarea name="ucapan" id="ucapan" cols="30" rows="10"
                                class="form-control  @error('ucapan') is-invalid @enderror" required=""></textarea>
                            <div class="invalid-feedback">
                                @error('ucapan')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <p class="lead">Ketikan Saran & Aspirasi untuk Ketua & Wakil Ketua OSIS Masa Bakti
                            {{ ConfigVoting::getConfig()->periode }}</p>
                        <div class="form-group has-feedback">
                            <textarea name="aspirasi" id="aspirasi" cols="30" rows="10"
                                class="form-control  @error('aspirasi') is-invalid @enderror" required=""></textarea>
                            <div class="invalid-feedback">
                                @error('aspirasi')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 my-4 text-center">
                    <button type="submit" class="btn btn-primary btn-block">Kirim Aspirasi</button>
                </div>
            </div>
        </form>
    </div>
</section>

<style scoped>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .lead {
        color: black;
        padding: 12px;
        margin-bottom: 1.5rem;
        background: rgba(255, 255, 255, 0.4);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.4);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.18);
    }
</style>

@stop


@push('js')
<script>
    $(document).ready(function () {
        @error('voting')
        swal({
            icon: 'error',
            title: 'Error!',
            text: '{{ $message }}'
        });
        @enderror

        @if(session() -> has('voting'))
        swal({
            icon: 'success',
            text: '{{ session('voting') }}'
        });
        @endif
    });
</script>
@endpush