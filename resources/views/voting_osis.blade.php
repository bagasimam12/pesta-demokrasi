@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" !important>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <style scoped>
        .no-paslon {
            position: absolute;
            /* padding: 30px 15px 8px 30px; */
            padding: 65px 25px 15px 76px;
            border-radius: 50%;
            font-size: 1.5rem;
            color: white;
            background-color: #0d6dfc;
            left: -60px;
            top: -55px;
            box-shadow: 0 8px 32px 0 rgba(6, 6, 6, 0.3);
        }

        .card {
            border: none !important;
        }

        .card {
            color: black;
            background: rgba(200, 200, 200, 0.37);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .card .card-paslon {
            box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.05);
        }

        .modal-body p {
            margin-bottom: 0.5rem;
            /* letter-spacing: 0.5px; */
            font-weight: 200 !important;
        }
    </style>
@endsection

@section('content')

    <ul class="cards">
        @foreach ($kandidat as $row)
            <li>
                <a href="#kandidat-{{ $row->paslon_no }}"
                    class="card h-100 card-paslon d-flex align-items-center text-center" style="width: 18rem">
                    <div class="no-paslon">{{ $row->paslon_no }}</div>
                    <img src="{{ asset($row->gambar) }}" alt="photo-profile" width="120" class="pt-4 rounded-circle" />
                    <div class="card-body">
                        <h5 class="card-title fst-italic m-0">Ketua</h5>
                        <p class="card-text fw-bold">{{ $row->ketua }}</p>
                        <h5 class="card-title fst-italic m-0">Wakil Ketua</h5>
                        <p class="card-text fw-bold">{{ $row->wakil }}</p>
                        <div class="row gap-2 d-flex justify-content-center">
                            <button type="button" class="open_visi btn btn-primary col-5" data-toggle="modal"
                                data-target="#modalVisi" data-visi="{!! $row->visi !!}">VISI</button>
                            <button type="button" class="btn btn-primary col-5" data-toggle="modal"
                                data-target="#modalMisi" data-misi="{{ $row->misi }}">MISI</button>
                            <button data-toggle="modal" data-target="#modalVoteKandidat" data-ketua="{{ $row->ketua }}"
                                data-wakil="{{ $row->wakil }}" data-kandidat="{{ $row->id }}" type="button"
                                class="btn btn-primary">PILIH</button>
                        </div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>

    <div class="modal fade" id="modalVoteKandidat" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalVoteKandidatLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalVoteKandidatLabel">Konfirmasi Pemilihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="lead">Dengan ini dengan penuh kesadaran dan dengan tanpa paksaan saya memilih <b><span
                                id="paslon"></span></b> sebagai calon ketua dan wakil ketua OSIS
                        {{ ConfigVoting::getConfig()->title_prefix }} untuk periode
                        {{ ConfigVoting::getConfig()->periode }}.</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('vote.osis') }}" method="post">
                        @csrf
                        <input type="hidden" id="kandidat-id" name="kandidat_id">
                        <button type="submit" class="btn btn-primary">Konfirmasi Pemilihan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVisi" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalVisiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalVisiLabel">VISI</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-center">Visi</h6>
                            <hr>
                            <p id="visi"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMisi" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalMisiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMisiLabel">MISI</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-center">MISI</h6>
                            <hr>
                            <div id="misi"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- javascript --}}
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.10/dist/sweetalert2.all.min.js"></script>
    {{-- end js --}}
@stop

@push('js')
    <script>
        $(document).ready(function() {
            $('#modalVisi').on('show.bs.modal', function(e) {
                var modal = $(this);
                var button = $(e.relatedTarget);

                modal.find('#visi').text(button.data('visi'));
            });

            $('#modalVisi').on('hide.bs.modal', function(e) {
                var modal = $(this);
                var button = $(e.relatedTarget);

                modal.find('#visi').text('');
            });

            $('#modalMisi').on('show.bs.modal', function(e) {
                var modal = $(this);
                var button = $(e.relatedTarget);

                modal.find('#misi').html(button.data('misi'));
            });

            $('#modalMisi').on('hide.bs.modal', function(e) {
                var modal = $(this);
                var button = $(e.relatedTarget);

                modal.find('#misi').html('');
            });

            $('#modalVoteKandidat').on('show.bs.modal', function(e) {
                var modal = $(this);
                var button = $(e.relatedTarget);

                modal.find('#kandidat-id').val(button.data('kandidat'));
                modal.find('#paslon').text(button.data('ketua') + ' & ' + button.data('wakil'));
            });

            @error('voting')
                swal({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ $message }}'
                });
            @enderror

            @if (session()->has('message'))
                swal({
                    icon: 'info',
                    title: 'Welcome',
                    text: '{{ session('message') }}'
                });
            @endif

            @if (session()->has('welcome'))
                swal({
                    icon: 'success',
                    text: 'Silakan berikan suara anda disini'
                });
            @endif
        });
    </script>
@endpush
