<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * ユーザー詳細
     * @param string $id
     * @return Photo
     */
    public function show(string $id)
    {
        $user = User::where('id', $id)->first();

        return $user ?? abort(404);
    }
}
