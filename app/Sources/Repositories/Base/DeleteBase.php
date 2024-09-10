<?php
namespace App\Sources\Repositories\Base;
use Illuminate\Database\Eloquent\Model;

interface DeleteBase{
    public function delete($id):bool;
}
