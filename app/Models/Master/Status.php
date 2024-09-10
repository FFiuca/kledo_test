<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Expense;
use App\Models\Approvals;
use App\Models\Approver;

/**
 * @OA\Schema(
 *     schema="Status",
 *     type="object",
 *     title="Status",
 *     description="Status model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         example=1,
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=100,
 *         example="Approved",
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *     ),
 *     @OA\Property(
 *         property="deleted_at",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *     )
 * )
 */


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
