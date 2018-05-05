<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\PMI\Industry;

class PopulatePmiIndustries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $pmiIndustries = [
            [ "industry" => "Apparel, Leather & Allied Products",            "isManufacturing" => true ],
            [ "industry" => "Chemical Products",                             "isManufacturing" => true ],
            [ "industry" => "Computer & Electronic Products",                "isManufacturing" => true ],
            [ "industry" => "Electrical Equipment, Appliances & Components", "isManufacturing" => true ],
            [ "industry" => "Fabricated Metal Products",                     "isManufacturing" => true ],
            [ "industry" => "Food, Beverage & Tobacco Products",             "isManufacturing" => true ],
            [ "industry" => "Furniture & Related Products",                  "isManufacturing" => true ],
            [ "industry" => "Textile Mills",                                 "isManufacturing" => true ],
            [ "industry" => "Transportation Equipment",                      "isManufacturing" => true ],
            [ "industry" => "Machinery",                                     "isManufacturing" => true ],
            [ "industry" => "Miscellaneous Manufacturing",                   "isManufacturing" => true ],
            [ "industry" => "Nonmetallic Mineral Products",                  "isManufacturing" => true ],
            [ "industry" => "Paper Products",                                "isManufacturing" => true ],
            [ "industry" => "Petroleum & Coal Products",                     "isManufacturing" => true ],
            [ "industry" => "Plastics & Rubber Products",                    "isManufacturing" => true ],
            [ "industry" => "Primary Metals",                                "isManufacturing" => true ],
            [ "industry" => "Printing & Related Support Activities",         "isManufacturing" => true ],
            [ "industry" => "Wood Products",                                 "isManufacturing" => true ]
        ];
        
        foreach($pmiIndustries as $pmiIndustry) {
            $industry = new Industry;
            $industry->name = $pmiIndustry["industry"];
            $industry->is_manufacturing = $pmiIndustry["isManufacturing"];
            $industry->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Industry::getQuery()->delete();
    }
}
