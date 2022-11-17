@extends('adminlte::page')

@section('title', 'Peserta - Dpk')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_header')
    <h1>Peserta Dpk</h1>
@stop

@php 
    $heads  = [
        [
            'label' => 'NIS', 'width' => 20
        ],
        'Nama',
        [
            'label' => 'Kelas', 'width' => 10
        ],
        [
            'label' => 'Voting Mpk', 'width' => 15
        ]
    ];

    $config = [
        'processing' => true,
        'serverSide' => true,
        'ajax' => [
            'headers' => [
                'X-CSRF-TOKEN' => csrf_token()
            ],
            'url'     => route('admin.ajax.datatables.dpk'),
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
                'name' => 'kelas',
                'data' => 'kelas'
            ],
            [
                'name'       => 'voting_mpk',
                'data'       => 'voting_mpk',
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