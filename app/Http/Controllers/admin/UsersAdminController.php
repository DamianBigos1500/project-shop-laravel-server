<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UsersAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::get();

        return response()->json([
            "users" => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserAdminRequest  $request
     * @return JsonResponse
     */
    public function store(StoreUserAdminRequest $request): JsonResponse
    {
        $user = User::create(
            [
                "id" => 1,
                'name' => 'Damian',
                'email' => 'w@w2.com',
                'email_verified_at' => now(),
                'password' => bcrypt("12345678"),
            ]
        );

        return response()->json([
            "user" => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            "user" => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        return response()->json([
            "user" => '$user'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return response()->json([
            "user" => '$user'
        ]);
    }
}
