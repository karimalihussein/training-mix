<?php

declare(strict_types=1);

namespace App\Services\Integrations\Twitter;

use Illuminate\Support\Facades\Http;

class TwitterService
{
    protected mixed $consumer_key;
    protected mixed $consumer_secret;
    protected mixed $access_token;
    protected mixed $access_token_secret;

    protected mixed $version;
    public function __construct()
    {
        $this->consumer_key = env('TWITTER_CONSUMER_KEY');
        $this->consumer_secret = env('TWITTER_CONSUMER_SECRET');
        $this->access_token = $this->getBearerToken();
        $this->access_token_secret = env('TWITTER_ACCESS_TOKEN_SECRET');
        $this->version = env('TWITTER_API_VERSION');
    }

    public function getBearerToken()
    {
        $response = Http::withBasicAuth($this->consumer_key, $this->consumer_secret)->asForm()->post('https://api.twitter.com/oauth2/token', ['grant_type' => 'client_credentials']);
        return $response->json()['access_token'];
    }

    public function getTweets(string $username, int $count = 10): array
    {
        $response = Http::withToken($this->access_token)->get("https://api.twitter.com/2/tweets/search/recent?query=from:{$username}&max_results={$count}");
        return $response->json()['data'];
    }

    public function getTweet(string $id): array
    {
        $response = Http::withToken($this->access_token)->get("https://api.twitter.com/2/tweets/{$id}");
        return $response->json()['data'];
    }

    public function getUser(string $username): array
    {
        $response = Http::withToken($this->access_token)->get("https://api.twitter.com/2/users/by/username/{$username}");
        return $response->json()['data'];
    }

    public function getUserTweets(string $username, int $count = 10): array
    {
        $response = Http::withToken($this->access_token)->get("https://api.twitter.com/2/users/by/username/{$username}/tweets?max_results={$count}");
        return $response->json()['data'];
    }

    public function getUserLikes(string $username, int $count = 10): array
    {
        $response = Http::withToken($this->access_token)->get("https://api.twitter.com/2/users/by/username/{$username}/likes?max_results={$count}");
        return $response->json()['data'];
    }

    public function getUserMedia(string $username, int $count = 10): array
    {
        $response = Http::withToken($this->access_token)->get("https://api.twitter.com/2/users/by/username/{$username}/media?max_results={$count}");
        return $response->json()['data'];
    }

    public function search(string $keyword, int $count = 10): array
    {
        $response = Http::withToken($this->access_token)->get("https://api.twitter.com/2/tweets/search/recent?query={$keyword}&max_results={$count}");
        return $response->json()['data'];
    }
}
