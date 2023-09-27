<?php

namespace App\Packages\Logger\Entities;

use App\Packages\Logger\Entities\IListParams;

interface IEntity
{
    public function create(array $data);
    public function delete($id);
    public function find($id);
    public function list(IListParams $lp);
    public function listPaginator(IListParams $lp);
    public function getListParams(array $params): IListParams;
    public function execQuery($id);
}