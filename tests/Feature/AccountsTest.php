<?php

namespace Tests\Feature;

use App\Account;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccountsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_browse_accounts()
    {
        $this->actingAs(factory('App\User')->create());

        $Account = factory(Account::class)->create();

        $response = $this->get('/accounts');

        $response->assertStatus(200);

        // $response->assertSee($Account->name);
    }

    /** @test */
    public function a_user_can_see_new_account_form()
    {
        $this->actingAs(factory('App\User')->create());

        $response = $this->get('/accounts/create');

        $response->assertStatus(200);

        $response->assertSee('Create a New Account');
    }


    /** @test */
    public function a_user_can_visit_an_account()
    {
        $this->actingAs(factory('App\User')->create());
        
        $account = factory(Account::class)->create();

        $response = $this->get("/accounts/$account->id");

        $response->assertStatus(200);

        $response->assertSee($account->name);
    }

}
