<?php 

namespace App\Exports;

use App\Models\User;
use App\Models\OneInput;
use App\Models\TwoInput;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment as StyleAlignment;

// class InputExport implements FromCollection, WithStyles, WithColumnWidths, WithMapping, WithEvents
class InputAllExport implements FromView, ShouldAutoSize, WithEvents
{

    public function view(): View
    {
        $data = User::where('role', 'Satker')->get();
        
        return view('output.sheet2', [
            // 'oneinput' => OneInput::whereYear('created_at', session('year'))->where('user_id', $user_id)->get(),
            // 'twoinput' => TwoInput::whereYear('created_at', session('year'))->where('user_id', $user_id)->get(),
            'data' => $data,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $role = Auth::user()->role;
                $data = User::where('role', 'Satker')->get();

                // if ($role == 'Monitoring') {
                //     $oneinputs =  OneInput::whereYear('created_at', '=', session('year'))->get();
                //     $twoinput = TwoInput::whereYear('created_at', session('year'))->get();
                // } else {
                //     $user_id = Auth::user()->id;
                //     $oneinputs = OneInput::whereYear('created_at', '=', session('year'))->where('user_id', $user_id)->get();
                //     $twoinput = TwoInput::whereYear('created_at', session('year'))->get();
                // }

                $oneinput = OneInput::whereYear('created_at', session('year'))->get();
                // $countBorder = count($twoinput) == 0 ? count($oneinputs) : count($twoinput);
                $countBorder = count($data);
                $countBorder = $countBorder + 1;
                
                $event->sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                ]);
                $event->sheet->getDelegate()->getStyle('A1:E1')->getAlignment()->setVertical(StyleAlignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle("A1:E$countBorder")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:E1')->getFont()->setSize(14);
                $event->sheet->getStyle("A1:E$countBorder")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000']
                        ]
                    ]
                ]);
                $event->sheet->getDelegate()->getStyle("A1:P$countBorder")->getAlignment()->setVertical(StyleAlignment::VERTICAL_TOP);
            }
        ];
    }
}

?>