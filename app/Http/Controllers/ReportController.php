<?php

namespace App\Http\Controllers;

use App\Services\Reports\ReportDownloadService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(ReportDownloadService $reportDownloadService)
    {
        $this->reportDownloadService = $reportDownloadService;
    }
    public function download(){

        $report = "report";
        return $this->reportDownloadService->downloadReport($report, "karim");

    }
}
