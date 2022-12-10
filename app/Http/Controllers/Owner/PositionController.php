<?php

namespace App\Http\Controllers\Owner;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Position;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('owner.position_management.index', [
            'positions' => Position::where('name', '!=', 'Owner')->latest()->get()
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
            'name' => ['required', 'string', 'max:20', 'unique:positions'],
            'slug' => ['required', 'string',  'max:255', 'unique:positions'],
            'status_act' => ['required'],
        ]);
        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray(), 'msg' => __('Please complete the input on the form provided')]);
        } else {
            $store = Position::create([
                'id' => Uuid::uuid4()->toString(),
                'name' => Str::ucfirst($request->name),
                'slug' => $request->slug,
                'status_act' => $request->status_act,
            ]);
            if (!$store->save()) {
                return response()->json(['status' => 0, 'msg' => __('Something went wrong while creating a new position')]);
            } else {
                return response()->json(['status' => 1, 'msg' => __('New Position Created Successfully')]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        return view('owner.position_management.details_positions', [
            'users_position' => User::where('id_position', $position->id)->latest()->get(),
            'position' => Position::where('id', $position->id)->first(),
            'positions' => Position::latest()->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        if ($request->slug != $position->slug) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:20', 'unique:positions'],
                'slug' => ['required', 'string',  'max:255', 'unique:positions'],
                'status_act' => ['required'],
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:20'],
                'slug' => ['required', 'string',  'max:255'],
                'status_act' => ['required'],
            ]);
        }

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray(), 'msg' => __('Please complete the input on the form provided')]);
        } else {
            $update = Position::find($position->id)->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'status_act' => $request->status_act,
            ]);

            if (!$update) {
                return response()->json(['status' => 0, 'msg' => __('Something went wrong when updating positions')]);
            } else {
                return response()->json(['status' => 1, 'msg' => __('Position edited successfully')]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        $delete = Position::destroy($position->id);

        if ($delete) {
            return redirect()->back()->with('success', __('Position successfully deleted'));
        } else {
            return redirect()->back()->with('error', __('Failed position deleted'));
        }
    }

    public function deleteAll(Request $request)
    {
        $delete = Position::destroy($request->ids);
        if ($delete) {
            return redirect()->back()->with('success', __('The selected position successfully deleted'));
        } else {
            return redirect()->back()->with('error', __('The selected position failed to delete'));
        }
    }


    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Position::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
