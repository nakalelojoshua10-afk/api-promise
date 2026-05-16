<?php

namespace App\Interfaces;

interface StoreBalanceRepositoryInterface {
    public function getAll(?string $search, ?int $limit, bool $execute);
    public function getAllPaginated(?string $search, ?int $rowPerPage);
    public function getById(?string $id); // 👈 ADDED THIS LINE
}