<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\StoreBalanceHistoryResource;
use App\Interfaces\StoreBalanceHistoryRepositoryInterface;
use App\Repositories\StoreBalanceHistoryRepository; // 🟢 1. IMPORT THE CONCRETE REPOSITORY CLASS
use Illuminate\Http\Request;

class StoreBalanceHistoryController extends Controller
{
    private StoreBalanceHistoryRepositoryInterface $storeBalanceHistoryRepository;

    // 🟢 2. REMOVE THE TYPE-HINT INJECTION PARAMETER FROM THE CONSTRUCTOR
    public function __construct()
    {
        // 🟢 3. INSTANTIATE THE REPOSITORY DIRECTLY BYPASSING THE BROKEN CONTAINER LOADER
        $this->storeBalanceHistoryRepository = new StoreBalanceHistoryRepository();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $storeBalanceHistories = $this->storeBalanceHistoryRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Riwayat Wallet Berhasil Diambil', StoreBalanceHistoryResource::collection($storeBalanceHistories), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $validated = $request->validate([
            'search' => 'nullable|string',
            'row_per_page' => 'required|int',
        ]);

        try {
            $storeBalanceHistories = $this->storeBalanceHistoryRepository->getAllPaginated(
                $validated['search'] ?? null,
                $validated['row_per_page']
            );

            return ResponseHelper::jsonResponse(
                true, 
                'Data Riwayat Wallet Berhasil Diambil', 
                PaginateResource::make($storeBalanceHistories, StoreBalanceHistoryResource::class), 
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         try {
            $storeBalanceHistory = $this->storeBalanceHistoryRepository->getById($id);

            if (!$storeBalanceHistory) {
                return ResponseHelper::jsonResponse(false, 'Data Riwayat Wallet Tidak Ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(
                true, 
                'Data Riwayat Wallet Berhasil Diambil', 
                new StoreBalanceHistoryResource($storeBalanceHistory), 
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