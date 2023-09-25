<?php

namespace App\Http\Controllers\Api\Logger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logger\EntityMethod;

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
        $method = EntityMethod::find($id) 
            or new \Exception('Not found', 404);

        $result = $method->execute();
        $method->createQueryLog([
            'time_exec' => $result['time_exec'],
            'data' => json_encode($result)
        ]) or new \Exception('', 503);

       return $this->response([
            'id' => $id, 
            'method' => $method,
            'result' => $result,
            'query_logs' => $method->queryLogs(),
            'last_query_log' => $method->lastQueryLog()
        ]); 
    }

    public function destroy(string $id)
    {
        $method = EntityMethod::find($id) 
            or new \Exception('Not found', 404);

        $method->delete() or new \Exception('', 503);

        return $this->response(['id' => $id]);
    }
}
