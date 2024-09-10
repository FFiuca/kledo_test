<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Master\Status;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    //SECTION - rel
    public function status(){
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function approval(){
        return $this->hasMany(Approvals::class, 'expense_id', 'id');
    }
}
