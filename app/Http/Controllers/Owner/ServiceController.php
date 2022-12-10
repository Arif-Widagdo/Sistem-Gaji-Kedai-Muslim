<?php

namespace App\Http\Controllers\Owner;

use Ramsey\Uuid\Uuid;
use App\Models\Service;
use App\Models\Category;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('owner.service_management.index', [
            'services' => Service::latest()->get(),
            'positions' => Position::all(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'id_position' => ['required'],
            'id_category' => ['required'],
            'sallary' => ['required', 'min:0']
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray(), 'msg' => 'Kurang Lengkap']);
        } else {
            $store = Service::create([
                'id' => Uuid::uuid4()->toString(),
                'id_position' => $request->id_position,
                'id_category' => $request->id_category,
                'sallary' => $request->sallary
            ]);
            if (!$store->save()) {
                return response()->json(['status' => 0, 'msg' => 'Something Wrong']);
            } else {
                return response()->json(['status' => 1, 'msg' => 'Success']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $delete = Service::destroy($service->id);

        if ($delete) {
            return redirect()->back()->with('success', 'Success');
        } else {
            return redirect()->back()->with('error', 'Failed');
        }
    }
}
