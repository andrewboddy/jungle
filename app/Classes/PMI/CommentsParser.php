<?php

namespace App\Classes\PMI;

use App\Classes\SubtextFetcher;
use App\PMI\Industry;

class CommentsParser {
    
    private $comments;
    private $commentsOfNonExistingIndustries;
    
    public function __construct() {
        $this->comments = [];
        $this->commentsOfNonExistingIndustries = [];
    }
    
    public function getComments() {
        return $this->comments;
    }
    
    public function invalidCommentsExists() {
        return count($this->commentsOfNonExistingIndustries);
    }
    
    public function printInvalidCommentsError() {
        foreach ($this->commentsOfNonExistingIndustries as $commentOfNonExistingIndustry) {
            echo "\nA comment was related to a non-existing industry \""
                 . $commentOfNonExistingIndustry
                 . "\"!";
        }
    }
    
    public function initialize($dataSource, SubtextFetcher $subtextFetcher) {
        
        $subtextFetcher->setStartKey($dataSource["search"]["comments"]["start"]);
        $subtextFetcher->setEndKey($dataSource["search"]["comments"]["end"]);
        $allCommentsText = $subtextFetcher->getSubtext();
        
        preg_match_all(
            '/' . $dataSource["search"]["comments"]["liStart"] . '(.*?)<\/li>/s',
            $allCommentsText,
            $matches
        );
        
        foreach (array_keys($matches[1]) as $key) {
            $this->parseSingleComment($matches[1][$key], $dataSource['isManufacturing']);
        }
    }
    
    private function parseSingleComment($rawComment, $isManufacturing) {
        
        $rawComment = str_replace(
            ["&#8220;", "&#8221;"],
            ['"', '"'],
            $rawComment
        );
            
        preg_match(
            '/"([^"]+)" \((.*?)\)/',
            $rawComment,
            $matches
        );
        
        $industryName = html_entity_decode($matches[2]);
        
        $industries = Industry::where([
            "name" => $industryName,
            "is_manufacturing" => $isManufacturing
        ])->get();
        
        if(count($industries) === 0) {
            $this->commentsOfNonExistingIndustries[] = $industryName;
            return;
        }

        $this->comments[] = [
            "industryId" => $industries[0]->id,
            "comment" => $matches[1]
        ];
    }
}