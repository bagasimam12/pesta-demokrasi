@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Pengaturan / Tools</h1>
@stop

@section('content')
<div class="row">
	<div class="col-md-6">
		<form method="post" action="{{ route('admin.change.token') }}" id="form-change-token">
			@csrf
			<x-adminlte-card title="Ganti Akses Token Peserta" theme="primary" theme-mode="outline" icon="fas fa-lg fa-lock" collapsible>
				<x-adminlte-input name="uuid" type="text" placeholder="UUID" required />
				<x-adminlte-input name="token" type="text" minlength="6" maxlength="6" placeholder="NEW TOKEN" required/>
				<x-adminlte-button onclick="event.preventDefault(); if(confirm('Konfirmasi penggantian token user?')){ document.getElementById('form-change-token').submit() }" type="submit" class="d-flex ml-auto" theme="info" label="submit" icon="fas fa-sign-in"/>
			</x-adminlte-card>
		</form>
	</div>

	<div class="col-md-6">
		<form method="post" action="{{ route('admin.config.voting') }}" id="form-change-voting">
			@csrf
			<x-adminlte-card title="Ganti Mode Pemilihan" theme="primary" theme-mode="outline" icon="fas fa-lg fa-cog" collapsible>
				@php
				$current = ConfigVoting::getConfig()->voting;
				$change  = $current === 'osis' ? 'mpk' : 'osis';
				@endphp
				<x-adminlte-input name="mode" value="{{ strtoupper($current) }} -> {{ strtoupper($change) }}" placeholder="UUID" disabled />
					<x-adminlte-button onclick="event.preventDefault(); if(confirm('Konfirmasi penggantian mode voting?')){ document.getElementById('form-change-voting').submit() }" type="submit" class="d-flex ml-auto" theme="info" label="submit" icon="fas fa-sign-in"/>
				</x-adminlte-card>
			</form>
		</div>
	</div>
</div>

@endsection