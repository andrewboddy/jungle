<?php

namespace App\PMI;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    public $timestamps = false;
    
    protected $table = 'pmi_periods';
    
    protected $fillable = [
        'id', 'name', 'index', 'is_manufacturing'
    ];
    
    public function ranks()
    {
        return $this->hasMany('App\PMI\Rank', 'pmi_period_id');
    }
}