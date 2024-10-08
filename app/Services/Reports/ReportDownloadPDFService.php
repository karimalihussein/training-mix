<?php

declare(strict_types=1);

namespace App\Services\Reports;

use App\Interfaces\ReportDownloadServiceInterface;

class ReportDownloadPDFService implements ReportDownloadServiceInterface
{
    public function download($report)
    {
        // to be implemented - download as CSV
        // $report = public_path("reports/$report.csv");
        // return response()->download($report);
        return "you're successfully downloaded $report.pdf";
    }
}
