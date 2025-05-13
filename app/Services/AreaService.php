<?php

namespace App\Services;

use App\Models\Area;

class AreaService extends BaseService
{
    public function __construct(Area $model)
    {
        parent::__construct($model);
    }

    public function getData()
    {
        $data = $this->model::with('company')->orderBy('id', 'desc');
        return generateDataTable($data, 'admin.areas');
    }
}
