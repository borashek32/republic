<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ValidatePhotoRequest;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $users = User::all();

        } else {
            return redirect('/')
                ->with('error', 'You do not have permissions');
        }

        return view('dashboard.users.index', compact('users'));
    } 

    public function update(ValidatePhotoRequest $request, User $user)
    {
        if (Auth::user()->hasRole('admin')) {
            $photo = $request->file('photo');
            $path = $photo->store('profile-photos', [
                'disk' => 'public'
            ]);
            $user->profile_photo_path = $path;
            $user->save();

            return redirect('dashboard/users')
                ->with('success', 'User photo updated successfully');

        } else {
            return redirect('/')
                ->with('error', 'You do not have necessary permissions');
        }
    }
}
