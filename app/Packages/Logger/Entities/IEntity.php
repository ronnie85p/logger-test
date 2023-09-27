<?php

namespace App\Packages\Logger\Entities;

use App\Packages\Logger\ListParams;

interface IEntity
{
    public function create(array $data);
    public function delete($id);
    public function find($id);
    public function list(ListParams $lp);
    public function listPaginator(array $params);
    public function execQuery($id);
}