<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckTrumpTweets extends Command
{
    protected $signature = 'check:trump-tweets';
    protected $description = 'Check for new tweets from Donald Trump and send to Telegram';

    public function handle()
    {
        $twitterBearerToken = "AAAAAAAAAAAAAAAAAAAAAG5LwwEAAAAAqHqikxi4kjQsrL%2FEhknUIICAfmM%3DbbvsMqCxIot7hP6RtZrcMqxcMYICe8uz5G0WiB3gcBtB9Yb2Nq";
        $telegramBotToken = "7465206082:AAGpMhSRXaDkUGcXgTvZ3nbt1d2LRc59-NA";
        $telegramChatId = "1842712950";

        $username = 'yaredoayele'; // Trump's Twitter handle

        // Fetch Trump's latest tweets
        $response = Http::withHeaders([
            'Authorization' => "Bearer $twitterBearerToken",
        ])->get("https://api.twitter.com/2/users/by/username/$username");

        $userId = $response->json()['data']['id'] ?? null;

        if (!$userId) {
            $this->error("Error: Unable to fetch Trump's Twitter ID.");
            return;
        }

        // Get latest tweet
        $tweetsResponse = Http::withHeaders([
            'Authorization' => "Bearer $twitterBearerToken",
        ])->get("https://api.twitter.com/2/users/$userId/tweets?max_results=1");

        $tweets = $tweetsResponse->json()['data'] ?? [];

        if (!empty($tweets)) {
            $latestTweet = $tweets[0];
            $tweetText = $latestTweet['text'];
            $tweetUrl = "https://twitter.com/$username/status/" . $latestTweet['id'];

            // Send message to Telegram
            $telegramMessage = "🚨 **Donald Trump Posted on Twitter** 🚨\n\n"
                . "📢 *Tweet:* $tweetText\n\n"
                . "🔗 [View Tweet]($tweetUrl)";

            Http::post("https://api.telegram.org/bot$telegramBotToken/sendMessage", [
                'chat_id' => $telegramChatId,
                'text' => $telegramMessage,
                'parse_mode' => 'Markdown',
            ]);

            $this->info('Trump\'s tweet sent to Telegram!');
        } else {
            $this->info('No new tweets from Trump.');
        }
    }
}