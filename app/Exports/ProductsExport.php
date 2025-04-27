<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromQuery, WithMapping, WithHeadings, ShouldQueue, ShouldAutoSize

{
    public function query()
    {
        return Product::query()->with('category');
    }

    public function map($product): array
    {
        return [
            $product->name,
            $product->barcode,
            $product->price,
            $product->category->name,
        ];
    }

    public function headings(): array
    {
        return [
            'Название товара',
            'Штрихкод',
            'Цена',
            'Название категории',
        ];
    }
}
