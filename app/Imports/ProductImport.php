<?php

namespace App\Imports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Models\Product;

class ProductImport implements ToModel, WithHeadingRow
{

    use Importable;

    private $unitMapping = [
        'kg' => 'kilogram',
        'kilogram' => 'kilogram',
        'g' => 'gram',
        'gram' => 'gram',
        'l' => 'liter',
        'liter' => 'liter',
        'ml' => 'milliliter',
        'milliliter' => 'milliliter',
        'ton' => 'ton',
        'pcs' => 'pcs',
        'no' => 'pcs',
    ];
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $productCode = trim($row['product_code'] ?? '');
        $name = trim($row['name'] ?? '');
        $unitRaw = trim($row['unit'] ?? '');
        $price = $row['price'] ?? null;
        $quantity = $row['quantity'] ?? null;
    
        if (empty($productCode) && empty($name) && empty($unitRaw) && is_null($price) && is_null($quantity)) {
            return null;
        }
    
        $unit = $this->normalizeUnit(strtolower($unitRaw));
        $unitModel = Unit::whereRaw('LOWER(name) = ?', [$unit])->first();
    
        return new Product([
            'product_code' => $productCode ?: 'N/A',
            'name' => $name ?: 'N/A',
            'unit_id' => $unitModel->id ?? 1,
            'price' => $price ?? 0,
            'quantity' => $quantity ?? 0,
        ]);
    }
    

     /**
     * convert the unit array according to desire structure
     */
    private function normalizeUnit($unit)
    {
        return $this->unitMapping[$unit] ?? $unit;
    }
}
