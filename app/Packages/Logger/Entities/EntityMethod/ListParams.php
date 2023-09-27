<?php

namespace App\Packages\Logger\Entities\EntityMethod;

use Illuminate\Support\Facades\DB;
use App\Packages\Logger\Entities\ListParams as BaseListParams;

class ListParams extends BaseListParams
{
    public function __construct(array $params)
    {
        $this->setup($params);
    }

    public function setup(array $params)
    {
        parent::setup($params);

        $this->params['sortby'] = empty($this->params['sortby']) ? 
        $this->defaultParams['sortby'] : strtolower(trim($this->params['sortby']));
        $this->params['sortdir'] = strtolower(trim($this->params['sortdir']));
        $this->params['leftJoin'] = ['query_logs', function ($join) {
            $join->on('entity_methods.id', '=', 'query_logs.entity_method_id');
        }];
        $this->params['select'] = ['entity_methods.*', 
            DB::raw("MIN(query_logs.time_exec) AS min_time_exec"),
            DB::raw("MAX(query_logs.time_exec) AS max_time_exec"),
            DB::raw("AVG(query_logs.time_exec) AS avg_time_exec")
        ];
        $this->params['groupBy'] = 'entity_methods.id';
        $this->params['orderBy'] = [$this->params['sortby'], $this->params['sortdir']];
    }

    public function get(string $key, mixed $defaultValue = null): mixed
    {
        return isset($this->params[$key]) ? $this->params[$key] : $defaultValue;
    }
}