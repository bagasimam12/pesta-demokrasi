@extends('adminlte::page')

@section('title', 'Peserta - Siswa')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_header')
    <h1>Peserta Guru</h1>
@stop

@php 
    $heads  = [
        [
            'label' => 'UUID', 'width' => 20
        ],
        'Nama',
        [
            'label' => 'Voting Osis', 'width' => 15
        ]
    ];

    $config = [
        'processing' => true,
        'serverSide' => true,
        'ajax' => [
            'headers' => [
                'X-CSRF-TOKEN' => csrf_token()
            ],
            'url'     => route('admin.ajax.datatables.guru'),
            'type'    => 'POST'
        ],
        'columns' => [
            [
                'name' => 'uuid',
                'data' => 'uuid'
            ],
            [
                'name' => 'name',
                'data' => 'name'
            ],
            [
                'name'       => 'voting_osis',
                'data'       => 'voting_osis',
                'sClass'     => 'text-center',
            ]
        ]
    ];
@endphp

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Daftar Peserta" theme="info">
                <x-adminlte-datatable id="table1" :heads="$heads" head-theme="light" theme="info" :config="$config" striped bordered compressed hoverable with-buttons/>
            </x-adminlte-card>
        </div>
    </div>
@stop