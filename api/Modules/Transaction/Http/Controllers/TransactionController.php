<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Transaction\Http\Requests\ExportRequest;
use Modules\Transaction\Http\Requests\TransactionRequest;
use Modules\Transaction\Http\Resources\TransactionResource;
use Modules\Transaction\Services\TransactionService;

class TransactionController extends Controller
{
    /**
     * The service instance.
     *
     * @var TransactionService
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param TransactionService $service
     * @return void
     */
    public function __construct(TransactionService $service)
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
        return TransactionResource::collection($this->service->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TransactionRequest $request
     * @return Response
     */
    public function store(TransactionRequest $request)
    {
        try {
            $entity = $this->service->create($request->all());
            $data = TransactionResource::make($this->service->find($entity->id));
            return response()->json(['data' => $data], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return TransactionResource
     */
    public function show($id)
    {
        try {
            return TransactionResource::make($this->service->find($id));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TransactionRequest $request
     * @param int $id
     * @return TransactionResource
     */
    public function update(TransactionRequest $request, $id)
    {
        try {
            $entity = $this->service->update($request->all(), $id);
            return TransactionResource::make($this->service->find($entity->id));
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
     *
     *  Exports all a user's transactions using a filter.
     *
     * @param ExportRequest $request
     * @return Response
     */
    public function export(ExportRequest $request)
    {
        try {
            $data = $this->service->export($request->all());
            return response()->json(['data' => $data], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
