<?php

namespace App\Http\Controllers\Owner;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Product;
use App\Models\Sallary;
use App\Models\Service;
use App\Models\Category;
use App\Mail\SallaryMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SallaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('owner.sallary.index', [
            'users' => User::all(),
            'sallaries' => Sallary::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_exist = '';
        $status = '';
        $status_exist = '';
        $user = [];
        $products = [];
        $services = [];
        $totalCost = 0;
        $quantity = 0;

        if (request('email') && request('periode') && request('payment_status')) {
            $temp = explode('-', request('periode'));
            $user = User::where('email', '=', request('email'))->first();

            // Sudah Ada Gaji
            $exist = Sallary::where('id_user', $user->id)
                ->whereMonth('periode',  $temp[1])
                ->whereYear('periode',  $temp[0])
                ->first();

            if ($exist) {
                $status_exist = $exist->payment_status;
                $id_exist = $exist->id;
            }


            // ---------- Belom Ada Gaji
            $products = Product::where('id_user', $user->id)
                ->whereMonth('completed_date',  $temp[1])
                ->whereYear('completed_date',  $temp[0])
                ->orderBy('name', 'ASC')->get(['quantity', 'id_category'])->groupBy(function ($item) {
                    return $item->id_category;
                });

            $services = Service::where('id_position',  $user->id_position)->get(['id_category', 'sallary']);

            // ----- Hitung Gaji
            $productCost  = Product::where('id_user', $user->id)
                ->whereMonth('completed_date', $temp[1])
                ->whereYear('completed_date', $temp[0])->get(['quantity', 'id_category']);

            foreach ($productCost as $product) {
                foreach ($services->where('id_category', '=', $product->category->id) as  $service) {
                    $sallary = $product->quantity * $service->sallary;
                    $totalCost += $sallary;
                }
            }
            $quantity = $productCost->sum('quantity');
        } else {
            $status = __('Please complete the input on the form provided');
        }

        $categories = Category::all();

        return view('owner.sallary.created', [
            'workers' => User::all(),
            'user' => $user,
            'products' => $products,
            'status' => $status,
            'categories' => $categories,
            'services' => $services,
            'totalCost' => $totalCost,
            'quantity' => $quantity,
            'status_exist' => $status_exist,
            'id_exist' => $id_exist,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_user' => ['required'],
            'periode' => ['required'],
            'quantity' => ['required'],
            'total' => ['required'],
            'payment_status' => ['required'],
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray(), 'msg' => 'Kesalahan Internal']);
        } else {
            $temp = explode('-', $request->periode);
            $exists = Sallary::where('id_user', $request->id_user)
                ->whereMonth('periode',  $temp[1])
                ->whereYear('periode',  $temp[0])
                ->first();

            if ($exists) {
                return response()->json(['status' => 'exists', 'msg' => __('The data has already been taken')]);
            } else {
                // -------- Buat Invoice Email
                $periode = explode('-', $request->periode);
                $user = User::where('id', $request->id_user)->first();

                $products = Product::where('id_user', $user->id)
                    ->whereMonth('completed_date',  $periode[1])
                    ->whereYear('completed_date',  $periode[0])
                    ->orderBy('name', 'ASC')->get(['quantity', 'id_category'])->groupBy(function ($item) {
                        return $item->id_category;
                    });

                $services = Service::where('id_position',  $user->id_position)->get(['id_category', 'sallary']);

                // ----- Hitung Gaji
                $productCost  = Product::where('id_user', $user->id)
                    ->whereMonth('completed_date', $periode[1])
                    ->whereYear('completed_date', $periode[0])->get(['quantity', 'id_category']);

                $quantity = $productCost->sum('quantity');
                $totalCost = 0;

                foreach ($productCost as $product) {
                    foreach ($services->where('id_category', '=', $product->category->id) as  $service) {
                        $sallary = $product->quantity * $service->sallary;
                        $totalCost += $sallary;
                    }
                }
                // return $user;
                $categories = Category::all();
                $sallaryMonth = Carbon::parse($request->periode)->translatedFormat('F Y');
                $isi_email = [
                    'user' => $user,
                    'status' => $request->payment_status,
                    'products' => $products,
                    'categories' => $categories,
                    'services' => $services,
                    'quantity' => $quantity,
                    'totalCost' => $totalCost,
                    'sallaryMonth' => $sallaryMonth
                ];

                // $title = 'Gagal';
                if ($request->payment_status === 'paid') {
                    Mail::to($user->email)->send(new SallaryMail($isi_email));
                }

                $temp = explode('-', now());
                $time = $request->periode . '-' . $temp[2];

                $store = Sallary::create([
                    'id' => Uuid::uuid4()->toString(),
                    'id_user' => $request->id_user,
                    'periode' => $time,
                    'quantity' => $request->quantity,
                    'total' => $request->total,
                    'payment_status' => $request->payment_status,
                    'payroll_time' => now(),
                ]);

                if (!$store->save()) {
                    return response()->json(['status' => 0, 'msg' => 'Data Gaji Gagal Dikirim']);
                } else {
                    return response()->json(['status' => 1, 'msg' => 'Data Gaji Berhasil Dikirim']);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sallary  $sallary
     * @return \Illuminate\Http\Response
     */
    public function show(Sallary $sallary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sallary  $sallary
     * @return \Illuminate\Http\Response
     */
    public function edit(Sallary $sallary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sallary  $sallary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sallary $sallary)
    {
        $user = User::where('id', $sallary->id_user)->first();
        $temp = explode(' ',  $sallary->periode);
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

        $products = Product::where('id_user', $user->id)
            ->whereMonth('completed_date',  $month)
            ->whereYear('completed_date',  $temp[1])
            ->orderBy('name', 'ASC')->get(['quantity', 'id_category'])->groupBy(function ($item) {
                return $item->id_category;
            });

        $services = Service::where('id_position',  $user->id_position)->get(['id_category', 'sallary']);

        // ----- Hitung Gaji
        $productCost  = Product::where('id_user', $user->id)
            ->whereMonth('completed_date', $month)
            ->whereYear('completed_date', $temp[1])->get(['quantity', 'id_category']);

        $quantity = $productCost->sum('quantity');
        $totalCost = 0;

        foreach ($productCost as $product) {
            foreach ($services->where('id_category', '=', $product->category->id) as  $service) {
                $totalSallary = $product->quantity * $service->sallary;
                $totalCost += $totalSallary;
            }
        }

        $categories = Category::all();
        $isi_email = [
            'user' => $user,
            'status' => 'paid',
            'products' => $products,
            'categories' => $categories,
            'services' => $services,
            'quantity' => $quantity,
            'totalCost' => $totalCost,
            'sallaryMonth' => $sallary->periode
        ];

        Mail::to($user->email)->send(new SallaryMail($isi_email));

        $update = Sallary::find($sallary->id)->update([
            'payment_status' => 'paid',
        ]);

        if (!$update) {
            return redirect()->back()->with('error', 'Gagal Di Ubah');
        } else {
            return redirect()->route('owner.sallary.index')->with('success', 'Berhasil Di Ubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sallary  $sallary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sallary $sallary)
    {
        $delete = Sallary::destroy($sallary->id);

        if ($delete) {
            return redirect()->back()->with('success', 'Data Gaji Gagal Dihapus');
        } else {
            return redirect()->back()->with('error', 'Data Gaji Berhasil Dihapus');
        }
    }

    public function print()
    {
        $status_exist = '';
        $status = '';
        $user = [];
        $products = [];
        $services = [];
        $totalCost = 0;
        $quantity = 0;

        if (request('email') && request('periode') && request('payment_status')) {
            $user = User::where('email', '=', request('email'))->first();
            $temp = explode('-', request('periode'));

            // Sudah Ada Gaji
            $exist = Sallary::where('id_user', $user->id)
                ->whereMonth('periode',  $temp[1])
                ->whereYear('periode',  $temp[0])
                ->first();

            if ($exist) {
                $status_exist = $exist->payment_status;
            }

            $products = Product::where('id_user', $user->id)
                ->whereMonth('completed_date',  $temp[1])
                ->whereYear('completed_date',  $temp[0])
                ->orderBy('name', 'ASC')->get(['quantity', 'id_category'])->groupBy(function ($item) {
                    return $item->id_category;
                });

            $services = Service::where('id_position',  $user->id_position)->get(['id_category', 'sallary']);

            // ----- Hitung Gaji
            $productCost  = Product::where('id_user', $user->id)
                ->whereMonth('completed_date', $temp[1])
                ->whereYear('completed_date', $temp[0])->get(['quantity', 'id_category']);

            foreach ($productCost as $product) {
                foreach ($services->where('id_category', '=', $product->category->id) as  $service) {
                    $sallary = $product->quantity * $service->sallary;
                    $totalCost += $sallary;
                }
            }
            $quantity = $productCost->sum('quantity');

            // ------
        } else {
            $status = __('Please complete the input on the form provided');
        }

        $categories = Category::all();


        return view('print.invoice_print', [
            'workers' => User::all(),
            'user' => $user,
            'products' => $products,
            'status' => $status,
            'categories' => $categories,
            'services' => $services,
            'totalCost' => $totalCost,
            'quantity' => $quantity,
            'status_exist' => $status_exist
        ]);
    }
}
