<?php

namespace App\Exports;

use App\Models\SalarySheetReport;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SalaryReportExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $records= SalarySheetReport::except(['id', 'created_at', 'updated_at'])->get();

        $result = array();
        foreach($records as $record){
           $result[] = array(
                'id'=>$record->sl_no,
                'name_of_the_employee'=>$record->name_of_the_employee,
                'designation'=>$record->designation,
                'w_days'=>$record->w_days,
                'present'=>$record->present,
                'absent'=>$record->absent,
                'tardy'=>$record->tardy,
                'tardy_days'=>$record->tardy_days,
                'gross_salary'=>$record->gross_salary,
                'basic_50'=>$record->basic_50,
                'hra_40'=>$record->hra_40,
                'medical_10'=>$record->medical_10,
                'performance_incentive'=>$record->performance_incentive,
                'absent_amount'=>$record->absent_amount,
                'advance'=>$record->advance,
                'tardy_amount'=>$record->tardy_amount,
                'incentive'=>$record->incentive,
                'net_salary'=>$record->net_salary,

           );
        }

        return collect($result);
    }
    public function headings(): array
    {
        return [
            'SL No',
            'Name of the Employee',
            'Designation',
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
            'Tardy Amount',
            'Incentive',
            'Net Salary',
        ];
    }
}
