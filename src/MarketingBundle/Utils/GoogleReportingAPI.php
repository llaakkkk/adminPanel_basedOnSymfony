<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.10.17
 * Time: 17:02
 */

namespace MarketingBundle\Utils;

class GoogleReportingAPI
{
    const API_KEY = 'AIzaSyBMNe-RAOZwkWQ2y1LkhA3bORELRqr58wU';
    const VIEW_ID = 'ga:150662368';

    protected $dateFrom = '7daysAgo';
    protected $dateTo = 'today';

    protected $client;
    protected $analytics;

    public function __construct($dateFrom, $dateTo)
    {

        putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/../Resources/config/ga-key.json');
//        putenv('GOOGLE_APPLICATION_CREDENTIALS=/home/lakie/Desktop/projects/admin_mfp/ga-key.json');

        // Create and configure a new client object.
        $this->client = new \Google_Client();
        $this->client->useApplicationDefaultCredentials();
        $this->client->setDeveloperKey(self::API_KEY);
        $this->client->setApplicationName("cleaner");
        $this->client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $this->analytics = new \Google_Service_AnalyticsReporting($this->client);

        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function getMetricsData($metrics)
    {
        $report = $this->getReport($metrics);
        $report = $this->getReport($metrics);

        return $this->getReportResults($report);
    }

    public function getReport($metrics)
    {


        $VIEW_ID = self::VIEW_ID;

        // create DateRange object
        $dateRange = new \Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($this->dateFrom);
        $dateRange->setEndDate($this->dateTo);

        $metricsToSet = [];
        foreach ($metrics as $metricName => $metricValue) {
            $metric = new \Google_Service_AnalyticsReporting_Metric();
            $metric->setExpression($metricValue);
            $metric->setAlias($metricName);
            $metricsToSet[] = $metric;
        }

        // create ReportRequest object
        $request = new \Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($VIEW_ID);
        $request->setDateRanges($dateRange);
        $request->setMetrics($metricsToSet);

        $body = new \Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests([$request]);

        $response = $this->analytics->reports->batchGet($body);

        return $response;
    }


    public function getReportResults($reports)
    {
        $data = [];

        for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
            $report = $reports[ $reportIndex ];
            $header = $report->getColumnHeader();

            $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
            $rows = $report->getData()->getRows();

            for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
                $row = $rows[ $rowIndex ];
                $metrics = $row->getMetrics();


                for ($j = 0; $j < count($metricHeaders) && $j < count($metrics); $j++) {
                    $values = $metrics[$j];
                    for ($valueIndex = 0; $valueIndex < count($values->getValues()); $valueIndex++) {
                        $entry = $metricHeaders[$valueIndex];
                        $data[$entry->getName()] = $values->getValues()[ $valueIndex ];
                    }
                }
            }
        }

        return $data;
    }

}