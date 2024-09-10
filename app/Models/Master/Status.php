<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Expense;
use App\Models\Approvals;
use App\Models\Approver;

class Status extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    //SECTION - rel
    public function expense(){
        return $this->hasMany(Expense::class, 'status_id', 'id');
    }

    public function approval(){
        return $this->hasMany(Approvals::class, 'status_id', 'id');
    }

    public function Approver(){
        return $this->hasMany(Approver::class, 'status_id', 'id');
    }

}
