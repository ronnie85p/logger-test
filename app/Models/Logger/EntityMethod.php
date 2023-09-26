<?php

namespace App\Models\Logger;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntityMethod extends Model
{
    use HasFactory;

    protected $startTime;
    protected $endTime;

    /**
     * @var array
     */
    protected $fillable = ['name', 'endpoint'];

    public function queryLogs()
    {
        return QueryLog::all()->where('entity_method_id', '=', $this->id);
        // return $this->hasMany(QueryLog::class);
    }

    public function lastQueryLog()
    {
        return $this->queryLogs()->sortByDesc('created_at')->first();
    }

    public function createQueryLog(array $fields)
    {
        return (new QueryLog)->create(array_merge($fields, [
            'entity_method_id' => $this->id,
        ]));
    }

    public function startTime()
    {
        $this->startTime = microtime(true);
    }

    public function endTime()
    {
        $this->endTime = microtime(true);
    }

    public function getExecTime()
    {
        return $this->endTime - $this->startTime;
    }

    public function execute()
    {   
        $this->startTime();
        usleep(mt_rand(1000000, 10000000));
        $this->endTime();
        
        return [
            'test' => true,
            'message' => "Method '{$this->endpoint}' was executed.",
            'time_exec' => $this->getExecTime()
        ];
    }
}
