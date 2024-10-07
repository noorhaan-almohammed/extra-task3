<?php
namespace App\Http\Services;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserService
{

    /**
     * list all Users information
     */
    public function listUser()
    {
         return User::paginate();
    }

    public function getUserWithHisBooks(int $perPage,$user_id)
    {
        try {
            $user = User::findOrFail($user_id);
            return $user::with('userBooks')->paginate($perPage);
        } catch (Exception $e) {
            Log::error('Error Founding Users' . $e->getMessage());
            throw new Exception('There is something wrong with server');
        }
    }

    /**
     * Create a new User.
     * @param array $fieldInputs
     * @return \App\Models\User
     */
    public function createUser(array $fieldInputs)
    {
        try {
        $user = User::create([
                'name' => $fieldInputs["name"],
                'email' => $fieldInputs["email"],
                'password' => $fieldInputs["password"],
            ]);
       $fieldInputs["role_id"] ??= 3;
       $user->roles()->attach($fieldInputs["role_id"]);
       return $user;
        } catch (Exception $e) {
            Log::error('Error Creating User' . $e->getMessage());
            throw new Exception('There is something wrong with server');
        }
    }


    /**
     * Get the details of a specific User.
     *
     * @param \App\Models\User $User
     * @return \App\Models\User
     */
    public function getUser(User $User)
    {
        try {
            return $User;
        } catch (Exception $e) {
            Log::error('Error retrieving User: ' . $e->getMessage());
            throw new Exception('Error retrieving User.');
        }
    }

    /**
     * Update a specific User.
     *
     * @param array $fieldInputs
     * @param User $User
     * @return \App\Models\User
     */
    public function updateUser(array $fieldInputs, $User)
    {
        try {
            $User->update(array_filter($fieldInputs));
            return $User;
        } catch (Exception $e) {
            Log::error('Error updating User: ' . $e->getMessage());
            throw new Exception('Error Updating User.');
        }
    }

    /**
     * Delete a specific User.
     *
     * @param User $User
     * @return void
     */
    public function deleteUser($User)
    {
        try {
            $User->delete();
        } catch (Exception $e) {
            Log::error('Error deliting User: ' . $e->getMessage());
            throw new Exception('Error deleting User.');
        }
    }
}
