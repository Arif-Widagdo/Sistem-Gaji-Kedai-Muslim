<?php

namespace App\Http\Controllers\Owner;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Product;
use App\Models\Sallary;
use App\Models\Service;
use App\Models\Category;
use App\Models\Position;
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
            'sallaries' => Sallary::orderBy('periode', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $owner = Position::where('slug', '=', 'owner')->first();
        $workers = User::where('id_position', '!=', $owner->id)->get();

        $status = '';
        $user = [];
        $products = [];
        $services = [];
        $totalCost = 0;
        $quantity = 0;

        if (request('email') && request('periode')) {
            $temp = explode('-', request('periode'));
            $user = User::where('email', '=', request('email'))->first();

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
            'sallaryMonth' =>  Carbon::parse(request('periode'))->translatedFormat('F Y'),
            'workers' => $workers,
            'user' => $user,
            'products' => $products,
            'status' => $status,
            'categories' => $categories,
            'services' => $services,
            'totalCost' => $totalCost,
            'quantity' => $quantity,
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
        $rules = ([
            'id_user' => ['required'],
            'periode' => ['required'],
            'quantity' => ['required'],
            'total' => ['required'],
        ]);
        $validatedData = $request->validate($rules);

        if (!$validatedData) {
            return redirect()->back()->with('error', __('Wait a few minutes to try again '));
        }

        $temp = explode('-', $request->periode);

        $exists = Sallary::where('id_user', $request->id_user)
            ->whereMonth('periode',  $temp[1])
            ->whereYear('periode',  $temp[0])
            ->first();

        if ($exists) {
            return redirect()->back()->with('info', __('Sallary Mail is Already and has been Receving'));
        }

        // -------- Buat Invoice Email
        $user = User::where('id', $request->id_user)->first();

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
            'sallaryMonth' => $sallaryMonth,
            'user' => $user,
            'products' => $products,
            'categories' => $categories,
            'services' => $services,
            'quantity' => $quantity,
            'totalCost' => $totalCost,
        ];

        Mail::to($user->email)->send(new SallaryMail($isi_email));

        $times = explode('-', now());
        $time = $request->periode . '-' . $times[2];

        $store = Sallary::create([
            'id' => Uuid::uuid4()->toString(),
            'id_user' => $request->id_user,
            'periode' => $time,
            'quantity' => $request->quantity,
            'total' => $request->total,
            'payroll_time' => now(),
        ]);

        if (!$store->save()) {
            return redirect()->back()->with('error', __('Sallary Mail Failed to Receve'));
        } else {
            return redirect()->route('owner.sallary.index')->with('success', __('Sallary Mail Receving is Done'));
        }
    }

    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'id_user' => ['required'],
    //         'periode' => ['required'],
    //         'quantity' => ['required'],
    //         'total' => ['required'],
    //     ]);

    //     if (!$validator->passes()) {
    //         return response()->json(['status' => 0, 'error' => $validator->errors()->toArray(), 'msg' => __('Wait a few minutes to try again ')]);
    //     } else {
    //         $temp = explode('-', $request->periode);

    //         $exists = Sallary::where('id_user', $request->id_user)
    //             ->whereMonth('periode',  $temp[1])
    //             ->whereYear('periode',  $temp[0])
    //             ->first();

    //         if ($exists) {
    //             return response()->json(['status' => 'exists', 'msg' => __('Sallary Mail is Already and has been Receving')]);
    //         } else {
    //             // -------- Buat Invoice Email
    //             $user = User::where('id', $request->id_user)->first();

    //             $products = Product::where('id_user', $user->id)
    //                 ->whereMonth('completed_date',  $temp[1])
    //                 ->whereYear('completed_date',  $temp[0])
    //                 ->orderBy('name', 'ASC')->get(['quantity', 'id_category'])->groupBy(function ($item) {
    //                     return $item->id_category;
    //                 });

    //             $services = Service::where('id_position',  $user->id_position)->get(['id_category', 'sallary']);

    //             // ----- Hitung Gaji
    //             $productCost  = Product::where('id_user', $user->id)
    //                 ->whereMonth('completed_date', $temp[1])
    //                 ->whereYear('completed_date', $temp[0])->get(['quantity', 'id_category']);

    //             $quantity = $productCost->sum('quantity');
    //             $totalCost = 0;

    //             foreach ($productCost as $product) {
    //                 foreach ($services->where('id_category', '=', $product->category->id) as  $service) {
    //                     $sallary = $product->quantity * $service->sallary;
    //                     $totalCost += $sallary;
    //                 }
    //             }

    //             // return $user;
    //             $categories = Category::all();
    //             $sallaryMonth = Carbon::parse($request->periode)->translatedFormat('F Y');


    //             $isi_email = [
    //                 'sallaryMonth' => $sallaryMonth,
    //                 'user' => $user,
    //                 'products' => $products,
    //                 'categories' => $categories,
    //                 'services' => $services,
    //                 'quantity' => $quantity,
    //                 'totalCost' => $totalCost,
    //             ];

    //             Mail::to($user->email)->send(new SallaryMail($isi_email));

    //             $times = explode('-', now());
    //             $time = $request->periode . '-' . $times[2];

    //             $store = Sallary::create([
    //                 'id' => Uuid::uuid4()->toString(),
    //                 'id_user' => $request->id_user,
    //                 'periode' => $time,
    //                 'quantity' => $request->quantity,
    //                 'total' => $request->total,
    //                 'payroll_time' => now(),
    //             ]);

    //             if (!$store->save()) {
    //                 return response()->json(['status' => 0, 'msg' => __('Sallary Mail Failed to Receve')]);
    //             } else {
    //                 return response()->json(['status' => 1, 'msg' => __('Sallary Mail Receving is Done')]);
    //             }
    //         }
    //     }
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sallary  $sallary
     * @return \Illuminate\Http\Response
     */
    public function show(Sallary $sallary)
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

        $categories = Category::all();
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
        // return $sallary->periode;
        // return $products;

        return view('owner.sallary.show', [
            'sallaryMonth' => $sallary->periode,
            'periode' => $temp[1] . '-' . $month,
            'user' => $user,
            'products' => $products,
            'categories' => $categories,
            'services' => $services,
            'quantity' => $quantity,
            'totalCost' => $totalCost
        ]);
        // return $sallary;
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
            return redirect()->back()->with('success', __('Sallary has been deleted'));
        } else {
            return redirect()->back()->with('error', __('Failed to delete data'));
        }
    }

    public function print()
    {
        $status = '';
        $user = [];
        $products = [];
        $services = [];
        $totalCost = 0;
        $quantity = 0;

        if (request('email') && request('periode')) {
            $user = User::where('email', '=', request('email'))->first();
            $temp = explode('-', request('periode'));


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


        return view('print.invoice_print', [
            'sallaryMonth' =>  Carbon::parse(request('periode'))->translatedFormat('F Y'),
            'workers' => User::all(),
            'user' => $user,
            'products' => $products,
            'status' => $status,
            'categories' => $categories,
            'services' => $services,
            'totalCost' => $totalCost,
            'quantity' => $quantity,
        ]);
    }

    public function deleteAll(Request $request)
    {
        $delete = Sallary::destroy($request->ids);
        if ($delete) {
            return redirect()->back()->with('success', __('Sallary has been deleted'));
        } else {
            return redirect()->back()->with('error', __('Failed to delete data'));
        }
    }
}
