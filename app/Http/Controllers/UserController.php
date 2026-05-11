<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

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
            $users  = $this->userRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data User Berhasil Diambil', UserResource::collection($users), 200);

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request){
        $request = $request->validate([
            'search' => 'nullable|string',
            'row_per_page' => 'required|int',
        ]);

        try {
        $users = $this->userRepository->getAllPaginated(
            $request['search'] ?? null,
            $request['row_per_page']
        );

        // Pass UserResource::class so the paginator knows how to format each user
        return ResponseHelper::jsonResponse(
        true, 
        'Data User Berhasil Diambil', 
        PaginateResource::make($users, UserResource::class), // NOT UserRepositoryInterface
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
        // 1. Get the validated data into a SEPARATE variable
        $validatedData = $request->validated();

        try {
            // 2. Pass the array to your repository
            $user = $this->userRepository->create($validatedData);

            return ResponseHelper::jsonResponse(
                true, 
                'Data User Berhasil Ditambahkan', 
                new UserResource($user), 
                201
            );
        } catch (\Exception $e) {
            // Use a leading backslash for Exception to ensure it hits the global PHP Exception class
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

        if(!$user) {
            return ResponseHelper::jsonResponse(
            true, 
            'Data User Tidak Ditemukan', 
            null, // NOT UserRepositoryInterface
            404
            );
        }

        // Pass UserResource::class so the paginator knows how to format each user
        return ResponseHelper::jsonResponse(
        true, 
        'Data User Berhasil Diambil', 
        new UserResource($user), // NOT UserRepositoryInterface
        200
        );

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
