<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StoreUserAdminRequest;
use App\Http\Requests\admin\UpdateUserAdminRequest;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class UsersAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::with('profileImage')->get();

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
        $validated = $request->validated();
        $user = User::create(
            [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'surname' => $validated['surname'],
                'phone_number' => $validated['phone_number'],
                'role' => $validated['role'],
                'password' => bcrypt($validated['password']),
            ]
        );

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('images/profile');
            $img = new Image(["filename" =>  "/storage/" . $imagePath]);
            $user->profileImage()->save($img);
        }

        return response()->json([
            "user" => $user,
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
        $user = User::with('profileImage')->find($user->id);

        return response()->json([
            "user" => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserAdminRequest $request
     * @param  User $user
     * @return JsonResponse
     */
    public function update(UpdateUserAdminRequest $request, User $user): JsonResponse
    {
        $validated = $request->validated();
        $user->update(
            [
                'name' => $validated['name'],
                'surname' => $validated['surname'],
                'phone_number' => $validated['phone_number'],
                'role' => $validated['role'],
            ]
        );

        if (isset($validated['password'])) {
            $user->password = bcrypt($validated['password']);
            $user->save();
        }

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('images/profile');
            $newImg = new Image(["filename" =>  "/storage/" . $imagePath]);
            if ($user->profileImage) {
                Storage::delete($user->profileImage->filename);
                $user->profileImage()->delete();
            }


            $user->profileImage()->save($newImg);
        }

        return response()->json([
            "user" => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            "message" => 'User has succesfully been deleted'
        ]);
    }
}
