@extends('layouts.app')

@section('content')

    <script src="https://code.highcharts.com/highcharts.js"></script>

    <h1>Macro Indicators</h1>

    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    @foreach ($indicators as $key => $indicator)
    <br/><br/><br/><br/>
    <table class="heatmap-table">
        <tr>
            <th class="h2">{{$indicator['name']}}</th>
            @foreach ($indicator['periods'] as $period)
                <th class="vertical-text">{{$period->name}}</th>
            @endforeach
            <th></th>
        </tr>
        <tr class="h4 strong">
            <td> - </td>
            @foreach ($indicator['periods'] as $period)
                <td>{{$period->index}}</td>
            @endforeach
        </tr>
        @foreach ($indicator['industryIndicators'] as $report => $ranksAndComments)
            <tr>
                <td width="330px">{{$report}}</td>
                @foreach ($ranksAndComments["ranks"] as $rank)
                    <td class="heatmap{{$rank}}">{{$rank}}</td>
                @endforeach
                <td>
                    @if (count($ranksAndComments["comments"]) > 1)
                        <div class="display-comments-button">[Comments]</div>
                        <div class="industry-comments-modal">
                            <div class="industry-comments-modal-content">
                                <span class="close">&times;</span>
                                <h3>Comments</h3>
                                <h5>{{$indicator['name']}} / {{$report}}</h5>
                                @foreach (array_reverse($ranksAndComments["comments"]) as $comment)
                                    <p>{{$comment}}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

    <br/><br/>

    <div id="index-chart-container-{{$key}}"></div>

    <script type="text/javascript">

        window.addEventListener("load",function(event) {

            var data = JSON.parse('<?php echo $indicator["indexChartData"]; ?>');

            var chart = new Highcharts.Chart({
                chart: {
                    defaultSeriesType: 'line',
                    renderTo: 'index-chart-container-{{$key}}'
                },
                title: {
                    text: '{{$indicator["name"]}} Index'
                },
                xAxis: {
                    categories: Object.keys(data),
                    title: {
                        text: 'Period'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Index'
                    }
                },
                series: [{
                    name: 'Index',
                    data: Object.values(data),
                }]
            });
        });
    </script>

    @endforeach

    <br/>

    <script type="text/javascript">

        var initializeCloseModalButton = function(modal) {
            var closeButton = modal.querySelector('.close');
            closeButton.addEventListener('click', function (event) {
                modal.style.display = 'none';
                var body = document.querySelector('body');
                body.style.height = 'auto';
                body.style.overflow = 'auto';
            });
        };

        window.addEventListener('load', function() {
            var displayCommentsButtons = document.querySelectorAll('.display-comments-button');
            for(var i = 0; i < displayCommentsButtons.length; ++i) {
                displayCommentsButtons[i].addEventListener('click', function (event) {
                    event.preventDefault();
                    var modal = this.parentNode.querySelector('.industry-comments-modal');
                    modal.style.display = 'block';
                    var body = document.querySelector('body');
                    body.style.height = '100%';
                    body.style.overflow = 'hidden';
                    initializeCloseModalButton(modal);
                });
            }
        });
    </script>

@endsection
