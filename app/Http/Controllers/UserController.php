<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
        }
        abort(403, 'Unauthorized action.');
    }
}
