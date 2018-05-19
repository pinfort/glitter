<?php

namespace App\Lib\Glitter;

use App\Lib\GitLabApi\Api;
use Auth;

class GitLab
{
    function __construct()
    {
        $account = \App\LinkedSocialAccount::where('user_id', Auth::user()->id)->where('provider_name', 'gitlab')->first();
        if (is_null($account)) {
            throw new \Exception('GitLab account not found');
        }
        $api = new Api($account);
        $this->api = $api->api;
        $this->account = $api->account;
    }

    public function getEvents()
    {
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('Asia/Tokyo'));
        return $this->api->api('events')->all(
            [
                'before' => $date->format('Y-m-d'),
                'after' => $date->modify('-2 days')->format('Y-m-d'),
            ]
        );
    }

    public function getUser(): array
    {
        return $this->api->api('user')->all();
    }

    protected function analyzeEvents($events)
    {
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('Asia/Tokyo'));
        $event_data = [];
        $event_data['name'] = $this->getUser()['name'];
        $event_data['date'] = $date->modify('-1 days')->format('Y-m-d');
        $event_data['events_count'] = count($events);
        $event_data['commit_count'] = 0;
        foreach ($events as $event) {
            if (isset($event['pushdata']) and isset($event['pushdata']['commit_count'])) {
                $event_data['commit_count'] += $event['pushdata']['commit_count'];
            } else {
                continue;
            }
        }
        return $event_data;
    }

    public function event_data()
    {
        return $this->analyzeEvents($this->getEvents());
    }
}
