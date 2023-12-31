<?php

namespace App\Http\Controllers\Logger;

use App\Http\Controllers\Controller;
use App\Packages\Logger\Traits\Form;
use App\Packages\Logger\LoggerFactory;
use App\Packages\Logger\Entities\EntityMethod;
use Illuminate\Http\Request;

class EntityMethodController extends Controller
{
    use Form;

    private $logger;

    public function __construct()
    {
        $this->logger = (new LoggerFactory(
            new EntityMethod()
        ))->entity();
    }

    public function redirect(string $route = 'method.list')
    {
        return redirect()->route($route);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $title = 'Method list';
        $paginator = $this->logger->listPaginator(
            $this->logger->getListParams($request->input())
        );

        return view('logger.method.index', [
            'title'     => $title,
            'paginator' => $paginator,
            'pages'     => $paginator->pages,
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
        $this->logger->create($validated);

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
