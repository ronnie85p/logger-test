<?php

namespace App\Http\Controllers\Api\Logger;

use App\Http\Controllers\Controller;
use App\Packages\Logger\Logger;
use Illuminate\Http\Request;

class EntityMethodController extends Controller
{
    public function response(array $data = [])
    {
        return response()->json([
            'response' => 'OK',
            'data' => $data
        ]);
    }

    public function exec(Request $request, string $id)
    {
        $method = Logger::entity()->execQuery($id);

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
        Logger::entity()->delete($id);

        return $this->response(['id' => $id]);
    }
}
