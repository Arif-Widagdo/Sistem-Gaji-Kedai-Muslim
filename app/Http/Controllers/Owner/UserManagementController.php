<?php

namespace App\Http\Controllers\Owner;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Position;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('owner.users_management.index', [
            'users' => User::where('id', '!=', auth()->user()->id)->latest()->get(),
            'positions' => Position::all()
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'id_position' => ['required'],
            'gender' => ['required', 'in:M,F',],
            'telp' => ['string', 'max:15', 'nullable'],
            'address' => ['string', 'max:255', 'nullable'],
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray(), 'msg' => __('Please complete the input on the form provided')]);
        } else {
            $path = 'storage/img/users/';
            $fontPath = public_path('dist/fonts/Nunito-ExtraBold.ttf');
            $char = strtoupper($request->name[0]);
            $newAvatarName = rand(12, 34353) . time() . '_avatar.png';
            $dest = $path . $newAvatarName;

            $createAvatar = makeAvatar($fontPath, $dest, $char);
            $picture = $createAvatar == true ? $newAvatarName : '';

            $telp = $request->telp;
            if ($telp) {
                if ($request->telp[0] == 0) {
                    $telp = '62' . substr($request->telp, strlen(0));
                } else if ($request->telp[0] == 8) {
                    $telp = '62' . $request->telp;
                }
            }

            $user = User::create([
                'id' => Uuid::uuid4()->toString(),
                'name' => $request->name,
                'email' => $request->email,
                'id_position' => $request->id_position,
                'telp' => $telp,
                'address' => $request->address,
                'status_act' => 1,
                'gender' => $request->gender,
                'picture' => $picture,
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
            ]);

            if (!$user->save()) {
                return response()->json(['status' => 0, 'msg' => __('Somethin went Wrong, creating user')]);
            } else {
                return response()->json(['status' => 1, 'msg' => __('Registration user successfully')]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $query = User::find($user->id)->update([
            'id_position' => $request->id_position,
            'status_act' => $request->status_act,
        ]);

        if ($query) {
            return redirect()->back()->with('success', __('User successfully updated'));
        } else {
            return redirect()->back()->with('error', __('User failed update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $path = 'storage/img/users/';
        $oldPicture = User::find($user->id)->getAttributes()['picture'];
        if ($user->picture != '') {
            if (File::exists(public_path($path . $oldPicture))) {
                File::delete(public_path($path . $oldPicture));
            }
        }

        $delete = User::find($user->id)->delete();

        if ($delete) {
            return redirect()->back()->with('success', __('User successfully deleted'));
        } else {
            return redirect()->back()->with('error', __('User failed deleted'));
        }
    }

    public function deleteAll(Request $request)
    {
        if ($request->ids != '') {
            $path = 'storage/img/users/';
            $users = User::find($request->ids);
            foreach ($users as $user) {

                $oldPicture = $user->getAttributes()['picture'];
                if ($oldPicture != '') {
                    if (File::exists(public_path($path . $oldPicture))) {
                        File::delete(public_path($path . $oldPicture));
                    }
                }
            }
        }
        $delete = User::destroy($request->ids);
        if ($delete) {
            return redirect()->back()->with('success', __('User successfully deleted'));
        } else {
            return redirect()->back()->with('error', __('User failed deleted'));
        }
    }
}
