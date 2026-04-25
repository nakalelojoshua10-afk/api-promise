<?php


namespace App\Interfaces;

interface UserRepositoryInterface {
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute,
    );

    public function geatAllPaginated(
        ?string $search,
        ?int $rowPerPage,
    );
}