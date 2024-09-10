<?php
namespace App\Sources\Repositories\Base;
use Illuminate\Database\Eloquent\Model;

interface DetailBase{
    public function detail($id): Model|array;
}
