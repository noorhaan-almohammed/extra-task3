<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest\StoreUserRequest;
use App\Http\Requests\UserRequest\UpdateUserRequest;

class UserController extends Controller
{

    /**
     * @var UserService
     */
    protected $UserService;

    /**
     *  UserController constructor
     * @param UserService $UserService
     */
    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('show_user', User::class);
        $users = $this->UserService->listUser();
        if ($users->isEmpty()) {
            return parent::errorResponse( "No Bookk Found", 404);
        }
        return parent::successResponse('books',
                    UserResource::collection($users)->response()->getData(true),  // response with Metadata
                    "Books retrieved successfully",
                    200);
    }

    public function getUserWithHisBooks(Request $request,$user_id)
    {
        $perPage = $request->input('per_page', 10); // Default to 10 if not provided
        $Users = $this->UserService->getUserWithHisBooks($perPage,$user_id);
        return $this->resourcePaginated(UserResource::collection($Users));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create_user', User::class);
        $fieldInputs = $request->validated();
        $User        = $this->UserService->createUser($fieldInputs);
        return parent::successResponse('User',new UserResource($User), "User Created Successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $User)
    {
        return parent::successResponse('user',new UserResource($User),"User retrived successfully" , 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $User)
    {
        $this->authorize('edit_user', User::class);
        $fieldInputs = $request->validated();
        $User        = $this->UserService->updateUser($fieldInputs, $User);
        return parent::successResponse('user',new UserResource($User), "User Updated Successfully", 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $User)
    {
        $this->authorize('delete_user', User::class);
        $this->UserService->deleteUser($User);
        return parent::successResponse('user',null, "User Deleted Successfully",200);
    }
}
