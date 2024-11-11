<?php

namespace App\Exports;

use App\Models\SalarySheetReport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;

// class SalaryExport implements FromCollection, WithHeadings, WithEvents, WithTitle, WithColumnWidths, WithBackgroundColor, WithStyles, WithDrawings
class SalaryExport implements
    FromCollection,
    WithHeadings,
    WithEvents,
    WithTitle,
    WithColumnWidths,
    WithStyles
    // WithDrawings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $sub_title;
    private $last_row_count;
    public function __construct($sub_title)
    {
        // ob_end_clean();
        // ob_start();

        $this->sub_title = $sub_title;
        

    }
    public function collection()
    {
        $salary_record = SalarySheetReport::all();
        $salary_record->makeHidden(['id', 'created_at', 'updated_at']);
        // return $salary_record;


        $result = array();
        foreach ($salary_record as $key =>  $record) {
            //GROSS SALARY/ WORKING DAYS * TARDE DAYS
            $row_count = $key + 5;
            $this->last_row_count = $row_count;
            $result[] = array(
                'id' => $record->sl_no, //A4
                'name_of_the_employee' => $record->name_of_the_employee, //B4
                'designation' => $record->designation, //C4
                'id_number' => $record->employee_id, //C4
                'w_days' => $record->w_days, //D4
                'present' => $record->present, //E4
                'absent' => $record->absent, //F4
                'tardy' => $record->tardy, //G4
                'tardy_days' => $record->tardy_days, //H4
                'gross_salary' => $record->gross_salary, //I4
                'basic_50' => "=50/100*J" . $row_count, //J4
                'hra_40' => "=40/100*J" . $row_count, //K4
                'medical_10' => "=10/100*J" . $row_count, //L4
                'performance_incentive' => $record->performance_incentive, //M4
                'absent_amount' => 0, //N4
                'advance' => $record->advance, //O4
                'tardy_amount' => "=J" . $row_count . "/E" . $row_count . "*H" . $row_count, //P4
                'incentive' => $key==0? 5000 : $record->incentive, //Q4
                'net_salary' => "=(K" . $row_count . "+L" . $row_count . "+M" . $row_count . "+N" . $row_count . "+-O" . $row_count . "-P" . $row_count . "-Q" . $row_count . "+R" . $row_count . ")", //R4

            );
        }

        //pushing the total row at the end of the array
        $result[] = array(
            'id' => '', //A4
            'name_of_the_employee' => 'Total', //B4
            'designation' => '', //C4
            'id_number' => '', //C4
            'w_days' => '', //D4
            'present' => '', //E4
            'absent' => '', //F4
            'tardy' => '', //G4
            'tardy_days' => '', //H4
            'gross_salary' => "=SUM(J5:J" . $row_count . ")", //I4
            'basic_50' => "=SUM(K5:K" . $row_count . ")", //J4
            'hra_40' => "=SUM(L5:L" . $row_count . ")", //K4
            'medical_10' => "=SUM(M5:M" . $row_count . ")", //L4
            'performance_incentive' => "=SUM(N5:N" . $row_count . ")", //M4
            'absent_amount' => 0, //N4
            'advance' => "=SUM(P5:P" . $row_count . ")", //O4
            'tardy_amount' => "=SUM(Q5:Q" . $row_count . ")", //P4
            'incentive' => "=SUM(R5:R" . $row_count . ")", //Q4
            'net_salary' => "=SUM(S5:S" . $row_count . ")", //R4

        );

        return collect($result);
    }
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setHeight(90);
        $drawing->setCoordinates('B1');

        return $drawing;
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A3:S3')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A4:S4')->getAlignment()->setWrapText(true);

        $sheet->getRowDimension(1)->setRowHeight(30);


        $sheet->mergeCells('A1:S1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getFont()->setBold(true);

        $sheet->mergeCells('A2:S2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        
        $sheet->mergeCells('A3:C3');
        $sheet->getStyle('A3:S3')->getFont()->setBold(true);
        $sheet->mergeCells('G3:S3');
        $sheet->getStyle('G3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A4:S4')->getFont()->setBold(true);

        $sheet->getStyle('D')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('D')->getFont()->setBold(true);
        $sheet->getStyle('E')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('E')->getFont()->setBold(true);
        $sheet->getStyle('F')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('G')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('H')->getAlignment()->setHorizontal('center');
        
        $sheet->getStyle('4')->getAlignment()->setHorizontal('center');
        
        $sheet->getStyle('I')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('I')->getAlignment()->setWrapText(true);
        
        $sheet->getStyle('J')->getFont()->setBold(true);
        $sheet->getStyle('O')->getFont()->setBold(true);
        $sheet->getStyle('Q')->getFont()->setBold(true);
        $sheet->getStyle('R')->getFont()->setBold(true);
        $sheet->getStyle('S')->getFont()->setBold(true);
        
        $sheet->getStyle('B'.$this->last_row_count+1)->getFont()->setBold(true);
        $sheet->getStyle('B'.$this->last_row_count+1)->getAlignment()->setHorizontal('center');

        $blank_footer2= intval($this->last_row_count)+2;
        $blank_footer5= intval($this->last_row_count)+5;
        $sheet->mergeCells('B'.$blank_footer2.':S'.$blank_footer5);
        
        //Set number format to column float 2 decimal
        $sheet->getStyle('Q5:Q'.$this->last_row_count)->getNumberFormat()->setFormatCode('###0.00');
        $sheet->getStyle('S5:S'.$this->last_row_count)->getNumberFormat()->setFormatCode('###0.00');
        
        $sheet->getStyle('Q'.$this->last_row_count+1)->getNumberFormat()->setFormatCode('###0.00');
        $sheet->getStyle('S'.$this->last_row_count+1)->getNumberFormat()->setFormatCode('###0.00');

        $sheet->getStyle('A1:S4')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
        $sheet->getStyle('B'.$blank_footer2.':S'.$blank_footer5)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
        


    }
    public function backgroundColor(): string
    {
        return '#FFFF00';
    }
    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 30,
            'D' => 13,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 30,
            'J' => 15,
            'K' => 15,
            'L' => 15,
            'M' => 15,
            'N' => 15,
            'O' => 10,
            'P' => 10,
            'Q' => 15,
            'R' => 10,
            'S' => 15,
        ];
    }

    public function title(): string
    {
        return $this->sub_title;
    }


    public function headings(): array
    {
        return
            [
                [
                    base_settings('company_name')
                ],
                [
                    $this->sub_title
                ],
                [
                    '',
                    '',
                    '',
                    '',
                    'Total day of month',
                    '',
                    'Deduction',
                ],
                [

                    'SL No',
                    'Name of the Employee',
                    'Designation',
                    'ID Number',
                    'W Days',
                    'Present',
                    'Absent',
                    'Tardy',
                    'Tardy Days',
                    'Gross Salary',
                    'Basic (50%)',
                    'HRA (40%)',
                    'Medical (10%)',
                    'Performance Incentive',
                    'Absent',
                    'Advance',
                    'Tardy Amount',
                    'Incentive',
                    'Net Payable',
                ]
            ];
    }
    public function columnFormats(): array
    {
        return [
            // 'Q' => NumberFormat::FORMAT_NUMBER,
        ];
    }
    public function registerEvents(): array
    {
        return [

        AfterSheet::class => function(AfterSheet $event) {
            
            $last_row= $this->last_row_count;

            $event->sheet->setCellValue('B'.$last_row+10,'Md.Jahangir Alam');
            $event->sheet->setCellValue('B'.$last_row+11,'Chief Information Officer');
            $event->sheet->setCellValue('B'.$last_row+12,'Imprint Dhaka Limited');


            $event->sheet->setCellValue('I'.$last_row+10,'Md.Saiful Alam Beg');
            $event->sheet->setCellValue('I'.$last_row+11,'Chief Operations Officer');
            $event->sheet->setCellValue('I'.$last_row+12,'Imprint Dhaka Limited');

        },

        ];
    }
}
