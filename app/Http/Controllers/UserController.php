<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $users = $this->userRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data User Berhasil Diambil', UserResource::collection($users), 200);
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
            $users = $this->userRepository->getAllPaginated(
                $validated['search'] ?? null,
                $validated['row_per_page']
            );

            return ResponseHelper::jsonResponse(
                true, 
                'Data User Berhasil Diambil', 
                PaginateResource::make($users, UserResource::class), 
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        // FIX: Removed dd($validatedData) so the code can actually reach the repository
        $validatedData = $request->validated();

        try {
            $user = $this->userRepository->create($validatedData);

            return ResponseHelper::jsonResponse(
                true, 
                'Data User Berhasil Ditambahkan', 
                new UserResource($user), 
                201
            );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = $this->userRepository->getById($id);

            if (!$user) {
                return ResponseHelper::jsonResponse(false, 'Data User Tidak Ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(
                true, 
                'Data User Berhasil Diambil', 
                new UserResource($user), 
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $validatedData = $request->validated(); 

        try {
            // Logic check: verify user exists before attempting update
            $userExists = $this->userRepository->getById($id);

            if (!$userExists) {
                return ResponseHelper::jsonResponse(false, 'Data User Tidak Ditemukan', null, 404);
            }

            // The repository handles the actual UPDATE logic
            $user = $this->userRepository->update($id, $validatedData);

            return ResponseHelper::jsonResponse(
                true, 
                'Data User Berhasil Diperbarui', 
                new UserResource($user), 
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Logic for destroy would go here
    }
}