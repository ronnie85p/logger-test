<?php

namespace App\Http\Controllers\Api\Logger;

use App\Http\Controllers\Controller;
use App\Packages\Logger\LoggerFactory;
use App\Packages\Logger\Entities\EntityMethod;
use Illuminate\Http\Request;

class EntityMethodController extends Controller
{
    private $logger;

    public function __construct()
    {
        $this->logger = (new LoggerFactory(
            new EntityMethod()
        ))->entity();
    }

    public function response(array $data = [])
    {
        return response()->json([
            'response' => 'OK',
            'data' => $data
        ]);
    }

    public function exec(Request $request, string $id)
    {
        $method = $this->logger->execQuery($id);

       return $this->response([
            'id' => $id, 
            'method' => $method,
            'result' => $method->result,
            'query_logs' => $method->queryLogs(),
            'last_query_log' => $method->lastQueryLog()
        ]); 
    }

    public function destroy(string $id)
    {
        $this->logger->delete($id);

        return $this->response(['id' => $id]);
    }
}
