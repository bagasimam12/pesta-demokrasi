@extends('adminlte::page')

@section('title', 'Kandidat - Mpk')

@section('content_header')
<h1>Kandidat Mpk</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Kandidat Ketua</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($ketua as $row)
                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-hashtag"></i> NO URUT {{ $row->kandidat_no }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="img-thumbnail">
                                    <img id="kandidat" class="card-img" src="{{ asset($row->gambar) }}" alt="kandidat-image">
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('admin.kandidat.mpk.detail', [ 'id' => $row->id ]) }}" class="btn btn-primary btn-block">
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Kandidat Wakil</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($wakil as $row)
                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-hashtag"></i> NO URUT {{ $row->kandidat_no }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="img-thumbnail">
                                    <img id="kandidat" class="card-img" src="{{ asset($row->gambar) }}" alt="kandidat-image">
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('admin.kandidat.mpk.detail', [ 'id' => $row->id ]) }}" class="btn btn-primary btn-block">
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