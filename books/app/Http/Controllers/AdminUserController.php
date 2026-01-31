<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return User::paginate(20);
    }

    public function show($id)
    {
        return User::with(['reviews', 'ratings', 'wishlists'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'bio', 'role']));
        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }

    public function ban($id)
    {
        $user = User::findOrFail($id);
        $user->banned = true;
        $user->save();
        return response()->json(['message' => 'User banned']);
    }

    public function unban($id)
    {
        $user = User::findOrFail($id);
        $user->banned = false;
        $user->save();
        return response()->json(['message' => 'User unbanned']);
    }

    public function promote($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'admin';
        $user->save();
        return response()->json(['message' => 'User promoted']);
    }

    public function demote($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'user';
        $user->save();
        return response()->json(['message' => 'User demoted']);
    }
}