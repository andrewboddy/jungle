<?php

namespace App\Classes\PMI;

class IndustryIndicatorsFetcher {
    
    private $industries;
    
    public function __construct() {
        $this->industries = [];
    }
    
    public function getIndicatorsByPeriods($periods) {
        
        $this->industries = [];
        
        foreach($periods as $period) {
            
            foreach($period->ranks as $rank) {
                
                $industryName = $rank->industry->name;
                
                if(!isset($this->industries[$industryName])) {
                    $this->initializeIndustry($rank->industry);
                    $this->setIndustryComments($rank->industry, $periods);
                }
                
                $this->industries[$industryName]["ranks"][] = $rank->rank;
            }
        }
        
        $this->sortIndustries();
        
        return $this->industries;
    }
    
    private function initializeIndustry($industry) {
        $this->industries[$industry->name] = [
            "ranks" => [],
            "comments" => []
        ];
    }
    
    private function setIndustryComments($industry, $periods) {
        
        $periodIds = [];
        foreach($periods as $period) {
            $periodIds[] = $period->id;
        }
        
        $comments = $industry->comments->whereIn('pmi_period_id', $periodIds);
        
        foreach($comments as $comment) {
           $commentString = $comment->period->name . ": " . $comment->comment;
           $this->industries[$industry->name]["comments"][] = $commentString;
        }
        
        sort($this->industries[$industry->name]["comments"]);
    }
    
    private function sortIndustries() {
        uasort($this->industries, function($a, $b) {
            
            $aLatestRank = $a["ranks"][count($a["ranks"]) - 1];
            $bLatestRank = $b["ranks"][count($b["ranks"]) - 1];
            
            if($aLatestRank > $bLatestRank) {
                return -1;
            }
            
            if($aLatestRank < $bLatestRank) {
                return 1;
            }
            
            return 0;
        });
    }
}
