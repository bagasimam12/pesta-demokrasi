@extends('adminlte::page')

@section('title', 'Kandidat - Osis')

@section('content_header')
<h1>Kandidat Osis</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Kandidat</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($osis as $row)
                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-hashtag"></i> PASLON {{ $row->paslon_no }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="img-thumbnail">
                                    <img id="kandidat" class="card-img" src="{{ asset($row->gambar) }}" alt="kandidat-image">
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('admin.kandidat.osis.detail', [ 'id' => $row->id ]) }}" class="btn btn-primary btn-block">
                                            <i class="fas fa-user-edit"></i> DETAIL KANDIDAT
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@stop