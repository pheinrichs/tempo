<?php

namespace Tests\Feature;

use App\Account;
use App\AccountTab;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ApiTabTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_create_a_tab()
    {
        $this->actingAs(factory('App\User')->create());

        $account = factory(Account::class)->create();
        $response = $this->json('POST', "/api/accounts/$account->id/tabs", ['name' => 'Mr Rogers Tab of Justice']);
        $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'Mr Rogers Tab of Justice'
            ]
        ]);

        $this->assertDatabaseHas('account_tabs', [
            'name' => 'Mr Rogers Tab of Justice'
        ]);

    }

    /** @test */
    public function a_user_cannot_create_a_tab_with_a_long_name()
    {
        $this->actingAs(factory('App\User')->create());
        $name = str_random(256);
        $tab = factory(AccountTab::class)->create();
        $response = $this->json('POST', "/api/accounts/$tab->account_id/tabs", ['name' => $name]);
        $response->assertStatus(422);

        $this->assertDatabaseMissing('account_tabs', [
            'name' => $name
        ]);
    }

    /** @test */
    public function a_user_can_update_a_tab()
    {
        $this->actingAs(factory('App\User')->create());

        $tab = factory(AccountTab::class)->create();
        $response = $this->json('PATCH',"/api/accounts/$tab->account_id/tabs/$tab->id", ['name' => 'New Tab Name']);

        $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'New Tab Name'
            ]
        ]);

        $this->assertDatabaseHas('account_tabs', [
            'name' => 'New Tab Name'
        ]);
    }

    /** @test */
    public function a_user_cannot_update_a_tab_with_a_long_name()
    {
        $this->actingAs(factory('App\User')->create());
        $name = str_random(256);
        $tab = factory(AccountTab::class)->create();
        $response = $this->json('PATCH',"/api/accounts/$tab->account_id/tabs/$tab->id", ['name' => $name]);
        $response->assertStatus(422);

        $this->assertDatabaseMissing('account_tabs', [
            'name' => $name
        ]);
    }

    /** @test */
    public function a_user_can_delete_a_tab()
    {
        $this->actingAs(factory('App\User')->create());

        $tab = factory(AccountTab::class)->create();

        $this->assertDatabaseHas('account_tabs', [
            'name' => $tab->name
        ]);
        $response = $this->json('DELETE',"/api/accounts/$tab->account_id/tabs/$tab->id");

        $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'success' => true
            ]
        ]);

        $this->assertDatabaseMissing('account_tabs', [
            'name' => $tab->name
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cant_create_a_tab()
    {
        $account = factory(Account::class)->create();
        $response = $this->json('POST', "/api/accounts/$account->id/tabs", ['name' => 'Mr Rogers Tab of Justice']);
        $response->assertStatus(401);

        $this->assertDatabaseMissing('account_tabs', [
            'name' => 'Mr Rogers Tab of Justice'
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cant_update_a_tab()
    {
        $tab = factory(AccountTab::class)->create();

        $response = $this->json('PATCH',"/api/accounts/$tab->account_id/tabs/$tab->id", ['name' => 'New Tab Name']);
        $response->assertStatus(401);

        $this->assertDatabaseMissing('account_tabs', [
            'name' => 'New Tab Name'
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cant_delete_a_tab()
    {
        $tab = factory(AccountTab::class)->create();

        $this->assertDatabaseHas('account_tabs', [
            'name' => $tab->name
        ]);
        $response = $this->json('DELETE',"/api/accounts/$tab->account_id/tabs/$tab->id");

        $response->assertStatus(401);

        $this->assertDatabaseHas('account_tabs', [
            'name' => $tab->name
        ]);
    }
}
