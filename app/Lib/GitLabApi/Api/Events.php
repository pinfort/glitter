<?php

namespace App\Lib\GitLabApi\Api;

use Gitlab\Api\AbstractApi;

class Events extends AbstractApi
{
    /**
     * @param array $parameters
     * @return mixed
     */
    public function all(array $parameters = [])
    {
        $resolver = $this->createOptionsResolver();
        return $this->get('events', $resolver->resolve($parameters));
    }
}
