<?php
namespace App\Sources\Services\Approver;

use App\Models\Approver;
use App\Sources\Repositories\Base\ModelBaseRepository;
use App\Sources\Repositories\Expense\ApproverRepository;
use Illuminate\Database\Eloquent\Model;

class ApproverService extends ModelBaseRepository{

    function add(array $data): bool|Model{
        $add = Approver::create($data);

        return $add;
    }

    function update($id ,array $data): bool|Model{
        $update = Approver::where('id', $id)->update($data);

        return $update;
    }

    function delete($id): bool{
        $delete = Approver::where('id', $id)->delete();

        return $delete;
    }

    function detail($id): array|Model{
        $data = Approver::where('id', $id)->first();

        return $data;
    }
}
