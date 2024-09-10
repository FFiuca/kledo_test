<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Approver extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    //SECTION - rel
    public function approvalStage(){
        return $this->hasOne(ApprovalStage::class, 'approver_id', 'id');
    }
}
