<?php

namespace App\Classes\PMI;

use Illuminate\Support\Facades\DB;

use App\Classes\PMI\LocationBasedRanks;

class RanksArrayGenerator {
    
    private $ranks;
    private $industriesNotFound;
    
    public function __construct() {
        $this->ranks = [];
        $this->industriesNotFound = [];
    }
    
    public function industriesFailed() {
        return count($this->industriesNotFound) > 0;
    }
    
    public function printIndustriesNotFoundError() {
        foreach($this->industriesNotFound as $industryNotFound) {
            echo "The industry {$industryNotFound} does not exist!\n";
        }
    }
    
    public function getRanks() {
        return $this->ranks;
    }
    
    public function initialize($industriesListText, $isManufacturing) {
        
        $locationBasedRanks = new LocationBasedRanks();
        $locationBasedRanks->initialize($industriesListText, $isManufacturing);
        $this->ranks = $locationBasedRanks->getRanks();
        $zeroRanks = $locationBasedRanks->getZeroRankIndustries();
        
        $this->indexRanksWithDistanceFromContraction();
        $this->replaceRankIndustryNamesWithIndustryIds($zeroRanks);
    }
    
    private function indexRanksWithDistanceFromContraction() {
        
        $tempRanks = $this->ranks;
        $this->ranks = [];
        
        foreach ($tempRanks as $rank => $industryName) {
            
            if ($industryName === 'contraction') {
                continue;
            }
            
            $distanceFromContraction = ($rank - array_search('contraction', $tempRanks)) * (-1);
            
            if($distanceFromContraction > 0) {
                $this->ranks[$distanceFromContraction] = $industryName;
                continue;
            }
            
            $distanceFromEnd = count($tempRanks) - $rank;
            
            $this->ranks[$distanceFromEnd * (-1)] = $industryName;
        }
    }
    
    private function replaceRankIndustryNamesWithIndustryIds($zeroRanks) {
        
        $tempRanks = $this->ranks;
        $this->ranks = [];
        
        foreach($tempRanks as $rank => $industryName) {
            $this->addRankWithIndustryId($rank, $industryName);
        }
        
        foreach($zeroRanks as $industryName) {
            $this->addRankWithIndustryId(0, $industryName);
        }
    }
    
    private function addRankWithIndustryId($rank, $industryName) {
        
        $industry = DB::table('pmi_industries')
        ->where('name', html_entity_decode($industryName))
        ->get();
            
        if(count($industry) === 0) {
            $this->industriesNotFound[] = $industryName;
            return;
        }

        $this->ranks[] = [
            "rank" => $rank,
            "industryId" => $industry[0]->id
        ];
    }
}
