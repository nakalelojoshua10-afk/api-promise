<?php

namespace App\Repositories; // 👈 FIXED: Changed from App\Interfaces to App\Repositories

use App\Interfaces\StoreBalanceHistoryRepositoryInterface; // 👈 IMPORTED the interface
use App\Models\StoreBalanceHistory;
use Illuminate\Support\Facades\DB;

class StoreBalanceHistoryRepository implements StoreBalanceHistoryRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute)
    {
        $query = StoreBalanceHistory::where(function ($query) use ($search) {
            if ($search) {
                $query->search($search);
            }
        });

        if($limit){
            $query->take($limit);
        }

        if($execute){
            return $query->get();
        }

        return $query;
    }

    public function getAllPaginated(?string $search, ?int $rowPerPage)
    {
        $query = $this->getAll(
            $search,
            null,
            false
        );

        return $query->paginate($rowPerPage);
    }

    public function getById(?string $id)
    {
        return StoreBalanceHistory::find($id);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $storeBalanceHistory = StoreBalanceHistory::create([
                'store_balance_id' => $data['store_balance_id'],
                'type' => $data['type'],
                'reference_id' => $data['reference_id'], 
                'reference_type' => $data['reference_type'],
                'amount' => $data['amount'],
                'remaks' => $data['remarks'],
            ]);

            DB::commit();
            return $storeBalanceHistory;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Repository Error: " . $e->getMessage());
        }
    }

    public function update(?string $id, array $data)
    {
        DB::beginTransaction();

        try {
            $storeBalanceHistory = StoreBalanceHistory::find($id);
            $storeBalanceHistory->update([
                'type' => $data['type'],
                'reference_id' => $data['reference_id'], 
                'reference_type' => $data['reference_type'],
                'amount' => $data['amount'],
                'remaks' => $data['remarks'],
            ]);

            DB::commit();
            return $storeBalanceHistory;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Repository Error: " . $e->getMessage());
        }
    }
}