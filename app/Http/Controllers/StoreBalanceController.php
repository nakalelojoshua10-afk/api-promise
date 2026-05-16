<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\StoreBalanceResource;
use App\Interfaces\StoreBalanceRepositoryInterface;
use Illuminate\Http\Request;

class StoreBalanceController extends Controller
{

    private StoreBalanceRepositoryInterface $storeBalanceRepository;

    public function __construct(StoreBalanceRepositoryInterface $storeBalanceRepository) {
        $this->storeBalanceRepository = $storeBalanceRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         try {
            $storeBalance = $this->storeBalanceRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Wallet Berhasil Diambil', StoreBalanceResource::collection($storeBalance), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        // FIX: Store the validated array in a separate variable to avoid overwriting the Request object
        $validated = $request->validate([
            'search' => 'nullable|string',
            'row_per_page' => 'required|int',
        ]);

        try {
            $storeBalances = $this->storeBalanceRepository->getAllPaginated(
                $validated['search'] ?? null,
                $validated['row_per_page']
            );

            return ResponseHelper::jsonResponse(
                true, 
                'Data Wallet Berhasil Diambil', 
                PaginateResource::make($storeBalances, StoreBalanceResource::class), 
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
