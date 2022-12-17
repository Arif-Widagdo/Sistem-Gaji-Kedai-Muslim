<?php

namespace App\Http\Controllers\Owner;

use Ramsey\Uuid\Uuid;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Cviebrock\EloquentSluggable\Services\SlugService;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('owner.category.index', [
            'categories' => Category::latest()->get()
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
            'name' => ['required', 'string', 'max:20', 'unique:categories'],
            'slug' => ['required', 'string',  'max:255', 'unique:categories'],
        ]);
        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray(), 'msg' => __('Please complete the input on the form provided')]);
        } else {
            $store = Category::create([
                'id' => Uuid::uuid4()->toString(),
                'name' => Str::ucfirst($request->name),
                'slug' => $request->slug,
            ]);
            if (!$store->save()) {
                return response()->json(['status' => 0, 'msg' => __('Something went wrong while creating a new category')]);
            } else {
                return response()->json(['status' => 1, 'msg' => __('New Category Created Successfully')]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if ($request->slug != $category->slug) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:20', 'unique:categories'],
                'slug' => ['required', 'string',  'max:255', 'unique:categories'],
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:20'],
                'slug' => ['required', 'string',  'max:255'],
            ]);
        }

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray(), 'msg' => __('Please complete the input on the form provided')]);
        } else {
            $update = Category::find($category->id)->update([
                'name' => $request->name,
                'slug' => $request->slug,
            ]);

            if (!$update) {
                return response()->json(['status' => 0, 'msg' => __('Something went wrong when updating positions')]);
            } else {
                return response()->json(['status' => 1, 'msg' => __('Category edited successfully')]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $delete = Category::destroy($category->id);

        if ($delete) {
            return redirect()->back()->with('success', __('Category successfully deleted'));
        } else {
            return redirect()->back()->with('error', __('Failed category deleted'));
        }
    }

    public function deleteAll(Request $request)
    {
        $delete = Category::destroy($request->ids);
        if ($delete) {
            return redirect()->back()->with('success', __('The selected category successfully deleted'));
        } else {
            return redirect()->back()->with('error', __('The selected category failed to delete'));
        }
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Category::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
