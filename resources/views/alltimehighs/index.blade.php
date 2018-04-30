@extends('layouts.app')

@section('content')
        <h1>All Time Highs</h1>

        @if(count($alltimehighs)>0)
        <table class="table table-bordered table-hover table-sm">
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                @foreach ($alltimehighs as $alltimehigh)
                        <tr>
                            {!! Form::open(['action' => ['WatchItemsController@update', $alltimehigh->id], 'method'=>'PUT']) !!}
                            <td> <a href="/stocks/showByTicker/{{$alltimehigh->ticker}}"  data-toggle="tooltip" title="{{$alltimehigh->name}}">{{$alltimehigh->ticker}}</a></td>
                            <td> {{$alltimehigh->industry}}</td>
                            <td> {{$alltimehigh->mkt_cap}}</td>
                            <td> {{$alltimehigh->notes}}</td>
                            <td><img width="140" height="70" src="{{'https://finviz.com/chart.ashx?ty=c&ta=0&p=w&s=l&t=' .$alltimehigh->ticker}}" /></td>
                            <td>
                                {{Form::hidden('id', $alltimehigh->id)}}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                {{Form::submit('save', ['class'=>'btn btn-info'])}}
                            </td>
                            {!! Form::close() !!}
                        </tr>
                @endforeach
        </table>

@else
<p> no watch found
@endif

@endsection

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

