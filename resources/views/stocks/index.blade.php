@extends('layouts.app')

@section('content')
        <h1>Stocks Tree</h1>


        <button class="btn btn-info" href="/stocklist">Sort by Growth</button>
        <span>
            <image src="http://finviz.com/chart.ashx?t=XHB&ty=c&ta=1&p=d&s=l" width="300"/>
        </span>
        <span>
            <image src="http://finviz.com/chart.ashx?t=XHB&ty=c&ta=1&p=d&s=l" width="300"/>
        </span>



        @if(count($stocks)>0)
        <table class="table table-bordered table-hover table-sm" style="font-family: 'Courier New';">
                <tr>
                    <th colspan="3">{{$industry[0]->industry}}</th>
                    <th class="pe text-right">{{$industry[0]->pe0}}</th>
                    <th class="pe text-right">{{$industry[0]->pe1}}</th>
                    <th class="pe text-right">{{$industry[0]->pe2}}</th>
                    <th class="eps text-right">{{$industry[0]->eps0}}</th>
                    <th class="eps text-right">{{$industry[0]->eps1}}</th>
                    <th class="eps text-right">{{$industry[0]->eps2}}</th>
                    <th class="text-right">{{$industry[0]->g1}}%</th>
                    <th class="text-right">{{$industry[0]->g2}}%</th>
                    <th></th>
                    <th class="text-right">1.2</th>
                    <th>1.4</th>
                    <th></th>
                </tr>
                <tr class="header" >
                    <th>Ticker</th>
                    <th>Name</th>
                    <th>Mkt.Cap.</th>
                    <th>PE<br/> 2016</th>
                    <th>PE<br/> 2017</th>
                    <th>PE<br/> 2018</th>
                    <th>EPS 2016</th>
                    <th>EPS 2017</th>
                    <th>EPS 2018</th>
                    <th>Growth1</th>
                    <th>Growth2</th>
                    <th>Growth Story</th>
                    <th>PEG 1</th>
                    <th>PEG 2</th>
                    <th>Long x Short</th>
                </tr>
                @foreach ($stocks as $stock)
                    <tr data-long_x_short="{{$stock->long_x_short}}">
                        <td style="width:600px" onclick="(this.parentNode.nextElementSibling.style.visibility = (this.parentNode.nextElementSibling.style.visibility=='visible'?'collapse':'visible'))">
                            <a href="/stocks/{{$stock->id}}">{{$stock->ticker}}</a>
                        </td>
                        <td><a > {{$stock->name}}</a></td>
                        <td> {{round($stock->mkt_cap)}}</td>
                        <td class="pe text-right" data-number="{{$stock->pe_ttm - $industry[0]->pe0 }}"> {{round($stock->pe_ttm)}}</td>
                        <td class="pe text-right" data-number="{{$stock->pe_f1 - $industry[0]->pe1 }}"> {{round($stock->pe_f1)}}</td>
                        <td class="pe text-right" data-number="{{$stock->pe_f2 - $industry[0]->pe2 }}"> {{round($stock->pe_f2)}}</td>
                        <td class="eps text-right" data-number="{{$stock->eps_f0}}"> {{$stock->eps_f0}}</td>
                        <td class="eps text-right" data-number="{{$stock->eps_f1}}"> {{$stock->eps_f1}}</td>
                        <td class="eps text-right" data-number="{{$stock->eps_f2}}"> {{$stock->eps_f2}}</td>
                        <td class="text-right" data-number="{{$stock->growth1}}"> {{round($stock->growth1,0)}}%</td>
                        <td class="text-right"data-number="{{$stock->growth2}}"> {{round($stock->growth2,0)}}%</td>
                        <td> {{$stock->growth_story}}</td>
                        <td> </td>
                        <td> </td>
                        <td>
                            <input type="radio" name="options{{$stock->ticker}}" id="option1" value="1" {{($stock->long_x_short==1?'checked':'')}}/>
                            <input type="radio" name="options{{$stock->ticker}}" id="option2" value="0" {{($stock->long_x_short==0?'checked':'')}}/>
                            <input type="radio" name="options{{$stock->ticker}}" id="option1" value="-1" {{($stock->long_x_short==-1?'checked':'')}}/>
                        </td>
                        <!--td><img src="{'https://finviz.com/chart.ashx?ty=c&ta=0&p=w&s=l&t=' .$stock->ticker}}" /></td -->
                    </tr>
                    <tr style="visibility:collapse">
                        <td colspan="3"><image src="http://finviz.com/chart.ashx?t={{$stock->ticker}}&ty=c&ta=1&p=d&s=l" width="300"/></td>
                        <td colspan="3">
                            <pre>
Net Margin: {{$stock->net_margin*100}}%
Debt/Capital: {{round($stock->debt_total_capital)}} %
∆ Long Term Growth: {{$stock->change_ltg_est_4_weeks }}
Next Call: {{date( 'Y-m-d',strtotime($stock->next_earnings_call))}}
Year End: {{$stock->year_end}}
                            </pre>
                        </td>
                        <td>{{$stock->long_description}}</td>
                        <td class="text-right">
                            ∆{{$stock->change_f1_est_4_weeks}} <br/>
                            {{($stock->prev_eps_surprise>0?'+':'') . round($stock->prev_eps_surprise)}}%<br/>
                            {{($stock->last_eps_surprise>0?'+':'') . round($stock->last_eps_surprise)}}%<br/>
                            {{($stock->avg_eps_surprise_last_4_q>0?'+':'') . round($stock->avg_eps_surprise_last_4_q)}}%
                        </td>
                        <td>∆{{$stock->change_f2_est_4_weeks}}</td>
                        <td colspan="3">
                            <ul class="sparklist">
                                <span class="sparkline">
                                      <span class="index"><span class="count" style="background: #A53F2B; height: 27%;">(60,</span> </span>
                                      <span class="index"><span class="count" style="background: #A53F2B; height: 97%;">220,</span> </span>
                                      <span class="index"><span class="count" style="background: #A53F2B; height: 62%;">140,</span> </span>
                                      <span class="index"><span class="count" style="height: 35%;">80,</span> </span>
                                      <span class="index"><span class="count" style="height: 62%;">140,</span> </span>
                                      <span class="index"><span class="count" style="height: 35%;">80,</span> </span>
                                      <span class="index"><span class="count" style="height: 40%;">140,</span> </span>
                                      <span class="index"><span class="count" style="background: #dadada; height: 45%;">160,</span> </span>
                                      <span class="index"><span class="count" style="background: #dadada; height: 50%;">180,</span> </span>
                                      <span class="index"><span class="count" style="background: #dadada; height: 62%;">140,</span> </span>
                                      <span class="index"><span class="count" style="background: #dadada; height: 70%;">110)</span> </span>
                                </span>
                            </ul>



                        </td>
                        <td colspan="3">
                            <image src="http://www.nasdaq.com/charts/{{$stock->ticker}}_smallcnb.jpeg" />
                        </td>
                    </tr>
                @endforeach
        </table>

@else
<p> no stocks found
@endif

@endsection

