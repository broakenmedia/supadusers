<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyUserRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $items_per_page = 10;
        $results = User::paginate($items_per_page);
        return response()->success($results->total() . ' users found across ' . $results->lastPage() . ' page/s', $results);
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->except(['password_confirm']);
        $validated['password'] = Hash::make($validated['password']);
        $user = User::firstOrCreate(['email' => $validated['email']], $validated);
        return response()->success('User created successfully', $user);
    }

    public function show(ShowUserRequest $request, int $userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'You have entered an invalid user id',
                'data' => []
            ]);
        }
        return response()->success('User found', $user);
    }

    public function update(UpdateUserRequest $request, int $userId)
    {
        $validated = $request->except(['password_confirm', 'id']);
        $user = User::find($userId);
        if (array_key_exists('password', $validated)) {
            $validated['password'] = Hash::make($validated['password']);
        }
        $user->update($validated);
        return response()->success('User edited successfully', $user->refresh());
    }

    public function destroy(DestroyUserRequest $request, int $userId)
    {
        $count = User::destroy($userId);
        if ($count <= 0) {
            return response()->failure('Unable to delete user', []);
        }
        return response()->success('User deleted successfully', []);
    }
}
