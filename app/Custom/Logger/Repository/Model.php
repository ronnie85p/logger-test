<?php

namespace App\Custom\Logger\Repository;

class Model implements IRepository
{
    public function __construct(
        private $model
    ) {}

    public function store()
    {
        $this->model->store();
    }

    public function list() {
        return [
            [
                'id' => 1,
                'name' => 'Action1',
                'action' => 'path/action',
                'exec_time' => time()
            ],
            [
                'id' => 2,
                'name' => 'Action2',
                'action' => 'path/action',
                'exec_time' => time()
            ]
        ];
    }
}