@extends('layouts.app')
@section('content')

<div class="content">

    <table>
        <tr>
            <th>Ticker</th>
            <th>Last Date</th>
            <th>Freq'</th>
            <th>Notes</th>
        </tr>
        <tr>
            <td>ARCO</td>
            <td>2017-11-22</td>
            <td><img src='https://finviz.com/chart.ashx?ty=c&ta=0&p=d&s=l&t=ARCO' /></td>
            <td>Lumpy rise, waiting for next move.</td>
        </tr>
    </table>


</div>


@endsection

