<?php

namespace App\Spiders;

use Roach\Spider\BasicSpider;
use Roach\Spider\ParseResult;
use Roach\Spider\ParseItem;
use Roach\Spider\ParseRequest;

class TwitterSpider extends BasicSpider
{
    public array $startUrls = [
        // Add the initial URL to scrape from
        'https://twitter.com/username',
    ];

    public function parse($response)
    {
        $tweets = $response->filter('.tweet')->each(function ($node) {
            return [
                'content' => $node->filter('.tweet-text')->text(),
                'date' => $node->filter('.time')->text(),
                'username' => $node->filter('.username')->text(),
                'retweets' => $node->filter('.ProfileTweet-action--retweet .ProfileTweet-actionCount')->attr('data-tweet-stat-count'),
                'likes' => $node->filter('.ProfileTweet-action--favorite .ProfileTweet-actionCount')->attr('data-tweet-stat-count'),
            ];
        });

        return ParseResult::item($tweets);
    }
}
