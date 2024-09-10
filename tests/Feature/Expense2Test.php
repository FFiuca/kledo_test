<?php

namespace Tests\Feature;

use App\Models\Approvals;
use App\Models\Approver;
use App\Models\Expense;
use App\Models\Master\Status;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Expense2Test extends TestCase
{
    // use RefreshDatabase;
    use DatabaseMigrations;

    // protected $seeding = true; // it is laravel 11 feature wkwk

    private $approver,
            $expense,
            $expenseApproval,
            $expenseRaw;

    function setUp(): void{
        parent::setUp();

        $this->seed();

        $this->approver = Approver::factory(3)->create()->each(function($q){
            $q->approvalStage()->create();
        });

        $this->expense = Expense::factory()->create();
        $this->expenseApproval = $this->expense->approval()->saveMany([
            ...$this->approver->map(fn($q)=> new Approvals([
                    'approver_id'=> $q->id,
                    'status_id' => 1
                ]))
        ]);
        $this->expenseRaw = Expense::factory()->make();
    }

    public function test_add()
    {
        $data = $this->expenseRaw->only(['amount']);

        $response = $this->post(
            route('expense.create'),
            $data
        );

        $response->assertStatus(200);
        $response->assertJsonPath('data.amount', $data['amount']);

        $new = Expense::where('amount', $data['amount'])->first();
        $this->assertEquals(
            $new->approval()->count(),
            $this->approver->count()
        );
        // dump($new);
        $this->assertEquals(1, $new->status_id); // check if status is waiting for first create
    }

    public function test_detail()
    {
        $response = $this->get( route('expense.detail', [
            'id'=> $this->expense->id
        ]));
        dump($this->expense);
        $response->assertStatus(200);

        $json = $response->json('data');
        $this->assertTrue(isset($json['amount']));
        $this->assertTrue(isset($json['status']));
        $this->assertTrue(isset($json['approval']));
        $this->assertTrue(is_array($json['approval']));

    }


}
