<?php

declare(strict_types=1);

namespace App\Solid\OCP\V3;

use App\Models\Post;
use App\Solid\OCP\V3\Interfaces\PostReportInterface;

class PostReportService
{
    public $posts;

    public function between($startDate, $endDate)
    {
        $this->posts = Post::whereBetween('created_at', [$startDate, $endDate])->latest('id')->get();

        return $this;
    }

    public function export(PostReportInterface $format)
    {
        return $format->export($this->posts);
    }
}
