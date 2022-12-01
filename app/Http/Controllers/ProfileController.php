<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('settingsAccount', [
            'user' => auth()->user(),
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'telp' => ['required', 'string', 'max:15'],
            'gender' => ['required', 'in:M,F'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray(), 'msg' => __('Something went wrong, updating personal information')]);
        } else {

            $telp = $request->telp;
            if ($request->telp[0] == 0) {
                $telp = '62' . substr($request->telp, strlen(0));
            }

            $updated = User::find(Auth::user()->id)->update([
                'name' => $request->name,
                'telp' => $telp,
                'gender' => $request->gender,
                'address' => $request->address
            ]);

            if (!$updated) {
                return response()->json(['status' => 0, 'msg' => __('Something went wrong, updating personal information')]);
            } else {
                return response()->json(['status' => 1, 'msg' => __('Your profile info has been updated successfully')]);
            }
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldpassword' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        return $fail(__('isIncorrectPassword'));
                    }
                },
                'min:6',
                'max:38'
            ],
            'newpassword' => 'required|min:8|max:38',
            'cnewpassword' => 'required|same:newpassword'
        ]);
        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray(), 'msg' => __('Something went wrong when changing the password')]);
        } else {
            $update = User::find(Auth::user()->id)->update(['password' => Hash::make($request->newpassword)]);

            if (!$update) {
                return response()->json(['status' => 0, 'msg' => __('Something went wrong when changing the password')]);
            } else {
                return response()->json(['status' => 1, 'msg' => __('Your password has been changed successfully')]);
            }
        }
    }

    public function updatePicture(Request $request)
    {
        $path = 'dist/img/users/';
        $file = $request->file('user_image');
        $new_name = 'UIMG_' . date('Ymd') . uniqid() . '.jpg';

        // upload new image
        $upload = $file->move(public_path($path), $new_name);

        if (!$upload) {
            return response()->json(['status' => 0, 'msg' => __('Something Wrong, At the time of uploading a new image!')]);
        } else {
            $oldPicture = User::find(Auth::user()->id)->getAttributes()['picture'];

            if ($oldPicture != '') {
                if (File::exists(public_path($path . $oldPicture))) {
                    File::delete(public_path($path . $oldPicture));
                }
            }

            $update = User::find(Auth::user()->id)->update(['picture' => $new_name]);

            if (!$update) {
                return response()->json(['status' => 0, 'msg' => __('Something Wrong, At the time of uploading a new image!')]);
            } else {
                return response()->json(['status' => 1, 'msg' => __('Your profile picture has been updated successfully')]);
            }
        }
    }

    function deletePicture()
    {
        $path = 'dist/img/users/';
        $oldPicture = User::find(Auth::user()->id)->getAttributes()['picture'];

        if ($oldPicture != '') {
            if (File::exists(public_path($path . $oldPicture))) {
                File::delete(public_path($path . $oldPicture));
            }
        }
        $deleted = User::find(Auth::user()->id)->update(['picture' =>  null]);



        // if (!$deleted) {
        //     return response()->json(['status' => 0, 'msg' => __('Something went wrong while deleting your profile picture')]);
        // } else {
        //     return response()->json(['status' => 1, 'msg' => __('Your profile picture has been deleted successfully')]);
        // }



        if (!$deleted) {
            return redirect()->back()->with('success', __('Something went wrong while deleting your profile picture'));
        } else {
            return redirect()->back()->with('success', __('Your profile picture has been deleted successfully'));
        }
    }
}
