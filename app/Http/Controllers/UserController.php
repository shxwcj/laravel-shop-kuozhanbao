<?php

namespace App\Http\Controllers;

use App\Http\Resources\Resource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return Resource::collection(User::query()->latest()->filter()->paginate($request->per_page ?:15));
    }
}
