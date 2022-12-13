<?php

namespace App\Http\Controllers\Owner;

use App\Models\User;
use App\Models\Category;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OwnerController extends Controller
{
    public function index()
    {
        return view('owner.dashboard', [
            'positions' => Position::all(),
            'users' => User::where('id', auth()->user()->id)->get(),
            'category' => Category::all(),

        ]);
    }
}
