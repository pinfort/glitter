<?php

namespace App\Lib\GitLabApi;

use Socialite;
use Config;
use Laravel\Socialite\AbstractUser;

class Api
{
    /**
     * account object
     */
    public $account;

    /**
     * connection to gitlab api
     */
    public $api;

    function __construct(\App\LinkedSocialAccount $account)
    {
        $this->account = $account;
        $this->api = $this->auth($this->account);
    }

    protected function auth(\App\LinkedSocialAccount $account)
    {
        $consumer_key = Config::get('services.gitlab.client_id');
        $consumer_secret = Config::get('services.gitlab.client_secret');
        $token = $account->access_token;
        return (new Client())->authenticate($token, Client::AUTH_OAUTH_TOKEN);
    }
}
