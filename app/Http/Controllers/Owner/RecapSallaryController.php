<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Sallary;
use Illuminate\Http\Request;

class RecapSallaryController extends Controller
{
    public function index()
    {
        $sallaries = Sallary::orderBy('periode', 'DESC')->get()->groupBy(function ($item) {
            return $item->periode;
        });

        return view('owner.recap_salary.index', [
            'sallaries' => $sallaries
        ]);
    }

    public function show($periode)
    {
        $temp = explode(' ',  $periode);

        $month = 0;
        if ($temp[0] == 'January' || $temp[0] == 'Januari') {
            $month = 1;
        } elseif ($temp[0] == 'February' || $temp[0] == 'Februari') {
            $month = 2;
        } elseif ($temp[0] == 'March' || $temp[0] == 'Maret') {
            $month = 3;
        } elseif ($temp[0] == 'April' || $temp[0] == 'April') {
            $month = 4;
        } elseif ($temp[0] == 'May' || $temp[0] == 'Mei') {
            $month = 5;
        } elseif ($temp[0] == 'June' || $temp[0] == 'Juni') {
            $month = 6;
        } elseif ($temp[0] == 'July' || $temp[0] == 'Juli') {
            $month = 7;
        } elseif ($temp[0] == 'August' || $temp[0] == 'Agustus') {
            $month = 8;
        } elseif ($temp[0] == 'September' || $temp[0] == 'September') {
            $month = 9;
        } elseif ($temp[0] == 'October' || $temp[0] == 'Oktober') {
            $month = 10;
        } elseif ($temp[0] == 'November' || $temp[0] == 'November') {
            $month = 1;
        } elseif ($temp[0] == 'December' || $temp[0] == 'Desember') {
            $month = 12;
        }

        $sallaries = Sallary::whereMonth('periode',  $month)->whereYear('periode',  $temp[1])->orderBy('periode', 'DESC')->get(['id', 'id_user', 'periode', 'payroll_time', 'quantity', 'total']);

        return view('owner.recap_salary.show', [
            'periode' => $periode,
            'sallaries' => $sallaries
        ]);
    }


    public function print($periode)
    {
        $temp = explode(' ',  $periode);

        $month = 0;
        if ($temp[0] == 'January' || $temp[0] == 'Januari') {
            $month = 1;
        } elseif ($temp[0] == 'February' || $temp[0] == 'Februari') {
            $month = 2;
        } elseif ($temp[0] == 'March' || $temp[0] == 'Maret') {
            $month = 3;
        } elseif ($temp[0] == 'April' || $temp[0] == 'April') {
            $month = 4;
        } elseif ($temp[0] == 'May' || $temp[0] == 'Mei') {
            $month = 5;
        } elseif ($temp[0] == 'June' || $temp[0] == 'Juni') {
            $month = 6;
        } elseif ($temp[0] == 'July' || $temp[0] == 'Juli') {
            $month = 7;
        } elseif ($temp[0] == 'August' || $temp[0] == 'Agustus') {
            $month = 8;
        } elseif ($temp[0] == 'September' || $temp[0] == 'September') {
            $month = 9;
        } elseif ($temp[0] == 'October' || $temp[0] == 'Oktober') {
            $month = 10;
        } elseif ($temp[0] == 'November' || $temp[0] == 'November') {
            $month = 1;
        } elseif ($temp[0] == 'December' || $temp[0] == 'Desember') {
            $month = 12;
        }

        $sallaries = Sallary::whereMonth('periode',  $month)->whereYear('periode',  $temp[1])->orderBy('periode', 'DESC')->get(['id', 'id_user', 'periode', 'payroll_time', 'quantity', 'total']);

        return view('print.recapt_print', [
            'periode' => $periode,
            'sallaries' => $sallaries
        ]);
    }
}
