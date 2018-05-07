<?php

namespace App\PMI;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;
    
    protected $table = 'pmi_comments';
    
    protected $fillable = [
        'id', 'pmi_industry_id', 'pmi_period_id', 'comment'
    ];
    
    public function industry()
    {
        return $this->belongsTo('App\PMI\Industry', 'pmi_industry_id', 'id');
    }
    
    public function period()
    {
        return $this->belongsTo('App\PMI\Period', 'pmi_period_id', 'id');
    }
}