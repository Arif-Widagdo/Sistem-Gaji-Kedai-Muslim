<?php

namespace App\Http\Controllers\Owner;

use DateTime;
use App\Models\User;
use App\Models\Product;
use App\Models\Sallary;
use App\Models\Category;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class OwnerController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // $year =  $now->year;
        $year =  2022;

        // $month = $now->month;
        $month =  12;

        $productionJan = Product::whereYear('completed_date', '=', $year)->whereMonth('completed_date', '=', 1)->get();
        $productionFeb = Product::whereYear('completed_date', '=', $year)->whereMonth('completed_date', '=', 2)->get();
        $productionMar = Product::whereYear('completed_date', '=', $year)->whereMonth('completed_date', '=', 3)->get();
        $productionApr = Product::whereYear('completed_date', '=', $year)->whereMonth('completed_date', '=', 4)->get();
        $productionMei = Product::whereYear('completed_date', '=', $year)->whereMonth('completed_date', '=', 5)->get();
        $productionJun = Product::whereYear('completed_date', '=', $year)->whereMonth('completed_date', '=', 6)->get();
        $productionJul = Product::whereYear('completed_date', '=', $year)->whereMonth('completed_date', '=', 7)->get();
        $productionAug = Product::whereYear('completed_date', '=', $year)->whereMonth('completed_date', '=', 8)->get();
        $productionSep = Product::whereYear('completed_date', '=', $year)->whereMonth('completed_date', '=', 9)->get();
        $productionOct = Product::whereYear('completed_date', '=', $year)->whereMonth('completed_date', '=', 10)->get();
        $productionNov = Product::whereYear('completed_date', '=', $year)->whereMonth('completed_date', '=', 11)->get();
        $productionDes = Product::whereYear('completed_date', '=', $year)->whereMonth('completed_date', '=', 12)->get();

        $salJan = Sallary::whereYear('periode', '=', $year)->whereMonth('periode', '=', 1)->get();
        $salFeb = Sallary::whereYear('periode', '=', $year)->whereMonth('periode', '=', 2)->get();
        $salMar = Sallary::whereYear('periode', '=', $year)->whereMonth('periode', '=', 3)->get();
        $salApr = Sallary::whereYear('periode', '=', $year)->whereMonth('periode', '=', 4)->get();
        $salMei = Sallary::whereYear('periode', '=', $year)->whereMonth('periode', '=', 5)->get();
        $salJun = Sallary::whereYear('periode', '=', $year)->whereMonth('periode', '=', 6)->get();
        $salJul = Sallary::whereYear('periode', '=', $year)->whereMonth('periode', '=', 7)->get();
        $salAug = Sallary::whereYear('periode', '=', $year)->whereMonth('periode', '=', 8)->get();
        $salSep = Sallary::whereYear('periode', '=', $year)->whereMonth('periode', '=', 9)->get();
        $salOct = Sallary::whereYear('periode', '=', $year)->whereMonth('periode', '=', 10)->get();
        $salNov = Sallary::whereYear('periode', '=', $year)->whereMonth('periode', '=', 11)->get();
        $salDes = Sallary::whereYear('periode', '=', $year)->whereMonth('periode', '=', 12)->get();

        $prodcution = Product::whereYear('completed_date', '=', $year)->get();
        $sallaries = sallary::whereYear('periode', '=', $year)->get();

        $salaryThisMonth =  Sallary::whereYear('periode', '=', $year)->whereMonth('periode', '=', $month)->get();
        $dateObj   = DateTime::createFromFormat('!m', $month);
        $monthName = Carbon::parse($dateObj)->translatedFormat('F');

        return view('owner.dashboard', [
            'prodcution' => $prodcution->sum('quantity'),
            'sallaries' => $sallaries->sum('total'),
            'salaryThisMonth' => $salaryThisMonth->sum('total'),
            'year' =>  $year,
            'month' => $monthName,

            'prodJan' => $productionJan->sum('quantity'),
            'prodFeb' => $productionFeb->sum('quantity'),
            'prodMar' => $productionMar->sum('quantity'),
            'prodApr' => $productionApr->sum('quantity'),
            'prodMei' => $productionMei->sum('quantity'),
            'prodJun' => $productionJun->sum('quantity'),
            'prodJul' => $productionJul->sum('quantity'),
            'prodAug' => $productionAug->sum('quantity'),
            'prodSep' => $productionSep->sum('quantity'),
            'prodOct' => $productionOct->sum('quantity'),
            'prodNov' => $productionNov->sum('quantity'),
            'prodDes' => $productionDes->sum('quantity'),



            'salJan' => $salJan->sum('total'),
            'salFeb' => $salFeb->sum('total'),
            'salMar' => $salMar->sum('total'),
            'salApr' => $salApr->sum('total'),
            'salMei' => $salMei->sum('total'),
            'salJun' => $salJun->sum('total'),
            'salJul' => $salJul->sum('total'),
            'salAug' => $salAug->sum('total'),
            'salSep' => $salSep->sum('total'),
            'salOct' => $salOct->sum('total'),
            'salNov' => $salNov->sum('total'),
            'salDes' => $salDes->sum('total'),
        ]);
    }
}
