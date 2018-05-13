<?php

namespace App\Lib\GitLabApi;

use Socialite;
use Laravel\Socialite\AbstractUser;

class Api
{
    /**
     * account object
     */
    protected $account;

    /**
     * connection to gitlab api
     */
    protected $api;

    function __construct(\App\LinkedSocialAccount $account)
    {
        $this->account = $account;
        $this->api = $this->auth($this->user);
    }

    protected function auth(AbstractUser $user)
    {
        $consumer_key = Config::get('services.gitlab.client_id');
        $consumer_secret = Config::get('services.gitlab.client_secret');
        $token = $account->access_token;
        return (new Client())->authenticate($token, Client::AUTH_OAUTH_TOKEN)->api;
    }
}
