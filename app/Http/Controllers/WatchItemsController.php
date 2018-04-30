<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\WatchItem;
use DB;

//use Illuminate\Support\Facades\File;


class WatchItemsController extends Controller
{

    /** For ALL watched items
     *   {"identifier":"AAPL","item":"last_price","value":175.03}
     */
    public function setRealTimePrices() {
        //console.log(result)
        $watchitems = Watchitem::all();
        $username = "d2cc99a73a37eae9d0f91867638b0619";
        $password = "0876dd72c761de570bbeab0c9d0835a3";

        $tickers='';
        foreach ($watchitems as $watchitem) {
            $tickers = $tickers . $watchitem->ticker. ',';
        }
        $tickers = substr($tickers, 0,strlen($tickers)-1);
        $remote_url = "https://api.intrinio.com/data_point?ticker=$tickers&item=last_price";

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

        foreach ($content_data as $datapoint) {
            DB::table('watch_items')
                ->where('ticker', $datapoint->identifier)
                ->update(['price' => $datapoint->value]);
        }

        return redirect ('/watchitems')->with('success', 'updated live prices');

    }

    /** For ALL watched items
     *   {"identifier":"AAPL","item":"last_price","value":175.03}
     */
    public function setHighWaterMark() {
        $watchitems = Watchitem::all();

        foreach ($watchitems as $watchitem) {
            if ($watchitem->price > $watchitem->high_watermark) {

                DB::table('watch_items')
                    ->where('ticker', $watchitem->ticker)
                    ->update(['high_watermark' => $watchitem->price]);
            }
        }

        return redirect ('/watchitems')->with('success', 'updated live prices');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $watchitems = DB::table('watch_items')
            ->join('stocks', 'stocks.ticker', '=', 'watch_items.ticker')
            ->select('watch_items.*', 'stocks.sector', 'stocks.industry', 'stocks.mkt_cap', 'stocks.next_earnings_call')
            ->get();

        return view ('watchitems.index')->with('watchitems', $watchitems);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('watchitems.create');
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
            'ticker'=>'required',
            'watchlist'=>'required'
        ]);
        $watchitem = new Watchitem;
        $watchitem->ticker = $request->input('ticker');
        $watchitem->watchlist = $request->input('watchlist');
        $watchitem->watching_since_date = date('Y-m-d');
        $watchitem->watching_since_price = 0.01;
        $watchitem->price = 0.01;
        $watchitem->notes = '';
        $watchitem->alert = 0.01;
        $watchitem->is_alert_active = 0;
        $watchitem->is_alert_resistance = 0;
        $watchitem->save();

        return redirect ('/watchitems')->with('success', 'watchitem Added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function reset($ticker)
    {
        $watchitem = (WatchItem::where('ticker', $ticker))->first();
        $watchitem->watching_since_date = date('Y-m-d');
        $watchitem->watching_since_price = $watchitem->price;
        $watchitem->high_watermark = $watchitem->price;
        $watchitem->save();

//        return redirect('/watchitems');

        $watchitems = DB::table('watch_items')
            ->join('stocks', 'stocks.ticker', '=', 'watch_items.ticker')
            ->select('watch_items.*', 'stocks.sector', 'stocks.industry', 'stocks.mkt_cap', 'stocks.next_earnings_call')
            ->get();

        return view('watchitems.index')->with('watchitems', $watchitems);
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

        return "in here 2";

        $watchitem = Watchitem::find(1);
        $watchitem->since_price = $watchitem->price;
        $watchitem->since_date = date('Y-m-d');
        $watchitem->save();

        return redirect ('/stocks');

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
}
