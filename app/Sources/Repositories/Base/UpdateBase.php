<?php
namespace App\Sources\Repositories\Base;

use Illuminate\Database\Eloquent\Model;

interface UpdateBase{
    public function update($id, array $data): Model|bool;
}
