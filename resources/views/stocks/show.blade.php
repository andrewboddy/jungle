@extends('layouts.app')

@section('content')

        <table class="table table-bordered table-hover table-sm" style="font-family: 'Courier New';">
            <tr class="header" >
                <th>Ticker</th>
                <th>Name</th>
                <th>Mkt.Cap.</th>
                <th>PE<br/> 2016</th>
                <th>PE<br/> 2017</th>
                <th>PE<br/> 2018</th>
                <th>PE<br/> 2019</th>
                <th>__EPS_2016_</th>
                <th>__EPS_2017_</th>
                <th>__EPS_2018_</th>
                <th>__EPS_2019_</th>
                <th>Growth1</th>
                <th>Growth2</th>
                <th>Growth Story</th>
                <th>PEG 1</th>
                <th>PEG 2</th>
                <th>Long x Short</th>
            </tr>

            @include('stocks.stockRow')



        </table>




    <a href="/stocks" class="Btn Btn-default">Back</a>

    <h1>{{$stock->ticker}}, {{$stock->name}}</h1>
    <li>{{round($stock->mkt_cap) ."B$"}}</li>
    <li>{{$stock->sector}}</li>
    <li>{{$stock->industry}}</li>
    <li>{{$stock->exchange}}</li>
    <li>{{round($stock->debt_total_capital,2)."%"}}</li>

@endsection


