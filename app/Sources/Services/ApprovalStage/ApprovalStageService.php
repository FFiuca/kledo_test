<?php
namespace App\Sources\Services\ApprovalStage;

use App\Models\ApprovalStage;
use App\Sources\Repositories\ApprovalStage\ApprovalStageRepository;
use Illuminate\Database\Eloquent\Model;

class ApprovalStageService extends ApprovalStageRepository{
    function add(array $data): bool|Model{
        $add = ApprovalStage::create($data);

        return $add;
    }

    function update($id, array $data): bool|Model{
        $update = ApprovalStage::where('id', $id)->update($data);

        return $update;
    }
}
