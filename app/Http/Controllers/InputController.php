<?php

namespace App\Http\Controllers;

use App\Models\OneInput;
use App\Models\TwoInput;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InputController extends Controller
{

      public function __construct()
      {
            $this->middleware('auth');
      }

      public function index()
      {
            $role = Auth::user()->role;
            $user_id = Auth::user()->id;


            if ($role == 'Monitoring') {
                  $datas = OneInput::whereYear('created_at', '=', session('year'))->get();
            } else {
                  $datas = OneInput::whereYear('created_at', '=', session('year'))->where('user_id', $user_id)->get();
            }

            $oneinputs = OneInput::whereYear('created_at', session('tahun'))->get();
            foreach ($oneinputs as $oneinput) {
                  $id = $oneinput->id;

                  $input = TwoInput::where('one_input_id', $id)->pluck('volume_capaian')->toArray();
                  $oneinput = OneInput::find($id);
                  $sum = array_sum($input);

                  $oneinput->volume_jumlah = $sum;
                  $oneinput->update();
            }

            return view('input.index', [
                  'datas' => $datas
            ]);
      }

      public function create()
      {
            $bidang =  ['Umum', 'PPA I', 'PPA II', 'SKKI', 'PAPK', 'Admin'];
            $satuan = ['Kegiatan', 'Dokumen', 'Pegawai', 'Rekomendasi', 'ISO', 'Satker', 'Laporan', 'KPPN', 'Bulan Layanan', '-'];

            return view('input.create', [
                  'bidangs' => $bidang,
                  'satuans' => $satuan
            ]);
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
            $input->bidang = $request->bidang;
            $input->satuan = $request->satuan;
            $input->kd_kro = $request->kd_kro;
            $input->kd_ro = $request->kd_ro;
            $input->nama_ro = $request->nama_ro;
            $input->capaian_ro = $request->capaian_ro;
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
            return view('input.show', [
                  'data' => $oneinput
            ]);
      }

      public function edit(OneInput $oneinput)
      {
            $bidang =  ['Umum', 'PPA I', 'PPA II', 'SKKI', 'PAPK', 'Admin'];
            $satuan = ['Kegiatan', 'Dokumen', 'Pegawai', 'Rekomendasi', 'ISO', 'Satker', 'Laporan', 'KPPN', 'Bulan Layanan', '-'];

            return view('input.edit', [
                  'data' => $oneinput,
                  'bidangs' => $bidang,
                  'satuans' => $satuan
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
            $oneinput->bidang = $request->bidang;
            $oneinput->satuan = $request->satuan;
            $oneinput->kd_kro = $request->kd_kro;
            $oneinput->kd_ro = $request->kd_ro;
            $oneinput->nama_ro = $request->nama_ro;
            $oneinput->capaian_ro = $request->capaian_ro;
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

            return redirect()->back()->with('status', 'Laporan admin berhasil diperbarui');
      }

      public function destroy(OneInput $oneinput)
      {
            $oneinput->delete();
            return redirect('/laporan');
      }
}
