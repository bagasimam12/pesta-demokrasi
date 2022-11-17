@extends('adminlte::page')

@section('title', 'Laporan - Voting Osis')

@section('content_header')
<h1>Voting Osis</h1>
@stop

@section('plugins.Chartjs', true)

@section('content')
<div class="row">
    <div class="col-md-12">
        <x-adminlte-card title="Gravik Data" theme="info" theme-mode="outline" collapsible>
            <canvas id="gravikVoting"></canvas>
        </x-adminlte-card>
    </div>
</div>
@stop

@push('js')

<script>
    $(document).ready(function(){
        const canvas = document.getElementById('gravikVoting').getContext('2d');
        const Gchart = new Chart(canvas, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($data as $k)
                    "{!! $k->ketua . ' & ' . $k->wakil !!}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Perolehan Suara',
                    data: [
                        @foreach($data as $k)
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
                        text: 'Gravik Perolehan Suara Kandidat OSIS'
                    },
                    subtitle: {
                        display: true,
                        text: '{{ strtoupper(config("voting.title")) }} - {{ config("voting.title_prefix") }}'
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