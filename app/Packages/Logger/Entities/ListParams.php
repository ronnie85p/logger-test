<?php

namespace App\Packages\Logger\Entities;

abstract class ListParams
{
    /**
     * @var $defaultParams
     */
    protected $defaultParams = [
        'limit' => 5,
        'sortby' => 'created_at', 
        'sortdir' => 'DESC',
    ];

    protected $params = [];

    public function setup(array $params)
    {
        $this->params = array_merge($this->defaultParams, $params);
    }

    abstract public function get(string $key, mixed $defaultValue = null): mixed;
}