@extends('adminlte::page')

@section('title', 'Laporan - Voting Mpk')

@section('content_header')
<h1>Voting Mpk</h1>
@stop

@section('plugins.Chartjs', true)

@section('content')
<div class="row">
    <div class="col-md-12">
        <x-adminlte-card title="Gravik Data" theme="info" theme-mode="outline" collapsible>
            <canvas id="gravikVotingKetua"></canvas>
        </x-adminlte-card>
    </div>
    <div class="col-md-12">
        <x-adminlte-card title="Gravik Data" theme="info" theme-mode="outline" collapsible>
            <canvas id="gravikVotingWakil"></canvas>
        </x-adminlte-card>
    </div>
</div>
@stop

@push('js')

<script>
    $(document).ready(function(){
        const ketua = document.getElementById('gravikVotingKetua').getContext('2d');
        const Gcket = new Chart(ketua, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($ketua as $k)
                    "{!! $k->kandidat !!}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Perolehan Suara',
                    data: [
                        @foreach($ketua as $k)
                        {{ $k->suara }},
                        @endforeach
                    ],
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return value;
                            }
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Gravik Perolehan Suara Kandidat Ketua MPK'
                    },
                    subtitle: {
                        display: true,
                        text: '{{ strtoupper(config("voting.title")) }} - {{ strtoupper(config("voting.title_prefix")) }}'
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ' : ' + context.raw;
                            }
                        }
                    }
                }
            }
        });

        const wakil = document.getElementById('gravikVotingWakil').getContext('2d');
        const Gcwak = new Chart(wakil, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($wakil as $k)
                    "{!! $k->kandidat !!}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Perolehan Suara',
                    data: [
                        @foreach($wakil as $k)
                        {{ $k->suara }},
                        @endforeach
                    ],
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return value;
                            }
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Gravik Perolehan Suara Kandidat Wakil MPK'
                    },
                    subtitle: {
                        display: true,
                        text: '{{ strtoupper(config("voting.title")) }} - {{ strtoupper(config("voting.title_prefix")) }}'
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ' : ' + context.raw;
                            }
                        }
                    }
                }
            }
        });
    });
</script>

@endpush