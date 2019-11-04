<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;    //设置标题
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;   //为空时零填充

class StatisticalExport implements
    FromCollection, WithHeadings, WithEvents, WithStrictNullComparison
{
    public function __construct($data, $arr, $widths)
    {
        //print_r($data);exit();
        //print_r(array_keys($data[0]));exit();
        $this->data  = $data;
        $this->arr = $arr;
        $this->widths = $widths;
    }

    public function headings(): array
    {
        //print_r($this->data);exit();
        return array_keys($this->data[0]);
    }



    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                // 合并单元格
                $event->sheet->getDelegate()->setMergeCells($this->arr);
                // 定义列宽度
                $widths = $this->widths;
                foreach ($widths as $k => $v) {
                    // 设置列宽度
                    $event->sheet->getDelegate()->getColumnDimension($k)->setWidth($v);
                }
            },
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //print_r($this->data);
        return collect(new Collection($this->data));
    }
}
