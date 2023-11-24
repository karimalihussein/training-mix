<?php

declare(strict_types=1);

namespace App\Interfaces;

interface ReportDownloadServiceInterface
{
    public function download($report);
}
