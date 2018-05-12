<?php

namespace App\Lib\GitLabApi;

use SocialiteProviders\GitLab\Provider as AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    /**
     * {@inheritdoc}
     */
    protected $scopes = [];

    /**
     * {@inheritdoc}
     */
    protected $scopeSeparator = ' ';
}
