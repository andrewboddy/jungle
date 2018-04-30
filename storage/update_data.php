<?php
/**
    Update Nasdaq Data every month

 */

$row = 1;
if (($handle = fopen("/storage/zacks_custom_screen_2018-03-13.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;

        if ($data[15]=='OTC') {
            continue;
        }
        mkt_cap = round($data[24]/1000,0);
        $sql = "update stocks set updated_at=now(),mkt_cap ={$mkt_cap}, exchange={$data[15]},eps_f0={$data[4]},eps_f1= {$data[5]},eps_f2= {$data[6]},pe_ttm= {$data[7]},pe_f1= {$data[8]},pe_f2= {$data[9]},peg_ratio= {$data[10]},div_yield={$data[11]},net_margin={$data[12]},change_f1_est_4_weeks={$data[13]},change_f2_est_4_weeks= {$data[14]},change_ltg_est_4_weeks= {$data[3]}, last_eps_surprise={$data[19]},prev_eps_surprise= {$data[20]},avg_eps_surprise_last_4_q={$data[21]},next_earnings_call= {$data[22]},year_end= {$data[17]},debt_total_capital={$data[23]} where ticker ={$data[2]};";
// OR        $sql = "insert into stocks values (null,null,now(),'{$data[2]}','{$data[1]}','{$data[16]}','{$data[18]}',{$mkt_cap},{$data[15]},{$data[4]},{$data[5]},{$data[6]},{$data[7]},{$data[8},{$data[9]},{$data[10]},{$data[11]},{$data[12]},{$data[13]},{$data[14]},{$data[3]},{$data[19]},{$data[20]},{$data[21]},{$data[22]},{$data[17]},{$data[23]},null,null,null,null,null,null,null,null,null,null,null,null,null,null);";


    }
    fclose($handle);
}
// delete old
delete from stocks where updated_at < today(now());


// update stocks set growth data
update stocks set long_x_short = SIGN(growth1);


// update industries set growth data
update industries set eps0 = round(avg(eps_f0),2)
select  round(avg(eps_f0),2),round(avg(eps_f1),2), round(avg(eps_f2),2)
from stocks
group by sector, industry, long_x_short;

update industries
	set g1 = round((eps_f1/eps_f0)-1, 2)
	   ,g2 = round((eps_f2/eps_f1)-1, 2)
	   ,peg1 = round( (pe_f1/growth1), 2)
	   ,peg2 = round( (pe_f2/growth2), 2);




?>
