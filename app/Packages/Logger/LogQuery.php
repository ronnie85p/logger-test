<?php 

namespace App\Packages\Logger;

class LogQuery 
{
    public function exec()
    {
        $inst = $this->find($id);
        $result = $method->execute();

        $method->createQueryLog([
            'time_exec' => $result['time_exec'],
            'data' => json_encode($result)
        ]) or new \Exception('', 503);

        $method->result = $result;
        return $method;

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