<?php

namespace App\Classes;

class SubtextFetcher {
    
    private $sourceText;
    private $startKey;
    private $endKey;
    
    public function setSourceText($sourceText) {
        $this->sourceText = $sourceText;
    }
    
    public function setStartKey($key) {
        $this->startKey = $key;
    }
    
    public function setEndKey($key) {
        $this->endKey = $key;
    }
    
    public function getSubtext() {
        $start = strpos($this->sourceText, $this->startKey) + mb_strlen($this->startKey);
        $end = strpos($this->sourceText, $this->endKey, $start);
        return substr($this->sourceText, $start, $end - $start);
    }
}