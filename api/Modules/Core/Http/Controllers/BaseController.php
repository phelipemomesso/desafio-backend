<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    /**
     * The service instance.
     */
    protected $service;

    /**
     * The validator instance.
     */
    protected $validator;

    /**
     * The resource instance.
     */
    protected $resource;

    /**
     * The interacts of the attributes.
     */
    protected $interacts = [
        'create' => ['method' => 'all', 'param' => null],
        'update' => ['method' => 'all', 'param' => null],
    ];

    public function __construct()
    {
        $this->service = app($this->service);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (is_null($this->resource)) {
            return response()->json($this->service->paginate());
        } else {
            return $this->resource::collection($this->service->paginate());
        }
    }

    /**
     * Show the specified resource.
     *
     * @param string $id
     * @return Response
     */
    public function show($id)
    {
        if (is_null($this->resource)) {
            return response()->json($this->service->find($id));
        } else {
            return $this->resource::make($this->service->find($id));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validator::create($request));

        $attributes = call_user_func_array(
            [$request, data_get($this->interacts, 'create.method', 'all')],
            [data_get($this->interacts, 'create.param', null)]
        );

        $response = $this->service->create($attributes);

        if (is_null($this->resource)) {
            return response()->json($response, Response::HTTP_CREATED);
        } else {
            return response()->json(['data' => $this->resource::make($response)], Response::HTTP_CREATED);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->validator::update($id, $request));

        $attributes = call_user_func_array(
            [$request, data_get($this->interacts, 'update.method', 'all')],
            [data_get($this->interacts, 'update.param', null)]
        );

        $response = $this->service->update($attributes, $id);

        if (is_null($this->resource)) {
            return response()->json($response);
        } else {
            return $this->resource::make($response);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return Response
     */
    public function destroy($id)
    {
        $response = $this->service->delete($id);
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
