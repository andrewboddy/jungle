@extends('layouts.app')

@section('content')
        <h1>Create</h1>


        @if(count($watchitems)>0)
        <table class="table table-bordered table-hover table-sm">
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                @foreach ($watchitems as $watchitem)
                        <tr>
                            <td> {{$watchitem->ticker}}</td>
                            <td> {{$watchitem->sector}}</td>
                            <td>
                                {{
                                ($watchitem->is_alert_resistance
                                ? ($watchitem->price > $watchitem->alert ? "ALERT" : "")
                                : ($watchitem->price < $watchitem->alert ? "ALERT" : "")
                                )
                                }}
                            </td>
                            <td> {{$watchitem->watching_since_date }}</td>
                            <td data-number="{{ $watchitem->price - $watchitem->watching_since_price }}">
                                {{ round( (($watchitem->price / $watchitem->watching_since_price)-1)*100) }}.%
                            </td>
                            <td> {{$watchitem->notes}}</td>
                            <td><img width="100" height="50" src="{{'https://finviz.com/chart.ashx?ty=c&ta=0&p=w&s=l&t=' .$watchitem->ticker}}" /></td>

                            <td>
                                <a class="btn btn-warning" href="/reset/{{$watchitem->ticker}}">reset</a>
                            </td>
                        </tr>
    @endforeach
</table>
        <a class="btn btn-warning" href="setRealTimePrices">Update Prices</a>
        <a class="btn btn-primary" href="create">Add</a>

@else
<p> no watch found
@endif

@endsection

