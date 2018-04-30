<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Indicator;
use \stdClass;

class IndicatorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $month = array();
        $month[0] = date('Ym', time());
        $month[-1] = date('Ym',strtotime("-1 month"));
        $month[-2] = date('Ym',strtotime("-2 month"));
        $month[-3] = date('Ym',strtotime("-3 month"));
        $month[-4] = date('Ym',strtotime("-4 month"));
        $month[-5] = date('Ym',strtotime("-5 month"));

        $rows = [];
//        $rows[] = (object) array('a'=>'Y-m', 'b'=>$month_5, 'c'=>$month_4, 'd'=>$month_3, 'e'=>$month_2, 'f'=>$month_1, 'g'=>$month_0, 'h'=>'');

        /*
         *
+----+---------+-------------------+---------------------------------------------------+-------+-------+
| id | period  | report            | key                                               | value | notes |
+----+---------+-------------------+---------------------------------------------------+-------+-------+
|  1 | 2018-01 | PMI Manufacturing | Machinery                                         | 16    |       |
|  2 | 2018-01 | PMI Manufacturing | Computer &amp; Electronic Products                | 15    |       |
|  3 | 2018-01 | PMI Manufacturing | Paper Products                                    | 14    |       |
|  4 | 2018-01 | PMI Manufacturing | Apparel, Leather &amp; Allied Products            | 13    |       |
|  5 | 2018-01 | PMI Manufacturing | Printing &amp; Related Support Activities         | 12    |       |
|  6 | 2018-01 | PMI Manufacturing | Primary Metals                                    | 11    |       |
|  7 | 2018-01 | PMI Manufacturing | Nonmetallic Mineral Products                      | 10    |       |
|  8 | 2018-01 | PMI Manufacturing | Petroleum &amp; Coal Products                     | 9     |       |
|  9 | 2018-01 | PMI Manufacturing | Plastics &amp; Rubber Products                    | 8     |       |
| 10 | 2018-01 | PMI Manufacturing | Miscellaneous Manufacturing                       | 7     |       |
| 11 | 2018-01 | PMI Manufacturing | Food, Beverage &amp; Tobacco Products             | 6     |       |
| 12 | 2018-01 | PMI Manufacturing | Furniture &amp; Related Products                  | 5     |       |
| 13 | 2018-01 | PMI Manufacturing | Transportation Equipment                          | 4     |       |
| 14 | 2018-01 | PMI Manufacturing | Chemical Products                                 | 3     |       |
| 15 | 2018-01 | PMI Manufacturing | Fabricated Metal Products                         | 2     |       |
| 16 | 2018-01 | PMI Manufacturing | Electrical Equipment, Appliances &amp; Components | 1     |       |
| 17 | 2018-01 | PMI Manufacturing | Wood Products                                     | -1    |       |
| 18 | 2018-01 | PMI Manufacturing | Textile Mills                                     | -2    |       |
| 19 | 2018-01 | PMI Manufacturing | INDEX                                             | 59.7  |       |
+----+---------+-------------------+---------------------------------------------------+-------+-------+*/
        $indicators = Indicator::all();
        $array = array();
        foreach ($indicators as $indicator) {
            $month = 'm'.$indicator->period;
            if ($month == 'm201708')  {
                $array[$indicator->key][$month] = $indicator->key;
            }
            $array[$indicator->key][$month] = $indicator->value;
        }

        print_r( $array);
      //  ["Machinery"]=> array(2) { [0]=> array(1) { ["m201801"]=> string(2) "16" } [1]=> array(1) { ["m201802"]=> int(17) } }
        return view('indicators.index')->with('indicators', $array);
    }

/*

        //var_dump( $rows);
//        print_r($rows);
//      $rows[] = (object) array('key'=>'INDEX', 'm201708'=>'54.3', 'm201709'=>'55.1', 'm201710'=>'61.1', 'm201711'=>'60.2', 'm201712'=>'57.9' ,'m201801'=>'59.1', 'h'=>'');
        $rows[] = (object) array('key'=>'INDEX', '2017-08'=>'54.3', '2017-09'=>'55.1', '2017-10'=>'61.1', '2017-11'=>'60.2', '2017-12'=>'57.9' ,'2018-01'=>'59.1', 'h'=>'');
        $rows[] = (object) array('a'=>'Manufacturing', 'b'=>'14', 'c'=>'8', 'd'=>'10', 'e'=>'12', 'f'=>'15' ,'g'=>'16','h'=>'Storms');
        $rows[] = (object) array('a'=>'Primary Metals', 'b'=>'14', 'c'=>'8', 'd'=>'13', 'e'=>'12', 'f'=>'15' ,'g'=>'15', 'h'=>'Low inventory');
*/
        //return view('indicators.index')->with('indicators', $rows);


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }




    public function setPMIMan() {
        $rank = array();

        $industries = ["growth", "Machinery", "Computer &amp; Electronic Products", "Paper Products", "Apparel, Leather &amp; Allied Products"
        , "Printing &amp; Related Support Activities", "Primary Metals", "Nonmetallic Mineral Products", "Petroleum &amp; Coal Products"
        , "Plastics &amp; Rubber Products", "Miscellaneous Manufacturing", "Food, Beverage &amp; Tobacco Products", "Furniture &amp; Related Products"
        , "Transportation Equipment", "Chemical Products", "Fabricated Metal Products", "Electrical Equipment, Appliances &amp; Components"
        , "contraction", "Wood Products", "Textile Mills", "Machinery"];

        $url = "https://www.instituteforsupplymanagement.org/ISMReport/MfgROB.cfm";
            //https://www.instituteforsupplymanagement.org/ISMReport/NonMfgROB.cfm

        $content = file_get_contents($url);
        $start = strpos($content, '<!-- Paragraph Three -->');
        $end = strpos($content, '<!-- Respondent List Items -->', $start) -2;
 //       echo "\nCheckpoint: start". $start.", end". $end;
        $full_text = substr($content, $start, $end - $start);
//        echo "\n".$full_text;

        // Match and use a temporary key (the position) for sorting
        foreach ($industries as $industry) {
          $rank[strpos($full_text, $industry)] = $industry;
        }

        ksort($rank);

        // find where 'contraction' is in the list and use this for the relative rankings +ve and -ve
        $break = 0;
        foreach ($rank as $r) {
            $break++;
            if ($r == "contraction") {
                break;
            }
        }
        // re-assign the index to numeric descending
        $rank2 = array();
        $this_month = date('Y-m', time());
        foreach ($rank as $x) {
            $break--;  // always decrement this value for index counting
            if ($x == 'growth') {
                //do nothing
            } elseif ($x == 'contraction') {
                //do nothing
            } else {
                $rank2[] = ['period'=>$this_month, 'report'=>'PMI Manufacturing', 'key'=>$x , 'value'=>$break, 'notes'=>''];
            }
        }

        // finally include the headline index for this month
        $rank2[] = ['period'=>$this_month, 'report'=>'PMI Manufacturing', 'key'=>'INDEX' , 'value'=>59.7, 'notes'=>''];

        DB::table('indicators')->insert ($rank2);
        return view('indicators.index');

//        var_dump($rank2);
//        insert into ism_report values('2018-01', 'man', 'index', '59.7');
    }


}
