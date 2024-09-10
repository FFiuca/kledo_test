<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Approver;

class ApproverTest extends TestCase
{
    // use RefreshDatabase;
    use DatabaseMigrations;

    // protected $seeding = true;

    private $approver;

    function setUp(): void{
        parent::setUp();
        $this->seed();

        $this->approver = Approver::factory()->make();

    }

    public function test_add()
    {

        $response = $this->post(route('approver.create', [
            'name' => $this->approver->name
        ]));

        $this->assertEquals($response->status(), 200);
        $this->assertEquals($this->approver->name, $response->json('data.name'));
    }
}
