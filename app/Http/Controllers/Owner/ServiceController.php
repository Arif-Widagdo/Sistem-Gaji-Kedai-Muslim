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
        $request->merge([
            'sallary' => preg_replace('/\D/', '', $request->sallary),
        ]);

        $validator = Validator::make($request->all(), [
            'id_position' => ['required'],
            'id_category' => ['required'],
            'sallary' => ['required', 'max:50', 'min:3']
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray(), 'msg' => __('Please complete the input on the form provided')]);
        } else {
            $exists = Service::where('id_position', $request->id_position)->where('id_category', $request->id_category)->first();

            if ($exists) {
                return response()->json(['status' => 'exists', 'msg' => __('The data has already been taken')]);
            } else {
                $store = Service::create([
                    'id' => Uuid::uuid4()->toString(),
                    'id_position' => $request->id_position,
                    'id_category' => $request->id_category,
                    'sallary' => $request->sallary
                ]);
                if (!$store->save()) {
                    return response()->json(['status' => 0, 'msg' => __('Data Failed to Add')]);
                } else {
                    return response()->json(['status' => 1, 'msg' => __('Data Added Successfully')]);
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
        $request->merge([
            'sallary' => preg_replace('/\D/', '', $request->sallary),
        ]);

        $validator = Validator::make($request->all(), [
            'id_position' => ['required'],
            'id_category' => ['required'],
            'sallary' => ['required', 'max:50', 'min:3']
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray(), 'msg' => __('Please complete the input on the form provided')]);
        } else {

            if ($request->id_position != $service->id_position || $request->id_category != $service->id_category) {
                $exists = Service::where('id_position', $request->id_position)->where('id_category', $request->id_category)->first();
                if ($exists) {
                    return response()->json(['status' => 'exists', 'msg' => __('The data has already been taken')]);
                }
            }

            $update = Service::find($service->id)->update([
                'id_position' => $request->id_position,
                'id_category' => $request->id_category,
                'sallary' => $request->sallary
            ]);
            if (!$update) {
                return response()->json(['status' => 0, 'msg' => __('Data Update Failed')]);
            } else {
                return response()->json(['status' => 1, 'msg' => __('Data Updated Successfully')]);
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
            return redirect()->back()->with('success', __('Data deleted successfully'));
        } else {
            return redirect()->back()->with('error', __('Failed to delete data'));
        }
    }


    public function deleteAll(Request $request)
    {
        $delete = Service::destroy($request->ids);
        if ($delete) {
            return redirect()->back()->with('success', __('Data deleted successfully'));
        } else {
            return redirect()->back()->with('error', __('Failed to delete data'));
        }
    }
}
