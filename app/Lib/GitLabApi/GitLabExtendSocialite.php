<?php

namespace App\Lib\GitLabApi;

use SocialiteProviders\Manager\SocialiteWasCalled;

class GitLabExtendSocialite
{
    /**
     * Execute the provider.
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('gitlab', __NAMESPACE__.'\Provider');
    }
}
