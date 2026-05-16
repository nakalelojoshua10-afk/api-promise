<?php

namespace App\Interfaces;

use App\Models\StoreBalanceHistory;

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
}