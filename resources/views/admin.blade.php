@extends('layouts.app')
@section('content')

<div class="content">
    <h1>Administration</h1>
    <div>
        <a style="width: 200px !important;" class="btn btn-warning" href="setRealTimePrices">Update Watchlist prices</a> Do this daily. </br></br>
        <a style="width: 200px !important;" class="btn btn-info" href="setLongDescriptions">set long descriptions</a> select to check first </br></br>
        <a style="width: 200px !important;" class="btn btn-primary" href="">More admin tasks</a></br></br>
        <a style="width: 200px !important;" class="btn btn-success" href="">Report - All time highs</a></br></br>
        <a style="width: 200px !important;" class="btn btn-danger" href="dataLoadNasdaqData">Load data </a> from /storage/Zacks_custom_screen_2018_03_13</br></br>

    </div>
</div>


@endsection

