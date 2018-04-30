@extends('layouts.app')
@section('content')


    <div class="content">

    <!-- Show a different view for-->
    <table ng-hide="message != 'Growth'">
        <tr>
            <th>Ticker</td>
            <th class="FY">2016</th>
            <th>2017 Q1</th>
            <th>2017 Q2</th>
            <th>2017 Q3</th>
            <th class="thisQ">2017 Q4</th>
            <th class="FY" colspan=2>2017</th>
            <th>2018 Q1</th>
            <th class="FY" colspan=2>2018</th>

            <th>Growth <br/> in 2017</th>
            <th>Growth <br/> in 2018</th>
            <th> </th>

            <th>Growth <br/> THIS Q</th>
            <th>Growth <br/> NEXT Q</th>

        </tr>
        <tr id="growthTable" ng-repeat="x in growthStocks">
            <td class="text">{{ x.ticker }} </td>
            <td class="actual, FY">{{ x.EPS_2016FY_ACTUAL}} </td>
            <td class="actual">{{ x.EPS_2017Q1_ACTUAL}} </td>
            <td class="actual">{{ x.EPS_2017Q2_ACTUAL}} </td>
            <td class="actual">{{ x.EPS_2017Q3_ACTUAL}} <span class="est">({{ formatDollars(x.EPS_2017Q3_ACTUAL - x.EPS_2017Q3_est) }})</span> </td>
            <td class="est, thisQ">{{ x.EPS_2017Q4_est}} </td>
            <td class="est, FY">{{ x.EPS_2017FY_est}} </td>
            <td class="est, FY">( {{ x.EPS_2017FY_est_adj}}% ) </td>
            <td class="est">{{ x.EPS_2018Q1_est}} </td>
            <td class="est, FY">{{ x.EPS_2018FY_est}}</td>
            <td class="est, FY"> ( {{x.EPS_2018FY_est_adj}}% ) </td>

            <td class="posneg">{{ formatGrowthPct( x.EPS_2016FY_ACTUAL, x.EPS_2017FY_est) }} </td>
            <td class="posneg">{{ formatGrowthPct( x.EPS_2017FY_est, x.EPS_2018FY_est) }} </td>
            <td class="{{ growthSummary( x.EPS_2016FY_ACTUAL, x.EPS_2017FY_est,x.EPS_2018FY_est) }}"></td>


            <td class="posneg">{{ formatGrowthPct( x.EPS_2017Q3_ACTUAL, x.EPS_2017Q4_est) }} </td>
            <td class="posneg">{{ formatGrowthPct( x.EPS_2017Q4_est, x.EPS_2018Q1_est) }} </td>
        </tr>
    </table>





</div>


@endsection

