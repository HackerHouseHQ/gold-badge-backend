<?php

namespace App\Exports;




use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;

class StateExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;
    function __construct($arr)
    {
        $this->data = $arr;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        return collect($this->data);
    }
    function headings(): array
    {
        return [
            'State Name',
        ];
    }
}
