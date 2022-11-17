@extends('adminlte::page')

@section('title', 'Kandidat - Osis - Detail Kandidat ')

@section('content_header')
<h1>Paslon #{{ $osis->paslon_no }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <x-adminlte-card theme="info" theme-mode="outline">
            <div class="row">
                <div class="col-md-6">
                    <div class="card" style="min-height: 325px">
                        <div class="card-body">
                            <div class="img-thumbnail">
                                <img class="img-fluid" src="{{ asset($osis->gambar) }}" alt="" id="previewGambar">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="min-height: 408px">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Paslon No</label>
                                <input class="form-control" value="{{ $osis->paslon_no }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Ketua</label>
                                <input class="form-control" value="{{ \App\Models\User::find($osis->ketua)->name }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Wakil</label>
                                <input class="form-control" value="{{ \App\Models\User::find($osis->wakil)->name }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="text-center mb-0"><label>Visi</label></p>
                                        <textarea disabled name="visi" class="form-control" cols="30" rows="10">{{ $osis->visi }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="text-center mb-0"><label>Misi</label></p>
                                        <textarea disabled name="misi" class="form-control" cols="30" rows="10">{!! strip_tags($osis->misi) !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-adminlte-card>
    </div>
</div>
@stop