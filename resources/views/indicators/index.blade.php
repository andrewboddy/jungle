@extends('layouts.app')

@section('content')

        <h1>Macro Indicators</h1>

        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <br/><br/><br/><br/><br/>
        <table>
            <tr>
                <th class="h2">ISM PMI Manufacturing</th>
                @foreach ($periods as $period)
                    <th class="vertical-text">{{$period->name}}</th>
                @endforeach
            </tr>
            <tr class="h4 strong">
                <td> - </td>
                @foreach ($periods as $period)
                    <td>{{$period->index}}</td>
                @endforeach
            </tr>
            @foreach ($indicators as $report => $monthlyRanks)
                <tr>
                    <td width="330px">{{$report}}</td>
                    @foreach ($monthlyRanks as $rank)
                        <td class="heatmap{{$rank}}">{{$rank}}</td>
                    @endforeach
                </tr>
            @endforeach
        </table>
        
        <br/><br/><br/><br/><br/>
        <table>
            <tr>
                <th class="h2">ISM PMI Manufacturing design</th>
                <th class="vertical-text">2017-04</th>
                <th class="vertical-text">2017-05</th>
                <th class="vertical-text">2017-06</th>
                <th class="vertical-text">2017-07</th>
                <th class="vertical-text">2017-08</th>
                <th class="vertical-text">2017-09</th>
                <th class="vertical-text">2017-10</th>
                <th class="vertical-text">2017-11</th>
                <th class="vertical-text">2017-12</th>
                <th class="vertical-text">2018-01</th>
                <th class="vertical-text">2018-02</th>
                <th class="vertical-text">2018-03</th>
            </tr>
            <tr class="h4 strong">
                <td> - </td>
                <td>52.2</td>
                <td>52.2</td>
                <td>52.2</td>
                <td>52.2</td>
                <td>52.2</td>
                <td>52.2</td>
                <td>52.2</td>
                <td>52.2</td>
                <td>57.2</td>
                <td>58.2</td>
                <td>52.1</td>
                <td>56.9</td>
            </tr>
            <tr>
                <td width="330px">Fabricated Metal Products</td>
                <td class="heatmap11">11</td>
                <td class="heatmap2">2</td>
                <td class="heatmap4">4</td>
                <td class="heatmap12">12</td>
                <td class="heatmap11">11</td>
                <td class="heatmap10">10</td>
                <td class="heatmap7">7</td>
                <td class="heatmap8">8</td>
                <td class="heatmap9">9</td>
                <td class="heatmap6">6</td>
                <td class="heatmap15">15</td>
                <td class="heatmap16">16</td>
            </tr>
            <tr>
                <td>Machinery</td>
                <td class="heatmap7">7</td>
                <td class="heatmap8">8</td>
                <td class="heatmap9">9</td>
                <td class="heatmap6">6</td>
                <td class="heatmap11">11</td>
                <td class="heatmap2">2</td>
                <td class="heatmap4">4</td>
                <td class="heatmap12">12</td>
                <td class="heatmap11">11</td>
                <td class="heatmap10">10</td>
                <td class="heatmap15">15</td>
                <td class="heatmap16">16</td>
            </tr>
            <tr>
                <td>Transportation Equipment</td>
                <td class="heatmap4">4</td>
                <td class="heatmap12">12</td>
                <td class="heatmap11">11</td>
                <td class="heatmap10">10</td>
                <td class="heatmap11">11</td>
                <td class="heatmap2">2</td>
                <td class="heatmap7">7</td>
                <td class="heatmap8">8</td>
                <td class="heatmap6">6</td>
                <td class="heatmap15">15</td>
                <td class="heatmap16">16</td>
                <td class="heatmap9">9</td>
            </tr>
            <tr>
                <td>.</td>
                <td colspan="12" class="alert-info">
                    2018-01: Lower inventories suggest higher than expected demand <br/>
                    2018-02: Storm damage has affected down stream demand; expected upturn towards end of quarter <br/>
                    2018-03: Labour skills shortage affecting delivery times
                </td>
            </tr>
            <tr>
                <td>Paper Products</td>
                <td class="heatmap9">9</td>
                <td class="heatmap6">6</td>
                <td class="heatmap11">11</td>
                <td class="heatmap2">2</td>
                <td class="heatmap4">4</td>
                <td class="heatmap12">12</td>
                <td class="heatmap15">15</td>
                <td class="heatmap16">16</td>
                <td class="heatmap11">11</td>
                <td class="heatmap10">10</td>
                <td class="heatmap7">7</td>
                <td class="heatmap8">8</td>
            </tr>
            <tr>
                <td> ... </td>
            </tr>
        </table>

        <br/><br/><br/><br/><br/>
        <table>
            <tr>
                <th class="h2">ISM PMI Services</th>
                <th class="vertical-text">2017-04</th>
                <th class="vertical-text">2017-05</th>
                <th class="vertical-text">2017-06</th>
                <th class="vertical-text">2017-07</th>
                <th class="vertical-text">2017-08</th>
                <th class="vertical-text">2017-09</th>
                <th class="vertical-text">2017-10</th>
                <th class="vertical-text">2017-11</th>
                <th class="vertical-text">2017-12</th>
                <th class="vertical-text">2018-01</th>
                <th class="vertical-text">2018-02</th>
                <th class="vertical-text">2018-03</th>
            </tr>
            <tr>
                <td>Same table as above but for services   ...</td>
            </tr>
        </table>


@endsection

