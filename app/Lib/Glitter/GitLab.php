<?php

namespace App\Lib\Glitter;

use App\Lib\GitLabApi\Api;

class GitLab
{
    function __construct()
    {
        $api = new Api();
        $this->api = $api->api;
        $this->user = $api->user;
        $this->date = new DateTime();
        $this->date->setTimezone(new DateTimeZone('Asia/Tokyo'));
    }

    public function getEvents()
    {
        return $this->api('events')->all(
            [
                'before' => $this->date->format('Y-m-d'),
                'after' => $this->date->modify('-1 days')->format('Y-m-d'),
            ]
        );
    }

    protected function analyzeEvents($events)
    {
        $event_data = [];
        $event_data['date'] = $this->date->modify('-1 days')->format('Y-m-d');
        $event_data['events_count'] = count($events);
        $event_data['commit_count'] = 0;
        foreach ($events as $event) {
            try{
                $event_data['commit_count'] += $event['pushdata']['commit_count'];
            } catch(Exception $e) {
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
