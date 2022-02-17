<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OneInput;
use App\Models\TwoInput;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class InputController extends Controller
{

      public function __construct()
      {
            $this->middleware('auth');
      }

      public function index(User $user)
      {
            // $role = Auth::user()->role;
            // $user_id = Auth::user()->id;


            // if ($role == 'Monitoring') {
            //       $datas = OneInput::whereYear('created_at', '=', session('year'))->get();
            // } else {
            //       $datas = OneInput::whereYear('created_at', '=', session('year'))->where('user_id', $user_id)->get();
            // }

            // foreach ($oneinputs as $oneinput) {
            //       $id = $oneinput->id;

            //       $input = TwoInput::where('one_input_id', $id)->pluck('volume_capaian')->toArray();
            //       $oneinput = OneInput::find($id);
            //       $sum = array_sum($input);

            //       $oneinput->volume_jumlah = $sum;
            //       $oneinput->update();
            // }

            $users = $user->where('role', 'Satker')->get();


            return view('input.index', [
                  'data' => $users,
            ]);
      }

      public function list(User $user)
      {
            $oneinputs = OneInput::whereYear('created_at', session('year'))->where('user_id', $user->id)->get();

            foreach ($oneinputs as $oneinput) {
                  $id = $oneinput->id;

                  $input = TwoInput::where('one_input_id', $id)->pluck('volume_capaian')->toArray();
                  $oneinput = OneInput::find($id);
                  $sum = array_sum($input);

                  $oneinput->volume_jumlah = $sum;
                  $oneinput->update();
            }

            return view('input.list', [
                  'datas' => $oneinputs,
                  'user' => $user
            ]);
      }

      public function create()
      {
        return view('input.create');
      }

      public function store(Request $request)
      {
            $pagu = (int)str_replace([',', '.', 'Rp', ' '], '', $request->pagu);
            $rp = (int)str_replace([',', '.', 'Rp', ' '], '', $request->rp);

            $rvo = ($request->volume_jumlah / $request->volume_target);

            if ($rvo >= 3) {
                  $rvo_max = 3;
            } else {
                  $rvo_max = $rvo;
            }

            $capaian =  ($rp / $pagu);
            $sisa =  ($pagu - $rp);
            $user_id = Auth::user()->id;

            $input = new OneInput();

            // Manual
            $input->digit = $request->digit;
            $input->satuan = $request->satuan;
            $input->kd_kro = $request->kd_kro;
            $input->kd_ro = $request->kd_ro;
            $input->nama_ro = $request->nama_ro;
            $input->volume_target = $request->volume_target;
            $input->volume_jumlah = $request->volume_jumlah;
            $input->pagu = $pagu;
            $input->rp = $rp;

            // Otomatis
            $input->user_id = $user_id;
            $input->rvo = $rvo;
            $input->rvo_maksimal = $rvo_max;
            $input->capaian = $capaian;
            $input->sisa = $sisa;

            $input->save();

            return redirect()->back()->with('status', 'Laporan berhasil ditambahkan');
      }

      public function show(OneInput $oneinput)
      {
            $datas2 = TwoInput::where('one_input_id', $oneinput->id)->get();
            $role = auth()->user()->role;
            $user_id = auth()->user()->id;

            if ($role === 'Monitoring') {
                  $selection = OneInput::whereYear('created_at', session('year'))->get();
            } else {
                  $selection = OneInput::whereYear('created_at', session('year'))->where('user_id', $user_id)->get();
            }
            return view('input.show', [
                  'data' => $oneinput,
                  'datas2' => $datas2,
                  'selection' => $selection
            ]);
      }

      public function edit(OneInput $oneinput)
      {

            return view('input.edit', [
                  'data' => $oneinput,
            ]);
      }

      public function update(OneInput $oneinput, Request $request)
      {
            $pagu = (int)str_replace([',', '.', 'Rp', ' '], '', $request->pagu);
            $rp = (int)str_replace([',', '.', 'Rp', ' '], '', $request->rp);

            $rvo = ($request->volume_jumlah / $request->volume_target);

            if ($rvo >= 3) {
                  $rvo_max = 3;
            } else {
                  $rvo_max = $rvo;
            }

            $capaian =  ($rp / $pagu);
            $sisa =  ($pagu - $rp);

            // Manual

            $oneinput->digit = $request->digit;
            $oneinput->satuan = $request->satuan;
            $oneinput->kd_kro = $request->kd_kro;
            $oneinput->kd_ro = $request->kd_ro;
            $oneinput->nama_ro = $request->nama_ro;
            $oneinput->volume_target = $request->volume_target;
            $oneinput->volume_jumlah = $request->volume_jumlah;
            $oneinput->pagu = $pagu;
            $oneinput->rp = $rp;

            // Otomatis
            $oneinput->rvo = $rvo;
            $oneinput->rvo_maksimal = $rvo_max;
            $oneinput->capaian = $capaian;
            $oneinput->sisa = $sisa;

            $oneinput->update();

            return redirect()->with('status', 'Laporan admin berhasil diperbarui');
      }

      public function destroy(OneInput $oneinput)
      {
            $oneinput->delete();
            return redirect('/laporan');
      }

      // Dokumen

      public function index_dokumen()
      {
            $user = Auth()->user();

            $oneinputs = OneInput::whereYear('created_at', '=', session('year'))->where('user_id', $user->id);

            // Sum Volume capaian
            foreach ($oneinputs as $oneinput) {
                  $id = $oneinput->id;

                  $input = TwoInput::where('one_input_id', $id)->pluck('volume_capaian')->toArray();
                  $oneinput = OneInput::find($id);
                  $sum = array_sum($input);
                  $oneinput->volume_jumlah = $sum;
                  $oneinput->update();
            }

            ##### UMUM Section
            // GET Bidang
            $datas = $oneinputs->get();

            // Chart Anggaran
            $allPagu = [];
            $allRP = [];

            // Chart Output
            $allTarget = [];
            $allRP2 = [];

            // Loop data and push to an empty array above
            foreach ($datas as $data) {
                  array_push($allPagu, $data['pagu']);
                  array_push($allRP, $data['rp']);
                  array_push($allTarget, $data['volume_target']);
                  array_push($allRP2, $data['volume_jumlah']);
            }

            // Result Chart Anggaran
            if ($allPagu and $allRP) {
                  $resultPagu = array_sum($allPagu);
                  $resultRP = array_sum($allRP);

                  // Result Percentage Pie Chart Anggaran
                  $percentage = ($resultRP / $resultPagu) * 100;
                  $resultPercentage =  number_format(floor($percentage * 100) / 100, 1, '.', '');
            } else {
                  $resultPagu = 0;
                  $resultRP = 0;
                  $resultPercentage = 0;
            }

            // Result Chart Output
            if ($allTarget and $allRP2) {
                  $resultTarget = array_sum($allTarget);
                  $resultRP2 = array_sum($allRP2);

                  // Result Percentage Pie Chart Output
                  $percentage2 = ($resultRP2 / $resultTarget) * 100;
                  $resultPercentage2 =  number_format(floor($percentage2 * 100) / 100, 2, '.', '');
            } else {
                  $resultTarget = 0;
                  $resultRP2 = 0;
                  $resultPercentage2 = 0;
            }

            $sisa = $resultPagu - $resultRP;
            ##### end section

            // Sum Volume capaian
            $oneinputs = OneInput::whereYear('created_at', session('year'))->get();
            foreach ($oneinputs as $oneinput) {
                  $id = $oneinput->id;

                  $input = TwoInput::where('one_input_id', $id)->pluck('volume_capaian')->toArray();
                  $oneinput = OneInput::find($id);
                  $sum = array_sum($input);

                  $oneinput->volume_jumlah = $sum;
                  $oneinput->update();
            }

            $role = Auth::user()->role;
            $user_id = Auth::user()->id;

            if ($role === 'Monitoring') {
                  $selection = OneInput::whereYear('created_at', session('year'))->get();
                  $datas2 = TwoInput::whereYear('tanggal', session('year'))->join('one_inputs', 'two_inputs.one_input_id', 'one_inputs.id')
                        ->select(
                              'two_inputs.id',
                              'two_inputs.volume_capaian',
                              'two_inputs.uraian',
                              'two_inputs.nomor_dokumen',
                              'two_inputs.tanggal',
                              'two_inputs.one_input_id',
                              'two_inputs.file',
                              'one_inputs.nama_ro',
                        )
                        ->get();
            } else {
                  $selection = OneInput::whereYear('created_at', session('year'))->where('user_id', $user_id)->get();
                  $datas2 = TwoInput::whereYear('tanggal', session('year'))->join('one_inputs', 'two_inputs.one_input_id', 'one_inputs.id')
                        ->select(
                              'two_inputs.id',
                              'two_inputs.volume_capaian',
                              'two_inputs.uraian',
                              'two_inputs.nomor_dokumen',
                              'two_inputs.tanggal',
                              'two_inputs.one_input_id',
                              'two_inputs.file',
                              'one_inputs.nama_ro',
                        )
                        ->where('one_inputs.user_id', $user_id)
                        ->get();
            }

            // dd($datas2);
            return view('input.dokumen', [
                  'datas' => $selection,
                  'datas2' => $datas2,
                  'selection' => $selection,
                  'title' => 'Dokumen',
                  'user' => $user,
                  'pagu' => $resultPagu,
                  'rp' => $resultRP,
                  'rp2' => $resultRP2,
                  'sisa' => $sisa,
                  'percentage' => $resultPercentage,
                  'percentage2' => $resultPercentage2,
                  'target' => $resultTarget
            ]);
      }

      public function store_dokumen(Request $request)
      {
            $input2 = new TwoInput();
            $id = $request->naro;
            $data1 = OneInput::where('id', $id)->value('satuan');

            if ($data1 == 'Bulan Layanan') {
                  $input2->volume_capaian = 12;
            } else {
                  $input2->volume_capaian = $request->volume_capaian;
            }

            if ($request->hasFile('file')) {
                  $file = $request->file('file');
                  $fileName = time() . '-' . $file->getClientOriginalName();
                  $file->move(public_path('files'), $fileName);
                  $input2->file = $fileName;
            } else {
                  $input2->file = '';
            }

            // dd($input2);

            $input2->uraian = $request->uraian;
            $input2->nomor_dokumen = $request->nodok;
            $input2->tanggal = $request->tanggal;
            $input2->one_input_id = $request->naro;
            $input2->save();

            return redirect()->back()->with('status', 'Data berhasil dimasukkan!');
      }

      public function edit_dokumen(Request $request, $id)
      {
            $input = TwoInput::find($id);

            $input->one_input_id = $request->naro;
            $input->volume_capaian = $request->volcap;
            $input->uraian = $request->uraian;
            $input->nomor_dokumen = $request->nodok;
            $input->tanggal = $request->tanggal;
            // dd($input);

            if ($request->hasFile('file')) {
                  // dd($request->file);
                  if ($input->file) {
                        // dd('deleted lol');
                        File::delete(public_path('/files/' . $input->file));
                  }
                  $file = $request->file('file');
                  // dd($file);
                  $fileName = time() . '-' . $file->getClientOriginalName();
                  $file->move(public_path('files'), $fileName);
                  $input->file = $fileName;
                  $input->update();
            } else {
                  // dd($request);
                  $input->file = $input->file;
                  $input->update();
            }


            $input->update();

            return back()->withInput()->with('status', 'Dokumen berhasil diperbarui!');
      }

      public function destroy_dokumen($id)
      {
            $data = TwoInput::find($id);
            File::delete(public_path('/files/' . $data->file));
            $data->delete();

            return back()->withInput();
      }
}
