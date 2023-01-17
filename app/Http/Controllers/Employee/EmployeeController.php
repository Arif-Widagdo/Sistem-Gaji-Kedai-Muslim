<?php

namespace App\Http\Controllers\Employee;

use DateTime;
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
        $year =  $now->year;
        // $year =  2022;
        $month = $now->month;
        // $month =  2;

        $products = Product::where('id_user', auth()->user()->id)
            ->whereMonth('completed_date', $month)
            ->whereYear('completed_date', $year)
            ->orderBy('completed_date', 'DESC')->get()->groupBy(function ($item) {
                return $item->completed_date;
            });

        $services = Service::whereIdPosition(auth()->user()->userPosition->id)->get();

        // ----- Hitung Gaji
        $productSallaries = Product::where('id_user', auth()->user()->id)
            ->whereMonth('completed_date', $month)
            ->whereYear('completed_date', $year)->get(['quantity', 'id_category']);

        $quantity = $productSallaries->sum('quantity');
        $totalCost = 0;

        foreach ($productSallaries as $product) {
            foreach ($services->where('id_category', '=', $product->category->id) as  $service) {
                $sallary = $product->quantity * $service->sallary;
                $totalCost += $sallary;
            }
        }
        $dateObj   = DateTime::createFromFormat('!m', $month);
        $monthName = Carbon::parse($dateObj)->translatedFormat('F');

        return view('employee.dashboard', [
            'monthNow' => $monthName,
            'totalCost' => $totalCost,
            'quantityWorked' => $quantity,
            'products' =>  $products,
            'services' => $services
        ]);
    }

    public function history()
    {
        $totalCost = 0;
        $quantity = 0;

        $products = [];
        $services = [];
        $from = '';
        $to = '';

        if (request('search')) {
            $temp = explode(' - ',  request('search'));
            $between = str_replace('/', '-', $temp);

            $fromDate =  Carbon::parse($between[0])->translatedFormat('l, d F Y');
            $toDate =  Carbon::parse($between[1])->translatedFormat('l, d F Y');

            $from = $fromDate;
            $to = $toDate;


            $products = Product::where('id_user', auth()->user()->id)
                ->whereBetween('completed_date', [$between[0], $between[1]])
                ->orderBy('completed_date', 'ASC')->get()->groupBy(function ($item) {
                    return $item->completed_date;
                });

            $services = Service::whereIdPosition(auth()->user()->userPosition->id)->get();


            // ----- Hitung Gaji
            $productSallaries = Product::where('id_user', auth()->user()->id)
                ->whereBetween('completed_date', [$between[0], $between[1]])
                ->orderBy('completed_date', 'ASC')->get(['quantity', 'id_category']);

            $quantity = $productSallaries->sum('quantity');

            foreach ($productSallaries as $product) {
                foreach ($services->where('id_category', '=', $product->category->id) as  $service) {
                    $sallary = $product->quantity * $service->sallary;
                    $totalCost += $sallary;
                }
            }
        }

        return view('employee.history', [
            // 'monthNow' => $month,
            'totalCost' => $totalCost,
            'quantityWorked' => $quantity,
            'products' =>  $products,
            'services' => $services,
            'from' => $from,
            'to' => $to
        ]);

        // return view('employee.history');
    }
}
