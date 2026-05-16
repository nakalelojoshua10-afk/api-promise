<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\StoreResource;
use App\Interfaces\StoreRepositoryInterface;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    private StoreRepositoryInterface $storeRepository;

    public function __construct(StoreRepositoryInterface $storeRepository) {
        $this->storeRepository = $storeRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         try {
            $stores = $this->storeRepository->getAll(
                $request->search,
                $request->is_verified,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Toko Berhasil Diambil', StoreResource::collection($stores), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        // FIX: Store the validated array in a separate variable to avoid overwriting the Request object
        $validated = $request->validate([
            'search' => 'nullable|string',
            'is_verified' => 'nullable|boolean',
            'row_per_page' => 'required|int',
        ]);

        try {
            $stores = $this->storeRepository->getAllPaginated(
                $validated['search'] ?? null,
                $validated['is_verified'] ?? null,
                $validated['row_per_page']
            );

            return ResponseHelper::jsonResponse(
                true, 
                'Data Toko Berhasil Diambil', 
                PaginateResource::make($stores, StoreResource::class), 
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStoreRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $store = $this->storeRepository->create($validatedData);

            return ResponseHelper::jsonResponse(
                true, 
                'Data Toko Berhasil Ditambahkan', 
                new StoreResource($store), 
                201
            );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $store = $this->storeRepository->getById($id);

            if (!$store) {
                return ResponseHelper::jsonResponse(false, 'Data Store Tidak Ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(
                true, 
                'Data Store Berhasil Diambil', 
                new StoreResource($store), 
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }   
    }

    public function updateVerifiedStatus(string $id) {
     try {
            $store = $this->storeRepository->getById($id);

            if (!$store) {
                return ResponseHelper::jsonResponse(false, 'Data Store Tidak Ditemukan', null, 404);
            }

            $store = $this->storeRepository->updateVerifiedStatus(
                $id,
                true
            );

            return ResponseHelper::jsonResponse(
                true, 
                'Data Store Berhasil Diverifikasi', 
                new StoreResource($store), 
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        } 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
