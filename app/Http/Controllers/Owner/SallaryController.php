<?php

namespace App\Http\Controllers\Owner;

use App\Models\User;
use App\Models\Product;
use App\Models\Sallary;
use App\Mail\SallaryMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

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
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $month =  Carbon::parse($request->periode)->translatedFormat('F');
        $year =  Carbon::parse($request->periode)->translatedFormat('Y');

        $temp = explode('-', $request->periode);

        $user = User::where('id', $request->id_user)->first();
        $products = Product::where('id_user', $request->id_user)
            ->whereMonth('completed_date',  $temp[1])
            ->whereYear('completed_date',  $temp[0])
            ->orderBy('name', 'ASC')->get()->groupBy(function ($item) {
                return $item->id_category;
            });


        return $products;

        return view('owner.sallary.create', [
            'user' => $user
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
        // $isi_email = [
        //     'title' => 'Invoices Desember Pengguna',
        //     'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui totam vero quas hic voluptatem sed amet cumque placeat et animi quasi veniam earum aut harum dignissimos doloremque quaerat, beatae dicta facilis accusantium dolorum atque reprehenderit doloribus velit. Maxime, ipsa? Excepturi nulla consequatur quos? Provident illo fuga repellendus, ducimus ut qui. Quod commodi impedit debitis. Assumenda error illum dolores magni quae numquam vitae exercitationem corrupti necessitatibus modi, enim, distinctio deleniti dolor tenetur debitis possimus aspernatur aliquid ullam ratione ipsam quia repellat nostrum nulla. Iste dolorum libero perspiciatis obcaecati quod, labore adipisci molestias earum fugiat inventore. Eius, voluptas? Quasi autem suscipit dolores.'
        // ];

        // $title = '';
        // $mail = Mail::to('sistemgaji.km@gmail.com')->send(new SallaryMail($isi_email));

        // if ($mail) {
        //     $title = $title . 'Berhasil';
        // }

        // return view('owner.sallary.index', [
        //     'message' => $title
        // ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sallary  $sallary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sallary $sallary)
    {
        //
    }
}
