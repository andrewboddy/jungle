<?php

namespace App\Classes\PMI;

use Illuminate\Support\Facades\DB;

use App\PMI\Period;
use App\PMI\Rank;
use App\PMI\Comment;

use App\Classes\SubtextFetcher;
use App\Classes\PMI\RanksArrayGenerator;
use App\Classes\PMI\CommentsParser;

class PMIDataToDatabaseParser {
    
    private $subtextFetcher;
    
    public function __construct() {
        $this->subtextFetcher = new SubtextFetcher();
    }
    
    public function parseRanksToDatabase($dataSource) {
        
        $industriesListText = $this->getIndustriesListText($dataSource);
        $periodName = $this->getPeriodName($dataSource);
        $index = $this->getIndex($dataSource);
        
        $commentsParser = new CommentsParser();
        $commentsParser->initialize($dataSource, $this->subtextFetcher);
        
        if($commentsParser->invalidCommentsExists()) {
            return $commentsParser->printInvalidCommentsError();
        }
        
        $ranksArrayGenerator = new RanksArrayGenerator();
        $ranksArrayGenerator->initialize($industriesListText, $dataSource["isManufacturing"]);
        
        if($ranksArrayGenerator->industriesFailed()) {
            return $ranksArrayGenerator->printIndustriesNotFoundError();
        }
        
        $ranks = $ranksArrayGenerator->getRanks();
        
        $existingPeriod = $this->getExistingPeriod($periodName, $dataSource["isManufacturing"]);
        
        if(count($existingPeriod) > 0) {
            echo "The period {$periodName} already exists!\n";
            return;
        }
        
        $period = $this->createPeriod($periodName, $index, $dataSource["isManufacturing"]);
        $this->createRankEntities($ranks, $period->id);
        $this->createComments($commentsParser->getComments(), $period->id);
    }
    
    private function getIndustriesListText($dataSource) {
        $this->subtextFetcher->setSourceText(file_get_contents($dataSource["url"]));
        $this->subtextFetcher->setStartKey($dataSource["search"]["industriesList"]["start"]);
        $this->subtextFetcher->setEndKey($dataSource["search"]["industriesList"]["end"]);
        return $this->subtextFetcher->getSubtext();
    }
    
    private function getPeriodName($dataSource) {
        $this->subtextFetcher->setStartKey($dataSource["search"]["reportPeriod"]["start"]);
        $this->subtextFetcher->setEndKey($dataSource["search"]["reportPeriod"]["end"]);
        $reportRawPeriod = $this->subtextFetcher->getSubtext();
        $reportPeriodAsArray = explode(' ', $reportRawPeriod);
        return $this->periodArrayToString($reportPeriodAsArray);
    }
    
    private function getIndex($dataSource) {
        $this->subtextFetcher->setStartKey($dataSource["search"]["index"]["start"]);
        $this->subtextFetcher->setEndKey($dataSource["search"]["index"]["end"]);
        return $this->subtextFetcher->getSubtext();
    }
    
    private function createPeriod($periodName, $index, $isManufacturing) {
        $period = new Period;
        $period->name = $periodName;
        $period->index = $index;
        $period->is_manufacturing = $isManufacturing;
        $period->save();
        return $period;
    }
    
    private function createRankEntities($ranks, $periodId) {
        foreach($ranks as $rank) {
            $rankEntity = new Rank;
            $rankEntity->rank = $rank["rank"];
            $rankEntity->pmi_industry_id = $rank["industryId"];
            $rankEntity->pmi_period_id = $periodId;
            $rankEntity->save();
        }
    }
    
    private function createComments($comments, $periodId) {
        foreach($comments as $comment) {
            $commentEntity = new Comment;
            $commentEntity->pmi_industry_id = $comment["industryId"];
            $commentEntity->pmi_period_id = $periodId;
            $commentEntity->comment = $comment["comment"];
            $commentEntity->save();
        }
    }
    
    private function periodArrayToString($periodArray) {
        
        $monthAsTwoDigitNumber = str_pad(
            date_parse($periodArray[count($periodArray) - 2])["month"],
            2,
            "0",
            STR_PAD_LEFT
        );
        
        return $periodArray[count($periodArray) - 1]
             . "-"
             . $monthAsTwoDigitNumber;
    }
    
    private function getExistingPeriod($periodName, $isManufacturing) {
        return DB::table(
            'pmi_periods'
        )->where([
            'name' => $periodName,
            'is_manufacturing' => $isManufacturing
        ])->get();
    }
}
