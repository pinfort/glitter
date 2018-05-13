<?php

namespace App\Lib\GitLabApi\Api;

use Gitlab\Api\AbstractApi;

class User extends AbstractApi
{
    /**
     * @param array $parameters
     * @return mixed
     */
    public function all(array $parameters = [])
    {
        $resolver = $this->createOptionsResolver();
        return $this->get('user', $resolver->resolve($parameters));
    }
}
