<?php

namespace Acacia\AcaciaRelationships\Http\Controllers\Api;

use Acacia\AcaciaRelationships\Models\Relationship;
use Acacia\AcaciaRelationships\Repositories\Relationships;
use Acacia\AcaciaRelationships\Http\Requests\Relationship\IndexRequest;
use Acacia\AcaciaRelationships\Http\Requests\Relationship\DtRequest;
use Acacia\AcaciaRelationships\Http\Requests\Relationship\ViewRequest;
use Acacia\AcaciaRelationships\Http\Requests\Relationship\StoreRequest;
use Acacia\AcaciaRelationships\Http\Requests\Relationship\UpdateRequest;
use Acacia\AcaciaRelationships\Http\Requests\Relationship\DestroyRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Savannabits\Acacia\Helpers\ApiResponse;

class AcaciaRelationshipController extends Controller
{
    public function __construct(
        private ApiResponse $api,
        private Relationships $repo
    ) {
    }
    /**
     * Display a listing of the resource.
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        try {
            $data = $this->repo->index();
            return $this->api
                ->success()
                ->message("List of AcaciaRelationships")
                ->payload($data)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * @param DtRequest $request
     * @return LengthAwarePaginator|JsonResponse
     */
    public function dt(DtRequest $request): LengthAwarePaginator|JsonResponse
    {
        try {
            return $this->repo->dt();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $payload = $this->repo->store($request->sanitizedObject());
            $success = "Record created successfully";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * Show the specified resource.
     * @param ViewRequest $request
     * @param Relationship $relationship
     * @return JsonResponse
     */
    public function show(
        ViewRequest $request,
        Relationship $relationship
    ): JsonResponse {
        try {
            $payload = $this->repo->setModel($relationship)->show();
            $success = "Single record fetched";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Relationship $relationship
     * @return JsonResponse
     */
    public function update(
        UpdateRequest $request,
        Relationship $relationship
    ): JsonResponse {
        try {
            $payload = $this->repo
                ->setModel($relationship)
                ->update($request->sanitizedObject());
            $success = "Record updated successfully";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param DestroyRequest $request
     * @param Relationship $relationship
     * @return JsonResponse
     */
    public function destroy(
        DestroyRequest $request,
        Relationship $relationship
    ): JsonResponse {
        try {
            $payload = $this->repo->setModel($relationship)->destroy();
            $success = "Record deleted successfully";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }
}
