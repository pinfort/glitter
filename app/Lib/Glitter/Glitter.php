<?php

namespace App\Lib\Glitter;

use App\User;
use Auth;

class Glitter
{
    function __construct()
    {

    }

    protected function setUser(User $user)
    {
        return Auth::login($user);
    }

    protected function unsetUser()
    {
        Auth::logout();
    }

    protected function getUsers()
    {
        $users = User::all();
        foreach ($users as $user) {
            $have_twitter = false;
            $have_gitlab = false;
            $accounts = $user->accounts;
            foreach ($accounts as $account) {
                if ($account->provider_name === 'twitter') {
                    $have_twitter = true;
                } else if ($account->provider_name === 'gitlab') {
                    $have_gitlab = true;
                }
            }
            if (!$have_gitlab or !$have_twitter) {
                // gitlabかtwitterのアカウントどっちかがなければスキップ
                continue;
            }
            yield $user;
        }
    }

    public function execute()
    {
        foreach ($this->getUsers() as $user) {
            $this->setUser($user);
            $gl = new GitLab();
            $event_data = $gl->event_data();
            $tw = new Twitter();
            $tw->execute($gl->user->getName(), $event_data);
        }
        $this->unsetUser();
    }

    public function showEvents()
    {
        foreach ($this->getUsers() as $user) {
            $this->setUser($user);
            $gl = new GitLab();
        }
        $this->unsetUser();
    }
}
