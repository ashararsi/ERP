<?php
namespace App\Imports;

use App\Models\RawMaterials;
use App\Models\Supplier;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class RawMaterialImport implements ToModel, WithHeadingRow
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
    public function model(array $row)
    {
        // dd($row);
        $name = trim($row['name'] ?? '');
        $unitRaw = trim($row['units'] ?? '');
        $quantity = $row['quantity'] ?? null;
        $cost = $row['cost'] ?? null;
        $supplierName = trim($row['supplier'] ?? '');
        $expiryDate = $row['expiry_date'] ?? null;
        // dd($expiryDate);
        if (empty($name) && empty($unitRaw) && is_null($quantity) && is_null($cost) && empty($supplierName) && empty($expiryDate)) {
            return null;
        }
    
        $supplier = $this->findOrCreateSupplier($supplierName);
        $unit = $this->normalizeUnit(strtolower($unitRaw));
        $unitModel = Unit::whereRaw('LOWER(name) = ?', [$unit])->first();
    
        if ($expiryDate && preg_match('/^\d{4}$/', $expiryDate)) {
            $expiryDate = $expiryDate . '-01-01';
        }
        // dd($supplier);
        return new RawMaterials([
            'name' => $name ?: 'N/A',
            'unit' => $unitModel?->id ?? 1,
            'quantity' => $quantity ?? 0,
            'cost' => $cost ?? 0,
            'supplier_id' => $supplier?->id ?? 1,
            'expiry_date' => isset($expiryDate) ? Carbon::parse($expiryDate) : now(),
        ]);
    }
    

    private function findOrCreateSupplier($supplierName)
    {
        if (!$supplierName) return null;

        return Supplier::find($supplierName);
    }

    /**
     * convert the unit array according to desire structure
     */
    private function normalizeUnit($unit)
    {
        return $this->unitMapping[$unit] ?? $unit;
    }
}
