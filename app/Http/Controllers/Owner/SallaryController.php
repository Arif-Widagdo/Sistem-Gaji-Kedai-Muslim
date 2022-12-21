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
        // $isi_email = [
        //     'title' => 'Invoices Desember Pengguna',
        //     'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui totam vero quas hic voluptatem sed amet cumque placeat et animi quasi veniam earum aut harum dignissimos doloremque quaerat, beatae dicta facilis accusantium dolorum atque reprehenderit doloribus velit. Maxime, ipsa? Excepturi nulla consequatur quos? Provident illo fuga repellendus, ducimus ut qui. Quod commodi impedit debitis. Assumenda error illum dolores magni quae numquam vitae exercitationem corrupti necessitatibus modi, enim, distinctio deleniti dolor tenetur debitis possimus aspernatur aliquid ullam ratione ipsam quia repellat nostrum nulla. Iste dolorum libero perspiciatis obcaecati quod, labore adipisci molestias earum fugiat inventore. Eius, voluptas? Quasi autem suscipit dolores.'
        // ];

        // $title = '';
        // $mail = Mail::to('sistemgaji.km@gmail.com')->send(new SallaryMail($isi_email));

        // if ($mail) {
        //     $title = $title . 'Berhasil';
        // }

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
            'id_exist' => $id_exist
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
                $isi_email = [
                    'user' => $user,
                    'status' => $request->payment_status,
                    'products' => $products,
                    'categories' => $categories,
                    'services' => $services,
                    'quantity' => $quantity,
                    'totalCost' => $totalCost,
                ];

                // $title = 'Gagal';
                $mail = Mail::to($user->email)->send(new SallaryMail($isi_email));

                // if ($mail) {
                //     $title = 'Berhasil';
                // }

                // -----------------------

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
