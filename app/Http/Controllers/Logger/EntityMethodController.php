<?php

namespace App\Http\Controllers\Logger;

use App\Http\Controllers\Controller;
use App\Models\Logger\EntityMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntityMethodController extends Controller
{
    /**
     * @var $validationRules
     */
    private $validationRules = [
        'name' => 'required|unique:entity_methods|max:25',
        'endpoint' => 'required|unique:entity_methods|max:255',
    ];

    /**
     * @var $defaultParams
     */
    private $defaultParams = [
        'limit' => 5,
        'sortby' => 'created_at', 
        'sortdir' => 'DESC',
    ];

    private $form = [
        'sortby' => [
            'name' => 'sortby',
            'options' => [
                'created_at'    => 'Дате создания',
                'avg_time_exec' => 'Среднему времени выполнения запроса',
                'max_time_exec' => 'Максимальному времени выполнения запроса',
                'min_time_exec' => 'Минимальному времени выполнения запроса'
            ]
        ],
        'sortdir' => [
            'name' => 'sortdir',
            'options' => [
                'desc' => 'Убывания',
                'asc' => 'Возрастания',
            ]
        ]
    ];

    private $params = [];

    public function redirect(string $route = 'method.list')
    {
        return redirect()->route($route);
    }

    public function prepareParams(Request $request)
    {
        $this->params = array_merge($this->defaultParams, $request->input());
    }

    public function prepareSort()
    {
        $this->params['sortby'] = empty($this->params['sortby']) ? 
            $this->defaultParams['sortby'] : strtolower(trim($this->params['sortby']));
        $this->params['sortdir'] = strtolower(trim($this->params['sortdir']));
    }

    public function buildQuery()
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
        ->orderBy($this->params['sortby'], $this->params['sortdir']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $title = 'Method list';

        $this->prepareParams($request);
        $this->prepareSort();

        $paginator = $this->buildQuery()->paginate($this->params['limit']);
        $pages = ceil($paginator->total() / $paginator->perPage());

        return view('logger.method.index', [
            'title'     => $title,
            'paginator' => $paginator,
            'pages'     => $pages,
            'form'      => (object)$this->form,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'New method';

        return view('logger.method.create', [
            'title' => $title
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        // It will throw exception if error occured
        // and redirect to prev page
        $validated = $request->validate($this->validationRules);

        // if will any errors occured
        if ((new EntityMethod($validated))->save() !== true) {
            throw new \Exception('Service Unavailable', 503);
        }

        return $this->redirect();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 
    }
}
