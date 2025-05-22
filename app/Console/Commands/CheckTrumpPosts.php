<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckTrumpPosts extends Command
{
    protected $signature = 'check:trump_posts';
    protected $description = 'Check if Trump posted on X.com and send a Telegram notification';

    // Fetch Twitter API data with retry handling
    private function fetchTwitterData($url, $bearerToken)
    {
        do {
            $response = Http::withHeaders([
                'Authorization' => "Bearer $bearerToken"
            ])->get($url);

            $statusCode = $response->status();

            if ($statusCode == 429) {
                Log::warning("Twitter rate limit hit. Waiting for 60 seconds...");
                sleep(60); // Wait before retrying
            }
        } while ($statusCode == 429); // Keep retrying if rate limit is still hit

        return $response->json();
    }

    public function handle()
    {
        $username = 'yaredoayele'; // Trump's X handle
        $bearerToken = 'AAAAAAAAAAAAAAAAAAAAAG5LwwEAAAAAI6XyB6XcASpLAUMgVhfDsu%2BseSE%3DDD604lwaIyEl4CESy4zmiCUfghcxDx2WvplRHLsFFlPXzI47KW'; // Get from https://developer.twitter.com/
        $telegramToken = '7465206082:AAGpMhSRXaDkUGcXgTvZ3nbt1d2LRc59-NA'; // Get from BotFather
        $chatId = '1842712950'; // Get using @getmyid_bot


        // Get Trump's Twitter ID
        $userData = $this->fetchTwitterData("https://api.twitter.com/2/users/by/username/$username", $bearerToken);

        if (!isset($userData['data']['id'])) {
            Log::error('Twitter API Error: ' . json_encode($userData));
            $this->error('Error fetching user data. Check logs.');
            return;
        }

        $userId = $userData['data']['id'];

        // Fetch latest tweet
// Fetch latest tweet
$tweetsData = $this->fetchTwitterData("https://api.twitter.com/2/users/$userId/tweets?max_results=5", $bearerToken);

        if (!isset($tweetsData['data'][0]['text'])) {
            Log::error('Twitter API Error: ' . json_encode($tweetsData));
            $this->error('Error fetching tweets. Check logs.');
            return;
        }

        $latestTweet = $tweetsData['data'][0]['text'];
        $lastPost = cache()->get('trump_last_post');

        if ($latestTweet !== $lastPost) {
            cache()->put('trump_last_post', $latestTweet, now()->addMinutes(10));

            // Send Telegram notification
            $message = "🚨 Trump just posted on X:\n\n$latestTweet";
            Http::get("https://api.telegram.org/bot$telegramToken/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message
            ]);

            $this->info('New post detected and Telegram message sent!');
        } else {
            $this->info('No new post.');
        }
    }
}