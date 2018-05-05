<?php

namespace App\Classes\PMI;

use App\PMI\Industry;

class LocationBasedRanks {
    
    private $ranks;
    private $zeroRankIndustries;
    private $mainContractionKey;
    private $contractionKeys;
    
    public function __construct() {
        $this->ranks = [];
        $this->zeroRankIndustries = [];
        $this->mainContractionKey = 'contraction';
        $this->contractionKeys = ['contraction', 'decrease'];
    }
    
    public function getRanks() {
        return $this->ranks;
    }
    
    public function getZeroRankIndustries() {
        return $this->zeroRankIndustries;
    }
    
    public function initialize($industriesListText, $isManufacturing) {
        
        $industries = Industry::where('is_manufacturing', $isManufacturing)->get();
        
        foreach ($industries as $industry) {
            $this->initializeIndustryRanks($industry, $industriesListText);
        }
        
        $this->addContractionRankBasedOnText($industriesListText);
        ksort($this->ranks);
        $this->removeStrposBasedArrayKeysFromRanks();
        $this->addContractionRankToEndIfMissing();
    }
    
    private function initializeIndustryRanks($industry, $industriesListText) {
        
        $industryName = htmlentities($industry->name);
            
        $locationInString = strpos($industriesListText, $industryName);

        if($locationInString === false) {
            $this->zeroRankIndustries[] = $industryName;
            return;
        }

        $this->ranks[$locationInString] = $industryName;
    }
    
    private function removeStrposBasedArrayKeysFromRanks() {
        $this->ranks = array_values($this->ranks);
    }
    
    private function addContractionRankBasedOnText($industriesListText) {
        foreach($this->contractionKeys as $contractionKey) {
            if (strpos($industriesListText, $contractionKey) !== false) {
                $this->ranks[strpos($industriesListText, $contractionKey)] = $this->mainContractionKey;
                break;
            }
        }
    }
    
    private function addContractionRankToEndIfMissing() {
        if (array_search($this->mainContractionKey, $this->ranks) === false) {
            $this->ranks[] = $this->mainContractionKey;
        }
    }
}
