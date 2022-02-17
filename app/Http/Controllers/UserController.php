<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
      public function index()
      {
            return view('user.profil', [
                  'data' => Auth::user()
            ]);
      }

      public function list(User $user)
      {
            return view('user.lists', [
                  'data' => $user->all()
            ]);
      }

      public function userdetail(User $user)
      {
            return view('user.profil', [
                  'data' => $user
            ]);
      }

      public function create()
      {
            if (auth()->user()->role !== 'Monitoring') {
                  abort(403);
            }

            return view('user.create');
      }

      public function daftar(Request $request)
      {
            if (auth()->user()->role !== 'Monitoring') {
                  abort(403);
            }

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

            if ($request->file('user_profile')) {
                  $gambar = $request->file('user_profile');
                  $file_name = time() . '_' . $gambar->getClientOriginalName();
                  $img = Image::make($gambar);
                  $img->save(\public_path("images/$file_name"), 20, 'jpg');
                  $validatedData['user_profile'] = $file_name;
            }

            User::create($validatedData);

            // return $request;
            return redirect('/user/tambah')->with('success', 'User berhasil ditambah!');
      }

      public function edit()
      {
            return view('user.edit', [
                  'data' => Auth::user()
            ]);
      }

      public function useredit(User $user)
      {
            return view('user.edit', [
                  'data' => $user
            ]);
      }

      public function update(Request $request, User $user)
      {
            $validatedData = $request->validate([
                  'nama' => 'required|max:40',
                  'nip' => 'required',
            ]);

            $validatedData['nomor_telepon'] = $request->nomor_telepon;
            $validatedData['gender'] = $request->gender;
            $validatedData['email'] = $request->email;

            if ($request->file('user_profile')) {
                  if ($user->user_profile && $user->user_profile !== 'user.png') {
                        File::delete(public_path('/images/' . $user->user_profile));
                  }
                  $gambar = $request->file('user_profile');
                  $file_name = time() . '_' . $gambar->getClientOriginalName();
                  $img = Image::make($gambar);
                  $img->save(\public_path("images/$file_name"), 20, 'jpg');
                  $validatedData['user_profile'] = $file_name;
            }

            if ($request->hidden == 'profil') {
                  User::where('id', Auth::user()->id)->update($validatedData);
                  return redirect(route('profil.edit'))->with('success', 'Berhasil di edit!');
            }

            User::where('id', $user->id)->update($validatedData);
            return redirect(route('users.edit', $user->username))->with('success', 'Berhasil di edit!');
      }

      public function update_password(Request $request, User $user)
      {
            $this->validate($request, [
                  'password' => 'required|confirmed',
            ]);

            $user->password = bcrypt($request->password);
            $user->update();

            return redirect()->back()->with('status', 'Password berhasil di edit!');
      }

      public function delete($id)
      {
            $data = User::find($id);
            $nama = $data->nama;
            $data->delete();

            // return $nama;
            return redirect('/users')->with('success', 'Berhasil menghapus user ' . $nama . '.');
      }
}
