<?php

namespace App\Lib\TwitterApi;

use Socialite;
use Config;
use Abraham\TwitterOAuth\TwitterOAuth;
use Laravel\Socialite\AbstractUser;

class Tweet
{
    /**
     * Socialite Provider user object
     */
    protected $user;

    /**
     * connection to twitter api
     */
    protected $api;

    function __construct()
    {
        $this->user = Socialite::with('twitter')->user();
        $this->api = $this->auth($this->user);
    }

    protected function auth(AbstractUser $user)
    {
        $consumer_key = Config::get('services.twitter.client_id');
        $consumer_secret = Config::get('services.twitter.client_secret');
        $token = $user->token;
        return new TwitterOAuth($consumer_key, $consumer_secret, null, $token);
    }

    public function tweet(string $text)
    {
        return $this->api->post('statuses/update', array('status' => $text));
    }
}
