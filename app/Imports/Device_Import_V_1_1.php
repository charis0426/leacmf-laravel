<?php


namespace App\Imports;

use App\Model\Company;
use App\Model\Department;
use App\Model\DepartmentCache;
use App\Model\Device;
use App\Model\Transportation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use App\Extensions\myapp\Jobs\ProductImportQueue;   // 队列
use App\Extensions\myapp\Models\Product;
use Maatwebsite\Excel\Row;

class Device_Import_V_1_1 implements ToCollection {
    //导入区域格式：绿盾北京视频管理平台/京-北京-韵达-北京转运中心/京-北京-韵达-北京转运中心
    public function collection(Collection $rows) {
        return $rows;

    }
}