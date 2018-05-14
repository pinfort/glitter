<?php

namespace App\Lib\GitLabApi;

use Gitlab\Client as ParentClient;

class Client extends ParentClient
{
    public function events()
    {
        return new Api\Events($this);
    }

    public function user()
    {
        return new Api\User($this);
    }

    public function api($name)
    {
        switch ($name) {
        case 'events':
            return $this->events();
        case 'user':
            return $this->user();
        }
        return parent::api($name);
    }
}
