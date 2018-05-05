<?php

namespace App\PMI;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    public $timestamps = false;
    
    protected $table = 'pmi_industries';
    
    protected $fillable = [
        'id', 'name', 'is_manufacturing'
    ];
    
    public function ranks()
    {
        return $this->hasMany('App\PMI\Rank', 'pmi_industry_id');
    }
}