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
            [ "industry" => "Accommodation & Food Services",                 "isManufacturing" => false ],
            [ "industry" => "Agriculture, Forestry, Fishing & Hunting",      "isManufacturing" => false ],
            [ "industry" => "Apparel, Leather & Allied Products",            "isManufacturing" => true  ],
            [ "industry" => "Arts, Entertainment & Recreation",              "isManufacturing" => false ],
            [ "industry" => "Chemical Products",                             "isManufacturing" => true  ],
            [ "industry" => "Computer & Electronic Products",                "isManufacturing" => true  ],
            [ "industry" => "Construction",                                  "isManufacturing" => false ],
            [ "industry" => "Educational Services",                          "isManufacturing" => false ],
            [ "industry" => "Electrical Equipment, Appliances & Components", "isManufacturing" => true  ],
            [ "industry" => "Fabricated Metal Products",                     "isManufacturing" => true  ],
            [ "industry" => "Finance & Insurance",                           "isManufacturing" => false ],
            [ "industry" => "Food, Beverage & Tobacco Products",             "isManufacturing" => true  ],
            [ "industry" => "Furniture & Related Products",                  "isManufacturing" => true  ],
            [ "industry" => "Health Care & Social Assistance",               "isManufacturing" => false ],
            [ "industry" => "Information",                                   "isManufacturing" => false ],
            [ "industry" => "Textile Mills",                                 "isManufacturing" => true  ],
            [ "industry" => "Transportation Equipment",                      "isManufacturing" => true  ],
            [ "industry" => "Machinery",                                     "isManufacturing" => true  ],
            [ "industry" => "Management of Companies & Support Services",    "isManufacturing" => false ],
            [ "industry" => "Mining",                                        "isManufacturing" => false ],
            [ "industry" => "Miscellaneous Manufacturing",                   "isManufacturing" => true  ],
            [ "industry" => "Nonmetallic Mineral Products",                  "isManufacturing" => true  ],
            [ "industry" => "Other Services",                                "isManufacturing" => false ],
            [ "industry" => "Paper Products",                                "isManufacturing" => true  ],
            [ "industry" => "Petroleum & Coal Products",                     "isManufacturing" => true  ],
            [ "industry" => "Plastics & Rubber Products",                    "isManufacturing" => true  ],
            [ "industry" => "Primary Metals",                                "isManufacturing" => true  ],
            [ "industry" => "Printing & Related Support Activities",         "isManufacturing" => true  ],
            [ "industry" => "Professional, Scientific & Technical Services", "isManufacturing" => false ],
            [ "industry" => "Public Administration",                         "isManufacturing" => false ],
            [ "industry" => "Real Estate, Rental & Leasing",                 "isManufacturing" => false ],
            [ "industry" => "Retail Trade",                                  "isManufacturing" => false ],
            [ "industry" => "Transportation & Warehousing",                  "isManufacturing" => false ],
            [ "industry" => "Utilities",                                     "isManufacturing" => false ],
            [ "industry" => "Wholesale Trade",                               "isManufacturing" => false ],
            [ "industry" => "Wood Products",                                 "isManufacturing" => true  ]
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
