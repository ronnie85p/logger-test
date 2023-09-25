<?php

namespace App\Custom\Logger\Entity;

use App\Custom\Logger\Repository\IRepository;

class EndPoint implements IEntity
{
    public function __construct(
        private IRepository $repository
    ) { }

    public function store()
    {
        // $this->repository->store();
    }

    public function list()
    {
        return $this->repository->list();
    }
}