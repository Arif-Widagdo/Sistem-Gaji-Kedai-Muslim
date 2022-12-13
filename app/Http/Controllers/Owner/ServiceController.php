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
            $exists = Service::where('id_position', $request->id_position)->where('id_category', $request->id_category)->first();

            if ($exists) {
                return response()->json(['status' => 'exists', 'msg' => 'Data Sudah Ada']);
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

        $validator = Validator::make($request->all(), [
            'id_position' => ['required'],
            'id_category' => ['required'],
            'sallary' => ['required', 'min:0']
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray(), 'msg' => __('Please complete the input on the form provided')]);
        } else {

            $exists = Service::where('id_position', $request->id_position)->where('id_category', $request->id_category)->first();

            if ($exists) {
                return response()->json(['status' => 'exists', 'msg' => 'Data Sudah Ada']);
            } else {
                $update = Service::find($service->id)->update([
                    'id_position' => $request->id_position,
                    'id_category' => $request->id_category,
                    'sallary' => $request->sallary
                ]);
                if (!$update) {
                    return response()->json(['status' => 0, 'msg' => 'Something Wrong']);
                } else {
                    return response()->json(['status' => 1, 'msg' => 'Success']);
                }
            }
        }
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


    public function deleteAll(Request $request)
    {
        $delete = Service::destroy($request->ids);
        if ($delete) {
            return redirect()->back()->with('success', 'Success');
        } else {
            return redirect()->back()->with('error', 'Error');
        }
    }
}
