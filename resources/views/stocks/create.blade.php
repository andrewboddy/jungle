@extends('layouts.app')

@section('content')
    <h1>Create Stock</h1>

    {!! Form::open(['action' => 'StocksController@store', 'method' => 'POST']) !!}
    <div class="form-group">
        {{Form::label('ticker', 'Ticker')}}
        {{Form::text('ticker', '', ['class'=>'form-control', 'placeholder'=>'Ticker ...'])}}
    </div>
    <div class="form-group">
        {{Form::label('name', 'Company Name')}}
        {{Form::text('name', '', ['class'=>'form-control'])}}
    </div>
    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

@endsection