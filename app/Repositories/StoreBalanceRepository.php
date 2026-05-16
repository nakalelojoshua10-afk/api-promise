<?php

namespace App\Repositories;

use App\Interfaces\StoreBalanceRepositoryInterface;
use App\Models\StoreBalance;

class StoreBalanceRepository implements StoreBalanceRepositoryInterface {
    public function getAll(?string $search, ?int $limit, bool $execute)
    {
        $query = StoreBalance::where(function ($query) use ($search) {
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
        return StoreBalance::find($id);
    }
}