<?php

namespace App\Interfaces;

// 🟢 Ensure it says "interface" and has "Interface" at the end of the name
interface StoreBalanceHistoryRepositoryInterface 
{
    public function getAll(?string $search, ?int $limit, bool $execute);
    public function getAllPaginated(?string $search, ?int $rowPerPage);
    public function getById(?string $id);
    public function create(array $data);
}