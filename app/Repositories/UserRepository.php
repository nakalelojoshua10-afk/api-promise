<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface {
    public function getAll(?string $search, ?int $limit, bool $execute)
    {
        $query = User::where(function ($query) use ($search) {
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
        $query = User::where('id', $id);
        return $query->first();
    }

    public function create(array $data)
    {
        DB::beginTransaction(); // Added leading backslash for safety

        try {
            $user = new User;
            // FIX: Use [] instead of ()
            $user->name = $data['name']; 
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();

            DB::commit();

            return $user;

        } catch (\Exception $e) {
            DB::rollBack();

            // Use a leading backslash so PHP knows you mean the global Exception class
            throw new \Exception($e->getMessage());
        }
    }
}