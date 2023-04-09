<?php

namespace App\Solid\V3;

use App\Solid\V3\Interfaces\PostReportInterface;

class PdfExport implements PostReportInterface
{
    public function export($data)
    {
        return $data;
    }
}