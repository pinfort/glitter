<?php

namespace App\Lib\GitLabApi;

use Socialite;
use Laravel\Socialite\AbstractUser;

class Api
{
    /**
     * Socialite Provider user object
     */
    protected $user;

    /**
     * connection to gitlab api
     */
    protected $api;

    function __construct()
    {
        $this->user = Socialite::with('gitlab')->user();
        $this->api = $this->auth($this->user);
    }

    protected function auth(AbstractUser $user)
    {
        $consumer_key = Config::get('services.gitlab.client_id');
        $consumer_secret = Config::get('services.gitlab.client_secret');
        $token = $user->token;
        return (new Client())->authenticate($token, Client::AUTH_OAUTH_TOKEN)->api;
    }
}
