<?php

namespace App\Packages\Logger\Entities;

use App\Packages\Logger\Exceptions\HttpException;
use App\Packages\Logger\Entities\IEntity;
use App\Packages\Logger\ListParams;
use App\Packages\Logger\Models\EntityMethod as EntityMethodModel;

class EntityMethod implements IEntity
{
    private $class = EntityMethodModel::class;

    public function getListParams(array $params): ListParams
    {
        return new ListParams($params);
    }

    /**
     * @throws \Exception
     */
    public function create(array $data) 
    {
        if ((new $this->class($data))->save() !== true) {
            throw new HttpException(503);
        }

        return null;
    }

    /**
     * @throws \Exception
     */
    public function delete($id) 
    {
        $inst = $this->find($id);
        if ($inst->delete() !== true) {
            throw new HttpException(503);
        }
    }

    /**
     * @throws \Exception
     */
    public function find($id) 
    {
        if (!$inst = $this->class::find($id)) {
            throw new HttpException(404);
        }

        return $inst;
    }

    public function list(ListParams $lp)
    {
        $collection = $this->class::leftJoin(
            ...$lp->get('leftJoin')
        )->select(...$lp->get('select'))
         ->groupBy($lp->get('groupBy'))
         ->orderBy(...$lp->get('orderBy'));

        return $collection;
    }

    public function listPaginator(ListParams $lp)
    {
        $paginator = $this->list($lp)->paginate($lp->get('limit'));
        $paginator->pages = ceil($paginator->total() / $paginator->perPage());

        return $paginator;
    }

    public function execQuery($id)
    {
        $inst = $this->find($id);
        $result = $inst->execute();

        $this->createQueryLog($id, $result);

        $inst->result = $result;
        return $inst;
    }

    public function createQueryLog($inst_id, $data)
    {
        $inst = $this->find($inst_id);

        $inst->createQueryLog([
            'time_exec' => $data['time_exec'],
            'data' => json_encode($data)
        ]) or new HttpException(503);
    }
}