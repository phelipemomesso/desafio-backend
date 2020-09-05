<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Http\Resources\UserResource;
use Modules\User\Services\UserService;

class UserController extends Controller
{
    /**
     * The service instance.
     *
     * @var UserService
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param UserService $service
     * @return void
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return UserResource::collection($this->service->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request)
    {

        $entity = $this->service->create($request->all());
        $data = UserResource::make($this->service->find($entity->id));
        return response()->json(['data' => $data], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return UserResource
     */
    public function show($id)
    {
        return UserResource::make($this->service->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param int $id
     * @return UserResource
     */
    public function update(UserRequest $request, $id)
    {
        $entity = $this->service->update($request->all(), $id);
        return UserResource::make($this->service->find($entity->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = $this->service->delete($id);
        return response()->json(['data' => $data], Response::HTTP_NO_CONTENT);
    }
}
