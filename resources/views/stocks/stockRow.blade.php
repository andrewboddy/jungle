<tr data-long_x_short="{{$stock->long_x_short}}">
    <td style="width:600px" onclick="(this.parentNode.nextElementSibling.style.visibility = (this.parentNode.nextElementSibling.style.visibility=='visible'?'collapse':'visible'))">
        <a href="/stocks/{{$stock->id}}">{{$stock->ticker}}</a>
    </td>
    <td><a href="stocks/industry/{{($stock->industry)}}">{{$stock->name}}</a></td>
    <td> <span style="color:silver;font-size:xx-large;"> {{round($stock->mkt_cap)}}</span></td>
    <td class="pe text-right" data-number="{{$stock->pe_f2}}"> (?) </td>
    <td class="pe text-right" data-number="{{$stock->pe_ttm}}"> {{round($stock->pe_ttm)}}</td>
    <td class="pe text-right" data-number="{{$stock->pe_f1}}"> {{round($stock->pe_f1)}}</td>
    <td class="pe text-right" data-number="{{$stock->pe_f2}}"> {{round($stock->pe_f2)}}</td>
    <td class="eps text-right" data-number="{{$stock->eps_f2}}"> (?) </td>
    <td class="eps text-right" data-number="{{$stock->eps_f0}}"> {{$stock->eps_f0}}</td>
    <td class="eps text-right" data-number="{{$stock->eps_f1}}"> {{$stock->eps_f1}}</td>
    <td class="eps text-right" data-number="{{$stock->eps_f2}}"> {{$stock->eps_f2}}</td>

    <td class="text-right" data-number="{{$stock->growth1}}"> {{($stock->growth1==-10001?'Turn-around':($stock->growth1==-10002?'Improving':$stock->growth1.'%' ))}}</td>
    <td class="text-right"data-number="{{$stock->growth2}}"> {{$stock->growth2}}%</td>
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
    <td colspan="3">
        <image src="http://finviz.com/chart.ashx?t={{$stock->ticker}}&ty=c&ta=1&p=d&s=l" width="300"/>
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
                            <pre>
Net Margin: {{$stock->net_margin*100}}%
Debt/Capital: {{round($stock->debt_total_capital)}} %
Div.Yield: {{round($stock->div_yield)}} %
∆ Long Term Growth: {{$stock->change_ltg_est_4_weeks }}
                                Next Call: {{date( 'Y-m-d',strtotime($stock->next_earnings_call))}}
                                Year End: {{$stock->year_end}}
                            </pre>
        <image src="http://www.nasdaq.com/charts/{{$stock->ticker}}_smallcnb.jpeg" />
    </td>
    <td>.
    </td>
    <td>.
    </td>
    <td>
        <br/>
        {{($stock->avg_eps_surprise_last_4_q>0?'+':'') . round($stock->avg_eps_surprise_last_4_q)}}%<br/>
        {{($stock->prev_eps_surprise>0?'+':'') . round($stock->prev_eps_surprise)}}%<br/>
        <br/>
        <b>
            {{$stock->q0_date}}<br/>
        </b>{{$stock->q0_eps}}<b><br/>
            ∆{{$stock->q0_change_4_weeks}}%<br/>
            <br/>
            {{($stock->last_eps_surprise>0?'+':'') . round($stock->last_eps_surprise)}}% {{$stock->q0_actual}}<br/>
        </b>



    </td>
    <td class="text-right">
        ∆{{round($stock->change_f1_est_4_weeks)}}% <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        ∆{{$stock->q1_change_4_weeks}}% {{$stock->q1_eps}}<br/>
        ∆{{$stock->q2_change_4_weeks}}% {{$stock->q2_eps}}<br/>
        <span style="color:red;">{{$stock->eps_f1 - ($stock->q1_eps + $stock->q2_eps)}}</span><br/>
        <br/>
        {{$stock->q0_n_analysts}}/{{$stock->q1_n_analysts}}/{{$stock->q2_n_analysts}}<br/>
    </td>
    <td>∆{{round($stock->change_f2_est_4_weeks)}}%</td>
    <td colspan="6">
        {{$stock->long_description}}
    </td>
</tr>
