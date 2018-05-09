<?php

namespace App\Classes\PMI;

use App\PMI\Period;

class IndexChartDataCreator {
  public function getJSON($isManufacturing) {

    $periods = Period::where([
      "is_manufacturing" => $isManufacturing
    ])->orderBy("name", "asc")->get();

    $data = [];

    foreach($periods as $period) {
      $data[$period->name] = floatval($period->index);
    }

    return json_encode($data);
  }
}
