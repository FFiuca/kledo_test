<?php
namespace App\Sources\Repositories\Expense;
use App\Sources\Repositories\Base\AddBase;
use App\Sources\Repositories\Base\DetailBase;
use App\Sources\Repositories\Base\ModelBaseRepository;

abstract class ExpenseRepository implements AddBase, DetailBase{

    abstract public function approve($id):bool;
}
