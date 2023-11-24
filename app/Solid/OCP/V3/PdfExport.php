<?php

declare(strict_types=1);

namespace App\Solid\OCP\V3;

use App\Solid\OCP\V3\Interfaces\PostReportInterface;

class PdfExport implements PostReportInterface
{
    public function export($data)
    {
        return $data;
    }
}
