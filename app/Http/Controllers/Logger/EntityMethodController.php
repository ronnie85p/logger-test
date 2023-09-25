<?php

namespace App\Http\Controllers\Logger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logger\EntityMethod;

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
     * @var $listParams
     */
    private $listParams = [
        'limit' => 5,
        'sortby' => 'id', 
        'sortdir' => 'DESC'
    ];

    public function redirect(string $route = 'method.list')
    {
        return redirect()->route($route);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {  
        $params = array_merge($this->listParams, $request->input());
        $paginator = EntityMethod::orderBy($params['sortby'], $params['sortdir'])
            ->paginate($params['limit']);

        $pages = ceil($paginator->total() / $paginator->perPage());

        return view('logger.method.index', [
            'title' => 'Method List',
            'paginator' => $paginator,
            'pages' => $pages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('logger.method.create', [
            'title' => 'New Method'
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
