<?php

namespace App\Services\Reports;

class ReportDownloadService
{
    public function downloadReport($report, $format = 'html')
    {
        // Bad way - if statement for every possible format
        //        if ($format == 'pdf') {
        //            return $this->downloadAsPDF($report);
        //        }
        //        if ($format == 'csv') {
        //            return $this->downloadAsCSV($report);
        //        }
        //        if ($format == 'xls') {
        //            return $this->downloadAsXLS($report);
        //        }
        //        if ($format == 'json') {
        //            return $this->downloadAsJSON($report);
        //        }

        // Better way: add more formats in the future without modifying this class
        $className = 'App\Services\Reports\ReportDownload'.strtoupper($format).'Service';
        if (class_exists($className)) {
            return (new $className)->download($report);
        }

        return response()->json(['error' => 'Download format not found'], 404);

    }

    private function downloadAsPdf($report)
    {
        // To be implemented
        return 'Coming soon: PDF for download';
    }

    private function downloadAsCSV($report)
    {
        // To be implemented
        return 'Coming soon: CSV for download';
    }

    private function downloadAsXLS($report)
    {
        // To be implemented
        return 'Coming soon: XLS for download';
    }

    private function downloadAsJSON($report)
    {
        // To be implemented
        return 'Coming soon: XLS for download';
    }
}
