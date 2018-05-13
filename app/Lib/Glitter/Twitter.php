<?php

namespace App\Lib\Glitter;

use App\Lib\TwitterApi\Tweet;
use Config;
use Auth;

class Twitter
{
    function __construct()
    {
        $account = \App\LinkedSocialAccount::where('user_id', Auth::user()->id)->where('provider_name', 'twitter')->first();
        if (is_null($account)) {
            throw new \Exception('Twitter account not found');
        }
        $this->twitter = new Tweet($account);
    }

    protected function getTextFormat(): string
    {
        return Config::get('glitter.format');
    }

    protected function formatText(string $text, array $event_data): string
    {
        return sprintf(
            $text,
            $event_data['name'],
            $event_data['date'],
            $event_data['events_count'],
            $event_data['commit_count']
        );
    }

    public function execute(array $event_data)
    {
        $text = $this->formatText($this->getTextFormat(), $event_data);
        return $this->twitter->tweet($text);
    }
}
