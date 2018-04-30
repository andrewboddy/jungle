<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{

/*    protected $attributes = ['growth'=>'0'];
    protected $appends = ['growth'];

    protected $growth1 = 1;
    protected $growth2 = 2;

    public function setGrowthAttribute()
    {

    }

    public function getGrowthTrendAttribute() {

        return ((int)$this->growth2 > (int)$this->growth1 ? 'GREEN':'RED');
    }

    public function getGrowth1Attribute() {
        $this->growth1 = $this->getGrowth($this->eps_f0, $this->eps_f1);
        return $this->growth1;
    }

    public function getGrowth2Attribute() {
         $this->growth2 = $this->getGrowth($this->eps_f1, $this->eps_f2);
        return $this->growth2;
    }

    public function getGrowth($EPS1, $EPS2) {
        $g =  ($EPS1<0 ?
                ($EPS2>0 ?
                    "TURN Profit" :
                    ($EPS2>$EPS1 ?  "BAD to WORSE" : "Improving")
                ):
                    (false? "" : round((($EPS2 / $EPS1)-1)*100) ."%"));
        return $g;
    }
*/
}
