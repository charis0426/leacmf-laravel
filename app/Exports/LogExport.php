<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Mobile\MobileOrder;
use Maatwebsite\Excel\Concerns\WithHeadings;    //设置标题
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;   //为空时零填充
use Maatwebsite\Excel\Concerns\ShouldAutoSize;      //自动单元格尺寸
use Maatwebsite\Excel\Concerns\WithColumnFormatting;       //设置列格式
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;      //设置单元格数据格式

class LogExport implements
    FromCollection, WithHeadings,WithStrictNullComparison,ShouldAutoSize,WithColumnFormatting
{
    public function __construct($data)
    {
        $this->data  = $data;
    }

    public function headings(): array
    {
        return [
            'id', '组织机构', '类型', '内容', '操作者', 'ip', '请求类型', '时间'
        ];
    }

    //设置列格式
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //print_r($this->data);
        return $this->data;
    }
}
