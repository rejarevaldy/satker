<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class RegisterController extends Controller
{
    public function reg()
    {
        return view('user.registrasi');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:40',
            'username' => 'required|unique:users',
            'nip' => 'required',
            'role' => 'required',
            'password' => 'required|max:20'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['nomor_telepon'] = $request->nomor_telepon;
        $validatedData['gender'] = $request->gender;
        $validatedData['email'] = $request->email;

        if($request->file('user_profile')) {
            $gambar = $request->file('user_profile');
            $file_name = time() . '_' . $gambar->getClientOriginalName();
            $img = Image::make($gambar);
            $img->save(\public_path("images/$file_name"), 20, 'jpg');
            $validatedData['user_profile'] = $file_name;
        }

        User::create($validatedData);

        // return $validatedData;
        return redirect('/login');
    }
}
