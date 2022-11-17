@extends('adminlte::page')

@section('title', 'Aspirasi - Osis - Guru')

@section('content_header')
	<h1>Aspirasi Dari Guru</h1>
@stop

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@php 
    $heads  = [
        [
        	'label' => 'Nama',
        	'width' => 25
        ],
        'Aspirasi',
    ];

    $config = [
        'processing' => true,
        'serverSide' => true,
        'ajax' => [
            'headers' => [
                'X-CSRF-TOKEN' => csrf_token()
            ],
            'url'     => route('admin.ajax.aspirasi.osis', ['type' => 'guru']),
            'type'    => 'POST'
        ],
        'columns' => [
            [
                'name' => 'name',
                'data' => 'name'
            ],
            [
                'name' => 'aspirasi',
                'data' => 'aspirasi'
            ]
        ]
    ];
@endphp


@section('content')
<div class="row">
	<div class="col-md-12">
		<x-adminlte-card title="Daftar Aspirasi" theme="info">
			<x-adminlte-datatable id="table1" :heads="$heads" head-theme="light" theme="info" :config="$config" striped bordered compressed hoverable with-buttons/>
		</x-adminlte-card>
	</div>
</div>
@stop