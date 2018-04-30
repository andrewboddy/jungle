
@extends('layouts.app')


@section('content')
        <h1>Watchitems - Be Patient</h1>

Show charts: {{Request::get('showCharts')}}

        <a href="/watchitems/charts">charts</a>

        <select v-model="panel">
            <option value="Queued for Action">Queued for Action</option>
            <option value="Darvas">Darvas</option>
            <option value="old">old</option>
            <option value="POSITION">POSITION</option>
            <option value="POSITION 2">POSITION 2</option>
            <option value="ex-position">ex-position</option>
            <option value="Macro">Macro</option>
            <option value="Growth Data">Growth Data</option>
            <option value="TICN">TICN</option>
            <option value="All">All</option>
        </select>
        @if(count($watchitems)>0)
        <table class="table table-bordered table-hover table-sm" style="width:90%;">
                <tr>
                    <th style="width:110px;"></th>
                    <th style="width:110px;">Chart</th>
                    <th>Ticker</th>
                    <th>Next<br/>Call</th>
                    <th>Alert</th>
                    <th class="watching">Watching<br/>Since</th>
                    <th class="watching">Change<br/>Since</th>
                    <th class="watching">High<br/>watermark</th>
                    <th class="watching"></th>
                </tr>
                @foreach ($watchitems as $watchitem)
                    @php
                        $days_to_earnings = floor( (strtotime($watchitem->next_earnings_call) - time()) / (60 * 60 * 24) );
                    @endphp
                    <tr v-show="(panel!='{{$watchitem->watchlist}}'||panel=='All')">
                        <!-- td>
                            <div class="container">
                                <div class="checkbox-slider">
                                    <input type="checkbox" id="checkbox"/>
                                    <label for="checkbox" class="slider"/>
                                </div>
                            </div>

                            <a class="btn btn-warning" href="/reset/{{$watchitem->ticker}}">^</a>
                        </td -->
                            <td>***__</td>
                            <td>{{$watchitem->industry}} {{$watchitem->watchlist}}
                                <image src="http://finviz.com/chart.ashx?t={{$watchitem->ticker}}&ty=c&ta=1&p=d&s=l" width="300"/>
                            </td>
                        <td onclick="(this.parentNode.nextElementSibling.style.visibility = (this.parentNode.nextElementSibling.style.visibility=='visible'?'collapse':'visible'))">
                            {{$watchitem->ticker}}
                        </td>
                        <td class="text-right" data-number="{{ $days_to_earnings -7}}"> {{ ($days_to_earnings>21 || $days_to_earnings<0 ?'':$days_to_earnings) }}</td>
                        <td>
                            {{
                            ($watchitem->is_alert_resistance
                            ? ($watchitem->price > $watchitem->alert ? "ALERT" : "")
                            : ($watchitem->price < $watchitem->alert ? "ALERT" : "")
                            )
                            }}
                        </td>
                            <td class="watching"> {{ floor( ( time() - strtotime($watchitem->watching_since_date ) ) / (60 * 60 * 24) )}} days ago</td>                        <td class="text-right watching" data-number="{{ $watchitem->price - $watchitem->watching_since_price }}">
                            {{ round( (($watchitem->price / $watchitem->watching_since_price)-1)*100) }}.%
                        </td>
                        <td class="text-right watching"> {{ round( (($watchitem->high_watermark / $watchitem->watching_since_price)-1)*100) }}.%</td>
                        <td class="watching">
                            <a class="btn btn-warning" href="/reset/{{$watchitem->ticker}}">reset</a>
                        </td>
                    </tr>

                    <tr style="visibility:collapse">
                        <!-- v-show="(panel=='{{$watchitem->watchlist}}'||panel=='All')"> -->
                        <td colspan="7">
                            <textarea cols="150"> notes... Database update(?) </textarea>
                        </td>
                        <td colspan="3">.</td>
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


    <!--script>
        app.append({
            data() {
                timeliness: 10
            }
        })
    </script -->


