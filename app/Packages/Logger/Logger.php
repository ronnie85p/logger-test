<?php 
namespace App\Packages\Logger;

use App\Packages\Logger\Entities\Entity;
use App\Packages\Logger\Models\EntityMethod;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Logger 
{
    /**
     * @var $defaultParams
     */
    private static $defaultParams = [
        'limit' => 5,
        'sortby' => 'created_at', 
        'sortdir' => 'DESC',
    ];

    public static $params = [];

    public static function entity()
    {
        return new Entity();
    }

    public static function prepareParams(Request $request)
    {
        self::$params = array_merge(self::$defaultParams, $request->input());
    }

    public static function buildQuery()
    {
        return EntityMethod::leftJoin('query_logs', function ($join) {
            $join->on('entity_methods.id', '=', 'query_logs.entity_method_id');
        }) 
        ->select('entity_methods.*', 
            DB::raw("MIN(query_logs.time_exec) AS min_time_exec"),
            DB::raw("MAX(query_logs.time_exec) AS max_time_exec"),
            DB::raw("AVG(query_logs.time_exec) AS avg_time_exec"),
        )
        ->groupBy('entity_methods.id')
        ->orderBy(self::$params['sortby'], self::$params['sortdir']);
    }

    public static function prepareSort()
    {
        self::$params['sortby'] = empty(self::$params['sortby']) ? 
            self::$defaultParams['sortby'] : strtolower(trim(self::$params['sortby']));
        self::$params['sortdir'] = strtolower(trim(self::$params['sortdir']));
    }

    public static function getList(Request $request)
    {
        self::prepareParams($request);
        self::prepareSort();

        $paginator = self::buildQuery()->paginate(self::$params['limit']);
        $paginator->pages = ceil($paginator->total() / $paginator->perPage());

        return $paginator;
    }
}



/**
 * 1 Найти среднее значение (time_exec) из query_logs 
 * query_logs = [1, 34, 5, 10, 4]
 * 
 * 
 */

// class ServiceLogger {}

// 1 Реализовать набор интерфейсов для создания сущности нового метода и (или)ендпоинта
// Model: EndPoint
// GET:/entitymethod/create
// POST:/entitymethod

// 2 api-методы для добавления информации о времени выполнения кода
// 3 Реализовать набор интерфейсов для отображения списка методов и их времени выполнения с пагинацией,
// так же добавить фильтрацию по среднему времени выполнения различных методов.
// А так же наибольшему и наименьшему значению времени выполнения метода

// Предложить универсальные варианты отправки времени с других приложений на сервис логирования. 