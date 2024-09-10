<?php

namespace Tests\Feature;

use App\Models\Approvals;
use App\Models\Approver;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ApprovalExpenseTest extends TestCase
{
    use DatabaseMigrations;


    private $approver,
            $expense,
            $expenseApproval,
            $expenseRaw;

    function setUp(): void{
        parent::setUp();

        $this->seed();

        // approver count is 3
        $this->approver = Approver::factory(3)->create()->each(function($q){
            $q->approvalStage()->create();
        });

        // add expense data
        $this->expense = Expense::factory()->create();

        // add detail expense with first init state
        $this->expenseApproval = $this->expense->approval()->saveMany([
            ...$this->approver->map(fn($q)=> new Approvals([
                    'approver_id'=> $q->id,
                    'status_id' => 1 // waiting state
                ]))
        ]);

        // backup
        $this->expenseRaw = Expense::factory()->make();
    }

    public function test_approve_all_is_approved()
    {

        $response = [];
        foreach($this->expenseApproval as $key=>$r){
            $response[$key] = $this->patch(
                route('expense.approve', [
                    'id' => $this->expense->id
                ]),
                [
                    'approver_id' => $r->approver_id
                ]
            );

            // dump($response[$key]->json());
            $response[$key] = [
                'status' => $response[$key]->status(),
                'data' => $response[$key]->json()
            ];

            $this->assertEquals($response[$key]['status'], 200);
        }

        // get latest db
        $expense = Expense::find($this->expense->id);
        $this->assertEquals($expense->status_id, 2); // check automatically approve when all approval approved
    }

    public function test_approve_just_2_person_from_3_person(){

        $response = [];
        for($key=0; $key<2; $key++){
            $r = $this->expenseApproval[$key];

            $response[$key] = $this->patch(
                route('expense.approve', [
                    'id' => $this->expense->id
                ]),
                [
                    'approver_id' => $r->approver_id
                ]
            );

            // dump($response[$key]->json());
            $response[$key] = [
                'status' => $response[$key]->status(),
                'data' => $response[$key]->json()
            ];

            $this->assertEquals($response[$key]['status'], 200);
        }

        // get latest db
        $expense = Expense::where('id', $this->expense->id)->first();
        $this->assertEquals($expense->status_id, 1); // check status still waiting
    }

    public function test_approve_just_1_person_from_3_person(){
        $response = [];
        for($key=0; $key<1; $key++){
            $r = $this->expenseApproval[$key];

            $response[$key] = $this->patch(
                route('expense.approve', [
                    'id' => $this->expense->id
                ]),
                [
                    'approver_id' => $r->approver_id
                ]
            );

            // dump($response[$key]->json());
            $response[$key] = [
                'status' => $response[$key]->status(),
                'data' => $response[$key]->json()
            ];

            $this->assertEquals($response[$key]['status'], 200);
        }

        // get latest db
        $expenseNew = Expense::where('id', $this->expense->id)->first();
        // dump($expense, $this->expense);
        $this->assertEquals(1, $expenseNew->status_id); // check status still waiting
    }

    public function test_approve_out_of_order(){
        $response = [];

        $response = $this->patch(
            route('expense.approve', [
                'id' => $this->expense->id
            ]),
            [
                'approver_id' => $this->expenseApproval[2]->approver_id
            ]
        );


        $this->assertEquals($response->status(), 500);


        // get latest db
        $expenseNew = Expense::where('id', $this->expense->id)->first();
        // dump($expense, $this->expense);
        $this->assertEquals(1, $expenseNew->status_id); // check status still waiting
    }



}
