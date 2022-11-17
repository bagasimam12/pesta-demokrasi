@extends('layouts.default')
@section('headscript')
@endsection
@section('content')
            <div class="card">
                <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                    <h2><strong>{{ ConfigVoting::getConfig()->title }}</strong></h2>
                    <img src="{{ asset('images/static/logosmk.png') }}" class="text-center py-3" alt="Logo" width="180">
                    <h2 class="mb-3"><strong> {{ ConfigVoting::getConfig()->title_prefix }} </strong></h2>

                    <form method="post" action="{{ route('login') }}">
                        @csrf
                        <div class="row">
                            <div class="col-2 pt-2 d-flex flex-colummn">
                                <div class="row d-flex flex-colummn gap-3">
                                    <div class="btn btn-primary rounded-4" disabled><i class="fas fa-user pt"></i>
                                    </div>
                                    <div class="btn btn-primary rounded-4" disabled><i class="fas fa-key pt"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="form-floating my-2">
                                    <input type="text" name="uuid" class="form-control rounded-4" autocomplete="off"
                                        id="inputNIS" value="{{ old('uuid') }}" placeholder="NIS" required="required">
                                    <label for="inputNIS">Masukkan NIS/NIP</label>
                                </div>
                                <div class="form-floating">
                                    <input type="text" name="token" class="form-control rounded-4" autocomplete="off"
                                        id="inputToken" value="" placeholder="Token" required="required">
                                    <label for="inputToken">Masukkan Token</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4 login_container">
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2">MASUK</button>
                        </div>
                    </form>

                </div>
            </div>

<style scoped>
    .card {
        color: whitesmoke;
        background: rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border-radius: 25px;
        border: none;
    }
    label{
        color: grey;
    }
    .pt {
        padding-top: 11px;
    }

    /* .form-control{
            width: 130%
        } */
</style>
@endsection
@section('footscript')

<script>
    @error('login')
        swal({
            icon: 'error',
            title: 'Login Gagal!',
            text: '{{ $message }}'
        });
        @enderror

        @if(session() -> has('voting'))
        swal({
            icon: 'success',
            text: '{{ session('voting') }}'
        });
        @endif
</script>
@endsection