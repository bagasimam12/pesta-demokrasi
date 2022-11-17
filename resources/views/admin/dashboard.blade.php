@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>{{ ConfigVoting::getConfig()->title }}</h1>
@stop

@section('content')

<div class="row">
	<div class="col-md-12">
		<x-adminlte-callout>Howdy {{ Auth::user()->name }} !</x-adminlte-callout>
	</div>

	<div class="col-md-3">
		<x-adminlte-callout theme="info" title="Current Voting">
			<span class="badge badge-pill badge-info">{{ strtoupper(ConfigVoting::getConfig()->voting) }}</span>
		</x-adminlte-callout>
	</div>
	<div class="col-md-3">
		<x-adminlte-callout theme="info" title="Peserta Siswa (+DPK)">
			{{ $siswa }}
		</x-adminlte-callout>
	</div>
	<div class="col-md-3">
		<x-adminlte-callout theme="info" title="Peserta Guru">
			{{ $guru }}
		</x-adminlte-callout>
	</div>
	<div class="col-md-3">
		<x-adminlte-callout theme="info" title="Peserta Dpk (Siswa)">
			{{ $dpk }}
		</x-adminlte-callout>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<x-adminlte-callout theme="info" title="Peserta Golput / Belum">
			{{ $golput }}
		</x-adminlte-callout>
	</div>
	<div class="col-md-3">
		<x-adminlte-callout theme="info" title="Siswa Telah Memilih">
			{{ $vote_siswa }}
		</x-adminlte-callout>
	</div>
	<div class="col-md-3">
		<x-adminlte-callout theme="info" title="Guru Telah Memilih">
			{{ $vote_guru }}
		</x-adminlte-callout>
	</div>
	<div class="col-md-3">
		<x-adminlte-callout theme="info" title="Dpk Telah Memilih">
			{{ $vote_dpk }}
		</x-adminlte-callout>
	</div>
</div>
@endsection