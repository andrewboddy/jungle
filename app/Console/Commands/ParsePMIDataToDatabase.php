<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Classes\PMI\PMIDataToDatabaseParser;

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
        echo "Starting PMI data scraping...";

        $dataSources = [
            [
                "url" => "https://www.instituteforsupplymanagement.org/ISMReport/MfgROB.cfm", // Newest
                // "url" => "https://www.instituteforsupplymanagement.org/about/MediaRoom/newsreleasedetail.cfm?ItemNumber=31045&SSO=1", // March
                // "url" => "https://www.instituteforsupplymanagement.org/about/MediaRoom/newsreleasedetail.cfm?ItemNumber=31035&SSO=1", // February 2018
                // "url" => "https://www.instituteforsupplymanagement.org/about/MediaRoom/newsreleasedetail.cfm?ItemNumber=31024&SSO=1", // January 2018
                "isManufacturing" => true,
                "search" => [
                    "industriesList" => [
                        "start" => "<!-- Paragraph Three -->",
                        "end" => "<!-- Respondent List Items -->"
                    ],
                    "reportPeriod" => [
                        "start" => "ISM -",
                        "end" => " Manufacturing ISM&reg; Report On Business&reg;"
                    ],
                    "index" => [
                        "start" => "PMI<sup>&#174;</sup> at ",
                        "end" => "%"
                    ],
                    "comments" => [
                        "start" => "<!-- Respondent List Items -->",
                        "end" => "<h3 class=\"text-center text-strong text-uppercase\">Manufacturing at a Glance",
                        "liStart" => "<li class=\"list-group-item\">"
                    ]
                ]
            ],
            [
                "url" => "https://www.instituteforsupplymanagement.org/ISMReport/NonMfgROB.cfm", // Newest
                // "url" => "https://www.instituteforsupplymanagement.org/about/MediaRoom/newsreleasedetail.cfm?ItemNumber=31046&SSO=1", // March
                // "url" => "https://www.instituteforsupplymanagement.org/about/MediaRoom/newsreleasedetail.cfm?ItemNumber=31036&SSO=1", // February
                // "url" => "https://www.instituteforsupplymanagement.org/about/MediaRoom/newsreleasedetail.cfm?ItemNumber=31025&SSO=1", // January
                "isManufacturing" => false,
                "search" => [
                    "industriesList" => [
                        "start" => "<h4>INDUSTRY PERFORMANCE</h4>",
                        "end" => "<h3>WHAT RESPONDENTS ARE SAYING</h3>"
                    ],
                    "reportPeriod" => [
                        "start" => "ISM -",
                        "end" => " Non-Manufacturing ISM&reg; Report On Business&reg;"
                    ],
                    "index" => [
                        "start" => "NMI<sup>&#174;</sup> at ",
                        "end" => "%"
                    ],
                    "comments" => [
                        "start" => "WHAT RESPONDENTS ARE SAYING",
                        "end" => "NON-MANUFACTURING SURVEY RESULTS AT A GLANCE",
                        "liStart" => "<li>"
                    ]
                ]
            ]
        ];

        $PMIDataToDatabaseParser = new PMIDataToDatabaseParser();

        foreach($dataSources as $dataSource) {
            $PMIDataToDatabaseParser->parseRanksToDatabase($dataSource);
        }

        echo "PMI data scraping done!";
    }
}
