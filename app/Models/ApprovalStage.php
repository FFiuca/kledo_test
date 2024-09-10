<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Approver;

class ApprovalStage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    //SECTION - rel
    public function approver(){
        return $this->belongsTo(Approver::class, 'approver_id',  'id');
    }
}
