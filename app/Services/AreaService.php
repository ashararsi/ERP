<?php

namespace App\Services;

use App\Models\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class AreaService extends BaseService
{
    public function __construct(Area $model)
    {
        parent::__construct($model);
    }

    public function store(array $data): Model|Collection
    {
        $names = array_map('trim',explode(',',$data['name']));
        $created = collect();
        foreach ($names as $name) {
            if (!empty($name)) {
                $created->push(
                    $this->model->create([
                        'name' => $name,
                        'city_id' => $data['city_id']
                    ])
                );
            }
        }

        return $created->count() === 1 ? $created->first() : $created;
       
    }
    public function getData()
    {
        $data = $this->model::with('company')->orderBy('id', 'desc');
        return generateDataTable($data, 'admin.areas');
    }
}
