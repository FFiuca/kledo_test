<?php

namespace Tests\Feature;

use App\Models\ApprovalStage;
use App\Models\Approver;
use Database\Seeders\StatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ApprovalStageTest extends TestCase
{
    // use RefreshDatabase; // conflict with seeder transaction
    use DatabaseMigrations; // to prevent transaction in setup process

    // protected $seeding = true;

    private $approver = null;

    function setUp(): void{
        parent::setUp();
        $this->seed();

        $this->approver = Approver::factory(3)->create();
    }

    public function test_add()
    {
        $data = $this->approver[0];

        $response = $this->post(route('approval-stages.create'), [
            'approver_id'=> $data->id
        ]);
        // dump($response->json(), 'aa');
        $response->assertStatus(200);
        $response->assertJsonPath('data.approver_id', $data->id);
    }

    public function test_add_approver_not_exist()
    {
        $data = Approver::factory()->make();

        $response = $this->post(route('approval-stages.create'), [
            'approver_id'=> $data->id
        ]);

        $response->assertStatus(400);
    }

    public function test_update()
    {
        // init
        $old = $this->approver->each(function($appr){
            $appr->approvalStage()->create();
        });
        $new = Approver::factory()->create();

        // dump($old[0]->approvalStage);

        $response = $this->put(route('approval-stages.update', ['id'=> $old[0]->approvalStage->id]), [
            'approver_id'=> $new->id
        ]);
        // dump($response->json(), 'aa');
        $response->assertStatus(200);
        $response->assertJsonPath('data', true);
    }
}
