<?php

namespace App\Lib\TwitterApi;

use Socialite;
use Config;
use Abraham\TwitterOAuth\TwitterOAuth;

class Tweet
{
    /**
     * account object
     */
    protected $account;

    /**
     * connection to twitter api
     */
    protected $api;

    function __construct(\App\LinkedSocialAccount $account)
    {
        $this->account = $account;
        $this->api = $this->auth($this->account);
    }

    protected function auth(\App\LinkedSocialAccount $account)
    {
        $consumer_key = Config::get('services.twitter.client_id');
        $consumer_secret = Config::get('services.twitter.client_secret');
        $token = $account->access_token;
        return new TwitterOAuth($consumer_key, $consumer_secret, null, $token);
    }

    public function tweet(string $text)
    {
        return $this->api->post('statuses/update', array('status' => $text));
    }
}
