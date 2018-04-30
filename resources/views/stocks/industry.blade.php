@extends('layouts.app')

@section('content')
        <h1>Industries</h1>

        @if(count($industries)>0)
        <table class="table table-bordered table-hover table-sm"  style="font-family: 'Courier New'";>
            <tr class="header" >
                <th style="width:200px" >Sector</th>
                <th>Industry</th>
                <th>PE 2016</th>
                <th>PE 2017</th>
                <th>PE 2018</th>
                <th>EPS 2016</th>
                <th>EPS 2017</th>
                <th>EPS 2018</th>
                <th>Growth1</th>
                <th>Growth2</th>
                <th>PEG 1</th>
                <th>PEG 2</th>
            </tr>
            @foreach ($industries as $industry)
                <tr>
                    <td>{{$industry->sector}}</td>
                    <td><a href="/stocks/industry/{{$industry->industry}}">{{$industry->industry}}</a> </td>
                    <td>{{$industry->pe0}}</td>
                    <td>{{$industry->pe1}}</td>
                    <td>{{$industry->pe2}}</td>
                    <td>{{$industry->eps0}}</td>
                    <td>{{$industry->eps1}}</td>
                    <td>{{$industry->eps2}}</td>
                    <td>{{$industry->g1}}</td>
                    <td>{{$industry->g2}}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </table>
        @else
        <p> no industries found
        @endif

@endsection

