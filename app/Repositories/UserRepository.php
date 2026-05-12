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
        return User::find($id);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => $data['password'], 
            ]);

            DB::commit();
            return $user;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Repository Error: " . $e->getMessage());
        }
    }

    public function update(string $id, array $data)
    {
        DB::beginTransaction();

        try {
            // FIX 1: Retrieve the EXISTING user from the database
            $user = User::find($id);

            if (!$user) {
                throw new \Exception("User not found");
            }

            // FIX 2: Update the fields on the existing object
            $user->name = $data['name']; 

            // Only update email if it's provided
            if (isset($data['email'])) {
                $user->email = $data['email'];
            }

            if (isset($data['password'])) {
                $user->password = $data['password']; // Hashing is handled by casts in User.php
            }

            // FIX 3: save() will now perform an UPDATE because $user has an ID
            $user->save();

            DB::commit();

            return $user;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(
        string $id
    ) {
        DB::beginTransaction();

        try {
            $user = User::find($id);
            $user->delete();

            DB::commit();

            return $user;

        } catch (\Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }
}