<?php 

namespace App\Exports;

use App\Models\OneInput;
use App\Models\TwoInput;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment as StyleAlignment;

// class InputExport implements FromCollection, WithStyles, WithColumnWidths, WithMapping, WithEvents
class InputExport implements FromView, ShouldAutoSize, WithEvents
{

    public function view(): View
    {
        $role = Auth::user()->role;

        if ($role == 'Monitoring') {
            $oneinputs =  OneInput::whereYear('created_at', '=', session('year'))->get();
            $twoinput = TwoInput::whereYear('created_at', session('year'))->get();
        } else {
            $user_id = Auth::user()->id;
            $oneinputs = OneInput::whereYear('created_at', '=', session('year'))->where('user_id', $user_id)->get();
            $twoinput = TwoInput::whereYear('created_at', session('year'))->where('user_id', $user_id)->get();
        }
        
        return view('output.sheet1', [
            // 'oneinput' => OneInput::whereYear('created_at', session('year'))->where('user_id', $user_id)->get(),
            // 'twoinput' => TwoInput::whereYear('created_at', session('year'))->where('user_id', $user_id)->get(),
            'oneinput' => $oneinputs,
            'twoinput' => $twoinput,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $role = Auth::user()->role;

                if ($role == 'Monitoring') {
                    $oneinputs =  OneInput::whereYear('created_at', '=', session('year'))->get();
                    $twoinput = TwoInput::whereYear('created_at', session('year'))->get();
                } else {
                    $user_id = Auth::user()->id;
                    $oneinputs = OneInput::whereYear('created_at', '=', session('year'))->where('user_id', $user_id)->get();
                    $twoinput = TwoInput::whereYear('created_at', session('year'))->where('user_id', $user_id)->get();
                }

                $oneinput = OneInput::whereYear('created_at', session('year'))->get();
                $countBorder = count($twoinput) == 0 ? count($oneinputs) : count($twoinput);
                $countBorder = $countBorder + 3;
                
                $event->sheet->getDelegate()->getStyle('A1:P1')->getAlignment()->setVertical(StyleAlignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle("A1:P$countBorder")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:P3')->getFont()->setSize(14);
                $event->sheet->getStyle("A1:P$countBorder")->applyFromArray([
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