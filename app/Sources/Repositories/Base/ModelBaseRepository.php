<?php
namespace App\Sources\Repositories\Base;
use Illuminate\Database\Eloquent\Model;

interface UpdateBase{
    public function update($id, array $data): Model|bool;
}

interface AddBase{
    public function add(array $data): Model|bool;
}

interface DeleteBase{
    public function delete($id):bool;
}
interface DetailBase{
    public function detail($id): Model|array;
}


abstract class ModelBaseRepository implements UpdateBase, AddBase, DeleteBase, DetailBase{

}
