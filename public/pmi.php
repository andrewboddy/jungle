<?php

$rank =  array();

$industries = ["growth"
	, "Machinery"
	, "Computer &amp; Electronic Products"
	,"Paper Products"
	,"Apparel, Leather &amp; Allied Products"
	,"Printing &amp; Related Support Activities"
	,"Primary Metals"
	,"Nonmetallic Mineral Products"
	,"Petroleum &amp; Coal Products"
	,"Plastics &amp; Rubber Products"
	,"Miscellaneous Manufacturing"
	,"Food, Beverage &amp; Tobacco Products"
	,"Furniture &amp; Related Products"
	,"Transportation Equipment"
	,"Chemical Products"
	,"Fabricated Metal Products"
	,"Electrical Equipment, Appliances &amp; Components"
	,"contraction"
	,"Wood Products"
	,"Textile Mills"
	,"Machinery"];

	$url="https://www.instituteforsupplymanagement.org/ISMReport/MfgROB.cfm";
	//https://www.instituteforsupplymanagement.org/ISMReport/NonMfgROB.cfm
	
	$content = file_get_contents($url);
	$start = strpos($content, '<!-- Paragraph Three -->');
	$end = strpos($content, '<!-- Respondent List Items -->', $start) -2;
	echo "\nCheckpoint: start". $start.", end". $end  ;
	$full_text = substr( $content, $start, $end - $start);
	echo "\n".$full_text;
	


// Match and use a temporary key (the position) for sorting
foreach ($industries as $industry) {
	$rank[strpos($full_text , $industry)] = $industry ;
}
ksort($rank);

// find the contraction point
$break = 0;
foreach ($rank as $r) {
	$break++;
	if ($r == "contraction") {
		break;
	} 
}



        // re-assign the index to numeric descending
        $rank2 = array();
        foreach ($rank as $x) {
            $break--;  // always decrement this value for index counting
            if ($x == 'growth') {
                //do nothing
            } elseif ($x == 'contraction') {
                //do nothing
            } else {
                $rank2[] = ['period'=>'2018-01', 'report'=>'PMI Manufacturing', 'key'=>$x , 'value'=>$break];
            }
        }

        var_dump($rank2);



// to do ; add to database



/*


Manufacturing at a Glance

insert into ism_report values('2018-01', 'man', 'index', '59.7');
insert into ism_report values('2018-01', 'man', '16', 'Machinary', 'Strong international Sales - ...');
insert into ism_report values('2018-01', 'man', '16', 'Machinary', 'Strong international Sales - ...');
insert into ism_report values('2018-01', 'man', '16', 'Machinary', 'Strong international Sales - ...');
insert into ism_report values('2018-01', 'man', '16', 'Machinary', 'Strong international Sales - ...');
insert into ism_report values('2018-01', 'man', '16', 'Machinary', 'Strong international Sales - ...');
insert into ism_report values('2018-01', 'man', '16', 'Machinary', 'Strong international Sales - ...');
insert into ism_report values('2018-01', 'man', '16', 'Machinary', 'Strong international Sales - ...');
insert into ism_report values('2018-01', 'man', '16', 'Machinary', 'Strong international Sales - ...');
insert into ism_report values('2018-01', 'man', '16', 'Machinary', 'Strong international Sales - ...');
insert into ism_report values('2018-01', 'man', '16', 'Machinary', 'Strong international Sales - ...');
insert into ism_report values('2018-01', 'man', '16', 'Machinary', 'Strong international Sales - ...');



ISM_data
yyyy_mm , report, rank, value, notes


//echo print_r($rank);
//echo  array_search("contraction", array_column($rank, );
for ($i = array_search($rank, "contraction") ; $i==0 ; $i--) {
	echo $rank[$i].'-'.$i."\n";
}

$full_text = "Of the 18 manufacturing industries, 16 reported growth in December in the following order: Machinery; Computer & Electronic Products; Paper Products; Apparel, Leather & Allied Products; Printing & Related Support Activities; Primary Metals; Nonmetallic Mineral Products; Petroleum & Coal Products; Plastics & Rubber Products; Miscellaneous Manufacturing; Food, Beverage & Tobacco Products; Furniture & Related Products; Transportation Equipment; Chemical Products; Fabricated Metal Products; and Electrical Equipment, Appliances & Components. Two industries reported contraction during the period: Wood Products; and Textile Mills.";

48 - growth
91 - Machinery
102 - Computer & Electronic Products
134 - Paper Products
150 - Apparel, Leather & Allied Products
186 - Printing & Related Support Activities
225 - Primary Metals
241 - Nonmetallic Mineral Products
271 - Petroleum & Coal Products
298 - Plastics & Rubber Products
326 - Miscellaneous Manufacturing
355 - Food, Beverage & Tobacco Products
390 - Furniture & Related Products
420 - Transportation Equipment
446 - Chemical Products
465 - Fabricated Metal Products
496 - Electrical Equipment, Appliances & Components
567 - contraction
598 - Wood Products
617 - Textile Mills
91 - Machinery
array(0) {*/


?>
