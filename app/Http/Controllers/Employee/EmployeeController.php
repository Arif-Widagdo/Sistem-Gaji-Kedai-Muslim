<?php

namespace App\Http\Controllers\Employee;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        // $year =  $now->year;
        // $month =  $now->month;
        // $weekOfYear =  $now->weekOfYear;
        $month =  Carbon::parse($now)->translatedFormat('F Y');


        $products = Product::where('id_user', auth()->user()->id)
            ->whereMonth('completed_date', date('m'))
            ->whereYear('completed_date', date('Y'))
            ->orderBy('completed_date', 'DESC')->get()->groupBy(function ($item) {
                return $item->completed_date;
            });

        $services = Service::whereIdPosition(auth()->user()->userPosition->id)->get();


        // ----- Hitung Gaji
        $productSallaries = Product::where('id_user', auth()->user()->id)
            ->whereMonth('completed_date', date('m'))
            ->whereYear('completed_date', date('Y'))->get(['quantity', 'id_category']);

        $quantity = $productSallaries->sum('quantity');
        $totalCost = 0;

        foreach ($productSallaries as $product) {
            foreach ($services->where('id_category', '=', $product->category->id) as  $service) {
                $sallary = $product->quantity * $service->sallary;
                $totalCost += $sallary;
            }
        }


        return view('employee.dashboard', [
            'monthNow' => $month,
            'totalCost' => $totalCost,
            'quantityWorked' => $quantity,
            'products' =>  $products,
            'services' => $services
        ]);
    }
}
