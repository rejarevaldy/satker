<?php

namespace App\Http\Controllers;

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

      public function index()
      {
            $role = Auth::user()->role;
            $user_id = Auth::user()->id;


            if ($role == 'Monitoring') {
                  $datas = OneInput::whereYear('created_at', '=', session('year'))->get();
            } else {
                  $datas = OneInput::whereYear('created_at', '=', session('year'))->where('user_id', $user_id)->get();
            }

            $oneinputs = OneInput::whereYear('created_at', session('year'))->get();
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

        // Dokumen

        public function index_dokumen()
        {
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
                    'one_inputs.bidang',
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
                    'one_inputs.bidang',
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
        ]);
    }

    public function store_dokumen(Request $request)
    {
        // dd('e');
        $input2 = new TwoInput();
        $id = $request->naro;
        $data1 = OneInput::where('id', $id)->value('satuan');
        $month = (int)date('m');
        $m1 = array(
            'Kegiatan', 'Dokumen', 'Pegawai', 'Rekomendasi', 'ISO',
            'Satker', 'Laporan', 'KPPN'
        );

        if (in_array($data1, $m1)) {
            $input2->volume_capaian = 1;
        } else {
            $input2->volume_capaian = $month;
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

        // if ($request->hasFile('file')) {
        //     $file = $request->file('file');
        //     $fileName = time() . '.' . $file->extension();
        //     $file->move(public_path('files'), $fileName);
        //     $input->file = $fileName;
        //     dd('yes');
        // } else {
        //     dd($request);
        //     $input->file = $input->file;
        // }
        // if ($request->hasFile('file')) {
        //     dd('yas');
        //     $file = $request->file('file');
        //     $fileName = time() . '-' . $file->getClientOriginalName();
        //     $file->move(public_path('files'), $fileName);
        //     $input->file = $fileName;
        // } else {
        //     dd($request);
        // }

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
