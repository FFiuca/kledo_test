<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Master\Status;


 /**
 * @OA\Schema(
 *     schema="Expense",
 *     type="object",
 *     title="Expense",
 *     description="Expense model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *     ),
 *     @OA\Property(
 *         property="amount",
 *         type="integer",
 *     ),
 *     @OA\Property(
 *         property="status_id",
 *         type="integer",
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *     ),
 *     @OA\Property(
 *         property="deleted_at",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *     )
 * )
 */

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
