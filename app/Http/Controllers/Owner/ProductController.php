<?php

namespace App\Http\Controllers\Owner;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('owner.product.index', [
            'products' => Product::latest()->get(),
            'users' => User::all(),
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
            'quantity' => preg_replace('/\D/', '', $request->quantity),
        ]);

        $validator = Validator::make($request->all(), [
            'id_category' => ['required'],
            'id_user' => ['required'],
            'name' => ['required', 'max:100'],
            'quantity' => ['required', 'max:50', 'min:1'],
            'completed_date' => ['required']
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray(), 'msg' => __('Please complete the input on the form provided')]);
        } else {

            $exists = Product::where('id_category', $request->id_category)
                ->where('id_user', $request->id_user)
                ->where('name', '=', Str::ucfirst($request->name))
                ->where('completed_date', '=', $request->completed_date)->first();

            if ($exists) {
                return response()->json(['status' => 'exists', 'msg' => __('The data has already been taken')]);
            } else {
                $store = Product::create([
                    'id' => Uuid::uuid4()->toString(),
                    'id_category' => $request->id_category,
                    'id_user' => $request->id_user,
                    'name' => Str::ucfirst($request->name),
                    'quantity' => $request->quantity,
                    'completed_date' => $request->completed_date
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->merge([
            'quantity' => preg_replace('/\D/', '', $request->quantity),
        ]);

        $validator = Validator::make($request->all(), [
            'id_category' => ['required'],
            'id_user' => ['required'],
            'name' => ['required', 'max:100'],
            'quantity' => ['required', 'max:50', 'min:1'],
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray(), 'msg' => __('Please complete the input on the form provided')]);
        } else {
            if ($request->id_category != $product->id_category || $request->id_user != $product->id_user || $request->name != $product->name) {
                $exists = Product::where('id_category', $request->id_category)
                    ->where('id_user', $request->id_user)
                    ->where('name', '=', Str::ucfirst($request->name))->first();
                if ($exists) {
                    return response()->json(['status' => 'exists', 'msg' => __('The data has already been taken')]);
                }
            }

            $update = Product::find($product->id)->update([
                'id_category' => $request->id_category,
                'id_user' => $request->id_user,
                'name' => Str::ucfirst($request->name),
                'quantity' => $request->quantity,
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $delete = Product::destroy($product->id);

        if ($delete) {
            return redirect()->back()->with('success', __('Data deleted successfully'));
        } else {
            return redirect()->back()->with('error', __('Failed to delete data'));
        }
    }

    public function deleteAll(Request $request)
    {
        $delete = Product::destroy($request->ids);
        if ($delete) {
            return redirect()->back()->with('success', __('Data deleted successfully'));
        } else {
            return redirect()->back()->with('error', __('Failed to delete data'));
        }
    }
}
