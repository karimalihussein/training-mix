<?php

namespace App\Solid\OCP\V3;

use App\Solid\OCP\V3\Interfaces\PostReportInterface;

class HtmlExport implements PostReportInterface
{
    public function export($data)
    {
        return view('posts.report', compact('data'));
    }
}
