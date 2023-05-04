<?php

namespace App\Services\Reports;

use App\Interfaces\ReportDownloadServiceInterface;

class ReportDownloadCSVService implements ReportDownloadServiceInterface
{
    public function download($report)
    {
        // to be implemented - download as CSV
        // $report = public_path("reports/$report.csv");
        // return response()->download($report);
        return "you're successfully downloaded $report.csv";
    }
}
