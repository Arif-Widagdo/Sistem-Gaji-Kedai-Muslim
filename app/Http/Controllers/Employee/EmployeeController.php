<?php

namespace App\Http\Controllers\Employee;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        $products = Product::where('id_pengguna', auth()->user()->id)->get();

        return view('employee.dashboard', [
            'products' =>  $products,
            'services' => Service::where('id_position', '=', auth()->user()->userPosition->id)->get()
        ]);
    }
}
