<?php

namespace App\Models;

use App\Models\Master\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approvals extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    //SECTION - rel
    public function status(){
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function approver(){
        return $this->belongsTo(Approver::class, 'approver_id',  'id');
    }

    public function expense(){
        return $this->belongsTo(Expense::class, 'expense_id', 'id');
    }
}
