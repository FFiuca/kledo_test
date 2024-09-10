<?php

namespace App\Models;

use App\Models\Master\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Approval",
 *     type="object",
 *     title="Approval",
 *     description="Approval expenses",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *     ),
 *     @OA\Property(
 *         property="expense_id",
 *         type="integer",
 *         format="int64",
 *     ),
 *     @OA\Property(
 *         property="approver_id",
 *         type="integer",
 *         format="int64",
 *     ),
 *     @OA\Property(
 *         property="status_id",
 *         type="integer",
 *         format="int64",
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
 *     )
 * )
 */


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
