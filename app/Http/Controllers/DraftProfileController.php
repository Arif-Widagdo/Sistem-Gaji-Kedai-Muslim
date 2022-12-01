<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        return view('settingsAccount', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request)
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






        // $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        // $request->user()->save();

        // return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
