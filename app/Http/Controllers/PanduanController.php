<?php

namespace App\Http\Controllers;

use App\Models\Urk;
use App\Models\Panduan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class PanduanController extends Controller
{
      public function update_panduan(Request $request, $id)
      {
            $input = Panduan::find($id);

            if ($request->hasFile('file')) {
                  if ($input->file) {
                        File::delete(public_path('/files/panduan/' . $input->file));
                  }
                  $file = $request->file('file');
                  $fileName = time() . '.' . $file->getClientOriginalName();
                  $file->move(public_path('files/panduan/'), $fileName);
                  $input->file = $fileName;
                  $input->update();
            } else {
                  $input->file = $input->file;
                  $input->update();
            }

            return redirect('/beranda/');
      }

      public function update_urk(Request $request, $id)
      {
            $input = Urk::find($id);

            if ($request->hasFile('file')) {
                  if ($input->file) {
                        File::delete(public_path('/files/urk/' . $input->file));
                  }
                  $file = $request->file('file');
                  $fileName = time() . '.' . $file->getClientOriginalName();
                  $file->move(public_path('/files/urk/'), $fileName);
                  $input->file = $fileName;
                  $input->update();
            } else {
                  $input->file = $input->file;
                  $input->update();
            }
            return redirect('/beranda/');

      }
}
