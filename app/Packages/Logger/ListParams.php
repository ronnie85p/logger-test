<?php

namespace App\Packages\Logger;

use Illuminate\Support\Facades\DB;

class ListParams 
{
    /**
     * @var $defaultParams
     */
    private $defaultParams = [
        'limit' => 5,
        'sortby' => 'created_at', 
        'sortdir' => 'DESC',
    ];

    private $params = [];

    public function __construct(array $params)
    {
        $this->params = array_merge($this->defaultParams, $params);
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

    public function get(string $key, string $defaultValue = null): mixed
    {
        return isset($this->params[$key]) ? $this->params[$key] : $defaultValue;
    }
}