<?php

namespace App\Imports;

use App\Models\PackingMaterial;
use App\Models\Category;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class PackingMaterialImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        $description = $row['productdescription'] ?? null;
        $unit = $row['unit'] ?? null;
        
        if (empty($description) || empty($unit)) {
            return null;  
        }

        $category = $this->getCategoryByDescription($description);
        $unitModel = $this->getUnitByName($unit);

        return new PackingMaterial([
            'name' => $description,
            'category_id' => $category->id,
            'unit_id' => $unitModel->id,
        ]);
    }

    private function getCategoryByDescription($description)
    {
        $categories = ['Cap', 'Bottle', 'Label','Unit Cartons','Shealing Paper','Tubes','Droper','Aluminium Seal','Master Cartons','Tablet Aluminium Foil','Pouch'];

        foreach ($categories as $categoryName) {
            if (strpos($description, $categoryName) !== false) {
                return Category::firstOrCreate(['name' => $categoryName]);
            }
        }

        return Category::firstOrCreate(['name' => 'Other']);
    }

    private function getUnitByName($unit)
    {
        return Unit::firstOrCreate(['name' => $unit]);
    }
}
