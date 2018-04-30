<?php

namespace App\Http\Controllers;

use Request;
use App\Stock;
use App\Industry;
use DB;



class StocksController extends Controller
{
    /*
   $stock = Stock::where('Ticker', 'AAPL')->get();
   $stocks = DB::select('SELECT * from stocks');
   $stocks = Stock::orderBy('Ticker', 'desc')->get();
    $watchitems = DB::table('watch_items')
            ->join('stocks', 'stocks.ticker', '=', 'watch_items.ticker')
            ->select('watch_items.*', 'stocks.sector', 'stocks.industry')
            ->get();
                ->orderby('sector', 'asc')
            ->orderby('industry', 'asc')

       return view ('watchitems.index')->with('watchitems', $watchitems);
*/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $industries = Industry::all();
        return view('stocks.industry')->with('industries', $industries);
    }

    public function industry($industry)
    {
        $industryData = Industry::where('industry', $industry)->get();

        $stocks = Stock::where('Industry', $industry)
            ->orderby('long_x_short', 'desc')
            ->orderby('mkt_cap', 'desc')
            ->get();
        return view('stocks.index', ['stocks'=> $stocks,  'industry'=> $industryData]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stocks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'ticker' => 'required',
            'name' => 'required'
        ]);

        $stock = new Stock;
        $stock->ticker = $request->input('ticker');
        $stock->name = $request->input('name');
        $stock->save();

        return redirect('/stocks')->with('success','Stock Created');
    }

    /**
     Different reports
    */
    public function stocksByGrowth()
    {
        $sql_select = "select * from stocks where growth1 > 20 and growth2 > growth1*0.1 order by growth1 desc";
        $stocks = DB::select($sql_select);
        return view('stocks.byGrowth')->with('stocks', $stocks);
    }

    public function stocksByF1estimates()
    {
        $sql_select = "select * from stocks where change_f1_est_4_weeks > 20 and growth1 > 0 order by change_f1_est_4_weeks desc";
        $stocks = DB::select($sql_select);
        return view('stocks.byGrowth')->with('stocks', $stocks);
    }

    public function stocksBySurprise()
    {
        $sql_select = "select * from stocks where last_eps_surprise > 50 and q0_actual > 0.02 order by last_eps_surprise desc";
        $stocks = DB::select($sql_select);
        return view('stocks.byGrowth')->with('stocks', $stocks);
    }

    public function stocksByQestimates()
    {
        $stocks = [];
        //$sql_select = "select * from stocks where q1_change_4_weeks < -15 and ...  order by q1_change_4_weeks desc";
        $sql_select = "select * from stocks where q1_change_4_weeks >20 AND q1_eps not between -0.03 AND 0.03  order by q1_change_4_weeks desc";
        $stocks = DB::select($sql_select);
        return view('stocks.byGrowth')->with('stocks', $stocks);
    }



    public function stockAddNote()
    {
        $sql_select = "update stocks set notes = '"."TEST"."' where ticker='".$ticker."'";
        $stocks = DB::update($sql_select);
        // return;
//        return  view('stocks.show')->with('stock', $stock);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('stocks.show')->with('stock', $stock);
    }

    public function showByTicker($ticker)
    {
        $stock = Stock::where('ticker', $ticker)->get()[0];
//        echo $stock[0]->id;
  //          return;
    //    $stock = Stock::find($stock->id);
        return  view('stocks.show')->with('stock', $stock);
    }

    /**
    An awkward dense function; but essentially makes sense
    of -ve data and percentages... and then formats as appropriate.
    */
    public function getGrowthPct($EPS1, $EPS2)
    {
        $growth =
            ($EPS1<0 ?
                ($EPS2>0 ?
                    "TURN Profit" :
                    ($EPS2>$EPS1 ?  "BAD to WORSE" : "Improving")
                ):
                (false? "" : round((($EPS2 / $EPS1)-1)*100) ."%"));

        return $growth;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }






    public function setEPSEstimates() {
        //console.log(result)
        $username = "d2cc99a73a37eae9d0f91867638b0619";
        $password = "0876dd72c761de570bbeab0c9d0835a3";

/*      $tickers='';
        "select ticker from stocks where eps_q1=0 limit 15;"
        foreach ($watchitems as $watchitem) {
            $tickers = $tickers . $watchitem->ticker. ',';
        }
        $tickers = substr($tickers, 0,strlen($tickers)-1);
*/
     //   $tickers = "MMM,AXP,AAPL,BA,CAT,CVX,CSCO,KO,DIS,DWDP";
 //       $tickers = "XOM,GE,GS,HD,IBM,INTC,JNJ,JPM,MCD,MRK";
      //  $tickers = "MSFT,NKE,PFE,PG,TRV,UTX,UNH,VZ,V";
        $remote_url = "https://api.intrinio.com/data_point?identifier=$tickers&item=qtr_1_eps_est_mean,qtr_2_eps_est_mean,qtr_3_eps_est_mean,qtr_4_eps_est_mean,qtr_5_eps_est_mean,qtr_6_eps_est_mean,qtr_7_eps_est_mean,qtr_8_eps_est_mean";
        $process = curl_init($remote_url);
        curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', ''));
        curl_setopt($process, CURLOPT_HEADER, 1);
        curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        $content = curl_exec($process);
        curl_close($process);
        $content = substr($content, strpos($content, '{'));
//return $content;

//      $content_data = '[{"identifier":"MMM","item":"qtr_1_eps_est_mean","value":2.0217},{"identifier":"AXP","item":"qtr_1_eps_est_mean","value":1.5373},{"identifier":"AAPL","item":"qtr_1_eps_est_mean","value":3.768},{"identifier":"MMM","item":"qtr_2_eps_est_mean","value":2.38},{"identifier":"AXP","item":"qtr_2_eps_est_mean","value":1.6556},{"identifier":"AAPL","item":"qtr_2_eps_est_mean","value":2.8678},{"identifier":"MMM","item":"qtr_3_eps_est_mean","value":2.48},{"identifier":"AXP","item":"qtr_3_eps_est_mean","value":1.7511},{"identifier":"AAPL","item":"qtr_3_eps_est_mean","value":2.1756},{"identifier":"MMM","item":"qtr_4_eps_est_mean","value":2.685},{"identifier":"AXP","item":"qtr_4_eps_est_mean","value":1.7567},{"identifier":"AAPL","item":"qtr_4_eps_est_mean","value":2.3722},{"identifier":"MMM","item":"qtr_5_eps_est_mean","value":2.36},{"identifier":"AXP","item":"qtr_5_eps_est_mean","value":1.8156},{"identifier":"AAPL","item":"qtr_5_eps_est_mean","value":3.824},{"identifier":"MMM","item":"qtr_6_eps_est_mean","value":2.32},{"identifier":"AXP","item":"qtr_6_eps_est_mean","value":1.735},{"identifier":"AAPL","item":"qtr_6_eps_est_mean","value":2.978},{"identifier":"MMM","item":"qtr_7_eps_est_mean","value":"nm"},{"identifier":"AXP","item":"qtr_7_eps_est_mean","value":1.93},{"identifier":"AAPL","item":"qtr_7_eps_est_mean","value":2.222},{"identifier":"MMM","item":"qtr_8_eps_est_mean","value":"nm"},{"identifier":"AXP","item":"qtr_8_eps_est_mean","value":1.855},{"identifier":"AAPL","item":"qtr_8_eps_est_mean","value":2.526}]'
        $content_data = json_decode($content)->data;

        DB::beginTransaction();
        foreach ($content_data as $datapoint) {
            if ($datapoint->value=='nm') $datapoint->value = 0;
            if ($datapoint->value=='na') $datapoint->value = 0;
            $x = substr($datapoint->item, 4,1);
            DB::table('stocks')
                ->where('ticker', $datapoint->identifier)
                ->update([  'eps_q'.$x => $datapoint->value ]);
        }
        DB::commit();

        return redirect ('/stocks')->with('success', 'Retrieved EPS estimates successfully.');

    }
    /**
        Update Nasdaq Data every month
     */
    public function dataLoadNasdaqData()
    {
        $headers = ['Company Name',  //0
            'Ticker',               //1
            '% Change LT Growth Est. (4 weeks)',    //2
            'F0 Consensus Est.',    //3
            'F1 Consensus Est.',    //4
            'F2 Consensus Est.',    //5
            'P/E (Trailing 12 Months)',    //6
            'P/E (F1)',    //7
            'P/E (F2)',    //8
            'PEG Ratio'	,    //9
            'Div. Yield %',    //10
            'Net Margin',    //11
            '% Change F2 Est. (4 weeks)',    //12
            '% Change F1 Est. (4 weeks)',    //13
            'Exchange',    //14
            'Sector',    //15
            'Month of Fiscal Yr End',    //16
            'Industry',    //17
            'Last EPS Surprise (%)',    //18
            'Previous EPS Surprise (%)',    //19
            'Avg EPS Surprise (Last 4 Qtrs)',    //20
            'Next EPS Report Date',    //21
            'Debt/Total Capital',    //22
            'Market Cap',               //23
            'Last Reported Qtr',    //24
            'Last Qtr EPS',    //25
            'Q0 Consensus Est. (last completed fiscal Qtr)',    //26
            'Q1 Consensus Est.',    //27
            'Q2 Consensus Est. (next fiscal Qtr)',    //28
            '% Change Q0 Est. (4 weeks)',    //29
            '% Change Q1 Est. (4 weeks)',    //30
            '% Change Q2 Est. (4 weeks)',    // 31
            '# of Analysts in Q0 Consensus',    // 32
            '# of Analysts in Q1 Consensus',    // 33
            '# of Analysts in Q2 Consensus'];    // 34
        $x = [];
        $row = 0;
        $foundColumnCheck = 0;
        if (($handle = fopen(storage_path()."/app/public/zacks_custom_screen_2018-04-09.csv", "r")) == FALSE) {
            return redirect ('/stocks')->with('success', 'No file found');
        } else {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                if ($row == 1) {
                    for ($i = 0; $i <= 34; $i++) {
                        foreach ($headers as $key => $columnTitle) {
                            if (trim($data[$i]) == $columnTitle) {
                                $x[$key] = $i;
                                echo $columnTitle."->".$x[$key]."<br/>\n";
                                $foundColumnCheck++;
                                continue;
                            }
                        }
                    }
                    if ($foundColumnCheck != 35) {
                        echo "ERROR-found ".$foundColumnCheck." of 35: <br/>These are the .csv columns found ". print_r($data, true) ."<br/>\n";;
                    }
                    continue;  // with row 2...
                }

                if ($data[$x[14]]=='OTC') continue;
                if ($data[$x[2]] == "") $data[$x[2]]=0;
                if ($data[$x[3]] == "") $data[$x[3]]=0;
                if ($data[$x[4]] == "") $data[$x[4]]=0;
                if ($data[$x[5]] == "") $data[$x[5]]=0;
                if ($data[$x[6]] == "") $data[$x[6]]=0;
                if ($data[$x[7]] == "") $data[$x[7]]=0;
                if ($data[$x[8]] == "") $data[$x[8]]=0;
                if ($data[$x[9]] == "") $data[$x[9]]=0;
                if ($data[$x[10]]== "") $data[$x[10]]=0;
                if ($data[$x[11]]== "") $data[$x[11]]=0;
                if ($data[$x[12]]== "") $data[$x[12]]=0;
                if ($data[$x[13]]== "") $data[$x[13]]=0;
                if ($data[$x[18]]== "") $data[$x[18]]=0;
                if ($data[$x[19]]== "") $data[$x[19]]=0;
                if ($data[$x[20]]== "") $data[$x[20]]=0;
                if ($data[$x[21]]== "") $data[$x[21]]='19700101';
                if ($data[$x[22]]== "") $data[$x[22]]=0;
                $mkt_cap = round(( (int)$data[$x[23]])/1000,0);
                if ($data[$x[24]]== "") $data[$x[24]]='19700101';
                if ($data[$x[25]]== "") $data[$x[25]]=0;
                if ($data[$x[26]]== "") $data[$x[26]]=0;
                if ($data[$x[27]]== "") $data[$x[27]]=0;
                if ($data[$x[28]]== "") $data[$x[28]]=0;
                if ($data[$x[29]]== "") $data[$x[29]]=0;
                if ($data[$x[30]]== "") $data[$x[30]]=0;
                if ($data[$x[31]]== "") $data[$x[31]]=0;
                if ($data[$x[32]]== "") $data[$x[32]]=0;
                if ($data[$x[33]]== "") $data[$x[33]]=0;
                if ($data[$x[34]]== "") $data[$x[34]]=0;

                $sql_update = "update stocks 
                                set updated_at=now()
                                	,pe_ttm= {$data[$x[6]]}
                                	,pe_f1= {$data[$x[7]]}
                                	,pe_f2= {$data[$x[8]]}
                                	,eps_f0={$data[$x[3]]}
                                	,eps_f1= {$data[$x[4]]}
                                	,eps_f2= {$data[$x[5]]}
                                	,peg_ratio= {$data[$x[9]]}
                                	,change_f1_est_4_weeks=round({$data[$x[13]]},0),change_f2_est_4_weeks=round({$data[$x[12]]},0),change_ltg_est_4_weeks= {$data[$x[2]]}
                                	,last_eps_surprise={$data[$x[18]]},prev_eps_surprise= {$data[$x[19]]},avg_eps_surprise_last_4_q={$data[$x[20]]}
                                	,next_earnings_call= {$data[$x[21]]},year_end= {$data[$x[16]]}
                                	,debt_total_capital={$data[$x[22]]},div_yield={$data[$x[10]]},net_margin={$data[$x[11]]}
                                	,mkt_cap ={$mkt_cap} 
                                	,q0_date={$data[$x[24]]}, q0_eps = {$data[$x[26]]}, q0_actual = {$data[$x[25]]},q1_eps = {$data[$x[27]]}, q2_eps = {$data[$x[28]]}
                                	,q0_change_4_weeks = {$data[$x[29]]},q1_change_4_weeks = {$data[$x[30]]},q2_change_4_weeks = {$data[$x[31]]}
                                	,q0_n_analysts = {$data[$x[32]]},q1_n_analysts = {$data[$x[33]]}, q2_n_analysts = {$data[$x[34]]} 
                            	where ticker ='{$data[$x[1]]}';";
                if (DB::update($sql_update) == 0) {

                    $sql_insert = "insert into stocks values (null,null,now(),
                                    '{$data[$x[1]]}','{$data[$x[0]]}','{$data[$x[15]]}','{$data[$x[17]]}',{$mkt_cap},'{$data[$x[14]]}',
                                    {$data[$x[3]]},{$data[$x[4]]},{$data[$x[5]]},{$data[$x[6]]},{$data[$x[7]]},{$data[$x[8]]},
                                    {$data[$x[9]]},{$data[$x[10]]},{$data[$x[11]]},round({$data[$x[13]]},0),round({$data[$x[12]]},0),
                                    {$data[$x[2]]},{$data[$x[18]]},{$data[$x[19]]},{$data[$x[20]]},{$data[$x[21]]},{$data[$x[16]]},{$data[$x[22]]},
                                    0,0,'-',0,0,'long description missing',0,0,0,0,0,0,0,0,{$data[$x[24]]},{$data[$x[26]]},{$data[$x[25]]},{$data[$x[27]]}
                                    ,{$data[$x[28]]},{$data[$x[29]]},{$data[$x[30]]},{$data[$x[31]]},{$data[$x[32]]},{$data[$x[33]]},{$data[$x[34]]}, 'notes', 'logo');";
                    if (DB::insert($sql_insert) == 0) {
                        echo "Failed to update  or insert {$data[$x[1]]} <br/>\n";
                    } else {
                        echo "New Billion$ stock: {$data[$x[1]]} <br/>\n";
                    }
                }

            }
            fclose($handle);

            DB::delete("delete from stocks where updated_at < CURRENT_DATE();");
            echo "Deleted old stocks <br/>\n";

            /** update stocks set growth data
            -10001 = Turn-around
            -10002 = Improving
            -10003 = Bad to Worse
             */
            DB::update("update stocks 
                        set growth1 = IF(eps_f0<=0, IF(eps_f1>0,-10001,IF(eps_f1>eps_f0,-10002, -10003)), round(((eps_f1/eps_f0)-1)*100,0) )
                           ,growth2 = IF(eps_f1<=0, IF(eps_f2>0,-10001,IF(eps_f2>eps_f1,-10002, -10003)), round(((eps_f2/eps_f1)-1)*100,0) )
                           ,long_x_short = SIGN(growth1);");
            echo "Updated stock Growth data <br/>\n";

            // Rebuild industries set growth data
            DB::delete("delete from industries;");
            DB::update("insert into industries (
                       	select null, sector, industry
                       		,round(avg(pe_ttm))
                       		,round(avg(pe_f1))
                       		,round(avg(pe_f2))
                       		,round(avg(eps_f0), 2)
                       		,round(avg(eps_f1), 2)
                       		,round(avg(eps_f2), 2)
                       		,0,0
                       		,0,0
                       		,'no industry notes'
                       	from stocks
                        where long_x_short=1
                        group by sector, industry);");

            DB::update("update industries
                        set g1 = IF(eps0=0 ,0 ,round(((eps1/eps0)-1)*100, 2))
                           ,g2 = IF(eps1=0 ,0 ,round(((eps2/eps1)-1)*100, 2));");

            DB::update("update industries
                        set peg1 = IF(g1=0,0, round( (pe1/g1), 2))
                           ,peg2 = IF(g2=0,0, round( (pe2/g2), 2));");

            echo "Updated industry growth data <br/>\n";

//            return redirect ('/stocks')->with('success', 'updated stock date xx');
        }
    }

    public function setLongDescriptions() {
        //console.log(result)
        $username = "d2cc99a73a37eae9d0f91867638b0619";
        $password = "0876dd72c761de570bbeab0c9d0835a3";

        $results = DB::select("select ticker from stocks where long_description = '' or long_description is null limit 50");
        $tickers = implode (',', $results);   //$tickers = "WDR,WEB,WEC,WEGRY,WEICY,WEN,WERN,WES,WETF,WEX,WF,WFC,WFGPY,WFT,WGL,WGO,WGP,WHR,WIFI,WILYY,WIMHY,WING,WINS,WIRE,WIT,WIX,WJRYY,WK,WLH,WLK,WLL,WLMIY,WLTW,WM,WMB,WMGI,WMK,WMMVY,WMS,WMT,WNC,WNGRF,WNS,WOPEY,WOR,WOW,WPC,WPG,WPM,WPP,WPX,WPZ,WR,WRB,WRD,WRE,WRI,WRK,WRTBY,WSBC,WSFS,WSM,WSO,WSO.B,WST,WTFC,WTKWY,WTM,WTR,WTS,WTTR,WTW,WU,WUBA,WVE,WWD,WWE,WWLNF,WWNTY,WWW,WY,WYGPY,WYN,WYNMF,WYNN,WZENY,X,XBI,XEC,XEL,XENT,XHR,XL,XLB,XLF,XLNX,XLRN,XLU,XLY,XME,XNCR,XNET,XNGSY,XOG,XON,XPER,XPO,XRAY,XRX,XTEPY,XTNY,XYIGF,XYL,Y,YAHOY,YAMHF,YARIY,YASKY,YELP,YERR,YEXT,YNDX,YPF,YRD,YUANF,YUEIY,YUM,YUMC,YXOXY,YY,YZCAY,Z,ZAYO,ZBH,ZBRA,ZEN,ZG,ZGNX,ZION,ZLAB,ZLNDY,ZNGA,ZNH,ZTCOY,ZTO,ZTS,ZURVY";

        $remote_url = "https://api.intrinio.com/data_point?identifier=$tickers&item=long_description";
        $process = curl_init($remote_url);
        curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', ''));
        curl_setopt($process, CURLOPT_HEADER, 1);
        curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        $content = curl_exec($process);
        curl_close($process);
        $content = substr($content, strpos($content, '{'));
        $content_data = json_decode($content)->data;
        //return $content;

        DB::beginTransaction();
        foreach ($content_data as $datapoint) {
            DB::table('stocks')
                ->where('ticker', $datapoint->identifier)
                ->update([  'long_description' => $datapoint->value ]);
        }
        DB::commit();

        return redirect ('/stocks')->with('success', 'Inserted Long Descriptions: '.$tickers);

    }

}
