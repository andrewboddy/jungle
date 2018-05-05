<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use App\PMI\Period;
use App\PMI\Rank;

use App\Classes\SubtextFetcher;
use App\Classes\PMI\RanksArrayGenerator;

class ParsePMIDataToDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'PMI:parseToDatabase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrapes PMI data and saves it to database';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = "https://www.instituteforsupplymanagement.org/ISMReport/MfgROB.cfm"; // Newest
        // $url = "https://www.instituteforsupplymanagement.org/about/MediaRoom/newsreleasedetail.cfm?ItemNumber=31045&SSO=1"; // March
        // $url = "https://www.instituteforsupplymanagement.org/about/MediaRoom/newsreleasedetail.cfm?ItemNumber=31035&SSO=1"; // February 2018
        // $url = "https://www.instituteforsupplymanagement.org/about/MediaRoom/newsreleasedetail.cfm?ItemNumber=31024&SSO=1"; // January 2018
        //https://www.instituteforsupplymanagement.org/ISMReport/NonMfgROB.cfm
        
        $isManufacturing = true;
        
        $subtextFetcher = new SubtextFetcher();
        $subtextFetcher->setSourceText(file_get_contents($url));
        $subtextFetcher->setStartKey('<!-- Paragraph Three -->');
        $subtextFetcher->setEndKey('<!-- Respondent List Items -->');
        $industriesListText = $subtextFetcher->getSubtext();

        $subtextFetcher->setStartKey("ISM -");
        $subtextFetcher->setEndKey(" Manufacturing ISM&reg; Report On Business&reg;");
        $reportRawPeriod = $subtextFetcher->getSubtext();
        $reportPeriodAsArray = explode(' ', $reportRawPeriod);
        $periodName = $this->periodArrayToString($reportPeriodAsArray);
        
        $subtextFetcher->setStartKey("PMI<sup>&#174;</sup> at ");
        $subtextFetcher->setEndKey("%");
        $index = $subtextFetcher->getSubtext();
        
        $ranksArrayGenerator = new RanksArrayGenerator();
        $ranksArrayGenerator->initialize($industriesListText, $isManufacturing);
        
        if($ranksArrayGenerator->industriesFailed()) {
            return $ranksArrayGenerator->printIndustriesNotFoundError();
        }
        
        $ranks = $ranksArrayGenerator->getRanks();
        
        $existingPeriod = $this->getExistingPeriod($periodName, $isManufacturing);
        
        if(count($existingPeriod) > 0) {
            echo "The period {$periodName} already exists!\n";
            return;
        }
        
        $period = $this->createPeriod($periodName, $index, $isManufacturing);
        $this->createRankEntities($ranks, $period->id);
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
