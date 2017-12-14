<?php

namespace Tests\Feature;

use App\AccountTab;
use App\TabField;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
class ApiFieldTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_create_a_field()
    {
        $this->actingAs(factory('App\User')->create());
        $tab = factory(AccountTab::class)->create();
        $response = $this->json('POST', "/api/accounts/$tab->account_id/tabs/$tab->id/fields", ['name' => 'Bingo', 'value' => 'Bongo']);
        $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'Bingo'
            ]
        ]);

        $this->assertDatabaseHas('tab_fields', [
            'name' => 'Bingo'
        ]);
    }

    /** @test */
    public function a_user_can_update_a_field()
    {
        $this->actingAs(factory('App\User')->create());

        $field = factory(TabField::class)->create();

        $this->assertDatabaseHas('tab_fields', [
            'name' => $field->name
        ]);

        $response = $this->json('PATCH',"/api/accounts/".$field->tab->account->id."/tabs/".$field->tab->id."/fields/$field->id", ['name' => 'Tahdah', 'value' => 'bingo123']);
        $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'Tahdah'
            ]
        ]);

        $this->assertDatabaseHas('tab_fields', [
            'name' => 'Tahdah'
        ]);

        $this->assertDatabaseMissing('tab_fields', [
            'name' => $field->name
        ]);
    }

    
    /** @test */
    public function a_user_can_delete_a_field()
    {
        $this->actingAs(factory('App\User')->create());

        $field = factory(TabField::class)->create();
        
        $this->assertDatabaseHas('tab_fields', [
            'name' => $field->name
        ]);
        
        $response = $this->json('DELETE',"/api/accounts/".$field->tab->account->id."/tabs/".$field->tab->id."/fields/$field->id");
        
        $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'success' => true
            ]
        ]);

        $this->assertDatabaseMissing('tab_fields', [
            'name' => $field->name
        ]);
    }

    /** @test */
    public function a_user_cannot_create_a_field_with_a_long_name()
    {
        $this->actingAs(factory('App\User')->create());
        $name = str_random(256);
        $tab = factory(AccountTab::class)->create();
        $response = $this->json('POST', "/api/accounts/$tab->account_id/tabs/$tab->id/fields", ['name' => $name, 'value' => 'dummy data']);
        $response->assertStatus(422);

        $this->assertDatabaseMissing('tab_fields', [
            'name' => $name
        ]);
    }

    /** @test */
    public function a_user_cannot_create_a_field_with_a_long_value()
    {
        $this->actingAs(factory('App\User')->create());
        $name = str_random(256);
        $tab = factory(AccountTab::class)->create();
        $response = $this->json('POST', "/api/accounts/$tab->account_id/tabs/$tab->id/fields", ['name' => 'dummy', 'value' => $name]);
        $response->assertStatus(422);

        $this->assertDatabaseMissing('tab_fields', [
            'name' => $name
        ]);
    }

    /** @test */
    public function a_user_cannot_update_a_field_with_a_long_name()
    {
        $name = str_random(256);
        $this->actingAs(factory('App\User')->create());
        $field = factory(TabField::class)->create();
        $this->assertDatabaseHas('tab_fields', [
            'name' => $field->name
        ]);
        $response = $this->json('PATCH',"/api/accounts/".$field->tab->account->id."/tabs/".$field->tab->id."/fields/$field->id", ['name' => $name, 'value' => 'bingo123']);
        
        $response->assertStatus(422);

        $this->assertDatabaseMissing('tab_fields', [
            'name' => $name
        ]);
    }

    /** @test */
    public function a_user_cannot_update_a_field_with_a_long_value()
    {
        $name = str_random(256);
        $this->actingAs(factory('App\User')->create());
        $field = factory(TabField::class)->create();
        $this->assertDatabaseHas('tab_fields', [
            'name' => $field->name
        ]);
        $response = $this->json('PATCH',"/api/accounts/".$field->tab->account->id."/tabs/".$field->tab->id."/fields/$field->id", ['name' => 'bingo123', 'value' => $name]);
        
        $response->assertStatus(422);

        $this->assertDatabaseMissing('tab_fields', [
            'name' => $name
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cant_create_a_field()
    {
        $tab = factory(AccountTab::class)->create();
        $response = $this->json('POST', "/api/accounts/$tab->account_id/tabs/$tab->id/fields", ['name' => 'Bingo', 'value' => 'Bongo']);
        $response->assertStatus(401);

        $this->assertDatabaseMissing('account_tabs', [
            'name' => 'Mr Rogers Tab of Justice'
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cant_update_a_field()
    {
        $field = factory(TabField::class)->create();
        
        $this->assertDatabaseHas('tab_fields', [
            'name' => $field->name
        ]);
        
        $response = $this->json('PATCH',"/api/accounts/".$field->tab->account->id."/tabs/".$field->tab->id."/fields/$field->id", ['name' => 'Tahdah']);
        $response->assertStatus(401);

        $this->assertDatabaseHas('tab_fields', [
            'name' => $field->name
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cant_delete_a_tab()
    {
        $field = factory(TabField::class)->create();
        
        $this->assertDatabaseHas('tab_fields', [
            'name' => $field->name
        ]);
        
        $response = $this->json('DELETE',"/api/accounts/".$field->tab->account->id."/tabs/".$field->tab->id."/fields/$field->id");

        $response->assertStatus(401);

        $this->assertDatabaseHas('tab_fields', [
            'name' => $field->name
        ]);
    }
}
