<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouterController extends Controller
{
    public function dashboard()
    {
        if (Auth::user()->userPosition->name === 'Owner') {
            return redirect(route('owner.dashboard'));
        } else {
            return redirect(route('employee.dashboard'));
        }
    }

    public function profile()
    {
        if (Auth::user()->userPosition->name === 'Owner') {
            return redirect(route('owner.profile.edit'));
        } else {
            return redirect(route('employee.profile.edit'));
        }
    }
}
