<?php
namespace App\Sources\Repositories\Base;

use Illuminate\Database\Eloquent\Model;

interface AddBase{
    public function add(array $data): Model|bool;
}
