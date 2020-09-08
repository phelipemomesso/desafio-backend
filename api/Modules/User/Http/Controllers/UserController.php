<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\UserAmountRequest;
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
        try {
            $entity = $this->service->create($request->all());
            $data = UserResource::make($this->service->find($entity->id));
            return response()->json(['data' => $data], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return UserResource
     */
    public function show($id)
    {
        try {
            return UserResource::make($this->service->find($id));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
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
        try {
            $entity = $this->service->update($request->all(), $id);
            return UserResource::make($this->service->find($entity->id));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $data = $this->service->delete($id);
            return response()->json(['data' => $data], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the amount from a specified resource in storage.
     *
     * @param UserAmountRequest $request
     * @param int $id
     * @return UserResource
     */
    public function updateInitialAmount(UserAmountRequest $request, $id)
    {
        try {
            $entity = $this->service->initialAmount($request->all(), $id);
            return UserResource::make($this->service->find($entity->id));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function balance($id)
    {
        try {
            $data = $this->service->balance($id);
            return response()->json(['balance' => $data], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
