@extends('layouts.app')

@section('content')
        <h1>Watchitems</h1>


        @if(count($watchitems)>0)
        <table class="table table-bordered table-hover table-sm">
                <tr>
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
                            <td> {{$watchitem->notes}}</td>
                            <td><img width="300" height="150" src="{{'https://finviz.com/chart.ashx?ty=c&ta=0&p=w&s=l&t=' .$watchitem->ticker}}" /></td>

                            <td>
                                <a class="btn btn-warning" href="/reset/{{$watchitem->ticker}}">reset</a>
                            </td>
                        </tr>
    @endforeach
</table>
        <a class="btn btn-warning" href="setRealTimePrices">Update Prices</a>

        <a class="btn btn-primary" id="more" onclick="$('div.details').slideToggle(200);">Add</a>

        <div class="details" style="display:none">
              <h1>Create</h1>
            {!! Form::open(['action' => 'WatchItemsController@store', 'method'=>'POST']) !!}
            <div class="form-group">
                {{Form::label('ticker','Ticker')}}
                {{Form::text('ticker','', ['class'=>'form-control', 'placeholder'=>'ticker'])}}
            </div>
            <div class="form-group">
                {{Form::label('watchlist','watchlist')}}
                {{Form::text('watchlist','', ['class'=>'form-control', 'placeholder'=>'tag to group items'])}}
            </div>
            {!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>

@else
<p> no watch found
@endif

@endsection

