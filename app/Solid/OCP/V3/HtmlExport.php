<?php

namespace App\Solid\V3;

use App\Solid\V3\Interfaces\PostReportInterface;

class HtmlExport implements PostReportInterface
{
    public function export($data)
    {
        return view('posts.report', compact('data'));
    }
}