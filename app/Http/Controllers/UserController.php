<?php

namespace App\Http\Controllers;

use App\Http\Resources\Resource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function index(Request $request)
    {
        //数据缓存--Cache::remeber
        return Cache::remember(__METHOD__,5*60,function () use ($request){
            return Resource::collection(User::query()->latest()->filter()->paginate($request->per_page ?:15));
        });

        //扩展包watson/rememberable

    }
}
