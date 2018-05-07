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
    
    public function comments()
    {
        return $this->hasMany('App\PMI\Comment', 'pmi_comment_id');
    }
}