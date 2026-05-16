<?php

namespace App\Interfaces;

interface StoreRepositoryInterface
{
    public function getAll(?string $search,?bool $isVerified, ?int $limit, bool $execute);
    public function getAllPaginated(?string $search, ?bool $isVerified,?int $rowPerPage);
    public function getById(?string $id);
}