<?php

namespace App\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemsExport implements FromCollection, ShouldQueue, Responsable, WithHeadings
{
    use Exportable;

    private $fileName = 'invoices.xlsx';

    protected $items;

    public function __construct(ResourceCollection $items)
    {
        $this->items = $items;
    }

    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    public function collection()
    {
        return $this->items->collection;
    }

    public function headings(): array
    {
        // Define your custom headers here
        return [
            'ID',
            'SKU',
            'Product Id',
            'Product Name',
            'Item Name',
            'Size',
            'Sale',
            'Price',
            'Discount_Price',
            'Categories',
            'Tags',
            'Description',
            'Product Description',
            'Product Short Description',
            'Product Photo',
            'Item Photo',
            'created_at',
            'updated_at',
        ];
        // return $this->items->first()->resource->attributes();
    }
}
