<?php

namespace Tests\Feature;

use App\Account;
use App\Contact;
use Tests\TestCase;
use App\Events\ContactModified;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ApiContactsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_create_a_contact()
    {
        $this->actingAs(factory('App\User')->create());

        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->make(['account_id' => $account->id]);
        $response = $this->json('POST', "/api/accounts/$account->id/contacts", $contact->toArray());
        $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => $contact->name
            ]
        ]);

        $this->assertDatabaseHas('contacts', [
            'name' => $contact->name
        ]);
    }

    /** @test */
    public function a_user_can_update_a_contact()
    {
        $this->actingAs(factory('App\User')->create());

        $contact = factory(Contact::class)->create();
        $response = $this->json('PATCH', "/api/accounts/$contact->account_id/contacts/$contact->id", 
            [
                'home_phone' => 1234567824,
                'mobile_phone' => 1234567824,
                'work_phone' => 1234567824,
                'name' => 'John Foreman',
                'email' => 'test@example.com',
                'primary' => 1
            ]);
        $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'John Foreman'
            ]
        ]);

        $this->assertDatabaseHas('contacts', [
            'name' => 'John Foreman'
        ]);
    }

    /** @test */
    public function a_user_can_delete_a_tab()
    {
        $this->actingAs(factory('App\User')->create());

        $contact = factory(Contact::class)->create();

        $this->assertDatabaseHas('contacts', [
            'name' => $contact->name
        ]);
        $response = $this->json('DELETE',"/api/accounts/$contact->account_id/contacts/$contact->id");

        $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'success' => true
            ]
        ]);

        $this->assertDatabaseMissing('contacts', [
            'name' => $contact->name
        ]);
    }

    /** @test */
    public function an_event_fires_on_contact_creation()
    {
        Event::fake();
        $contact = factory(Contact::class)->create();
        
        Event::assertDispatched(ContactModified::class, function($e) use ($contact) {
            return $e->contact->id === $contact->id;
        });
    }

    /** @test */
    public function primary_()
    {
        Event::fake();
        $contact = factory(Contact::class)->create();

        $contact->name = 'John Doe';
        $contact->save();
        
        Event::assertDispatched(ContactModified::class, function($e) use ($contact) {
            return $e->contact->name === $contact->name;
        });
    }

    /** @test */
    public function an_unauthenticated_user_cant_create_a_contact()
    {
        $account = factory(Account::class)->create();
        $contact = factory(Contact::class)->make(['account_id' => $account->id]);
        $response = $this->json('POST', "/api/accounts/$account->id/contacts", $contact->toArray());
        $response->assertStatus(401);

        $this->assertDatabaseMissing('contacts', [
            'name' => $contact->name
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cant_update_a_contact()
    {
        $contact = factory(Contact::class)->create();
        $this->assertDatabaseHas('contacts', [
            'name' => $contact->name
        ]);

        $response = $this->json('PATCH',"/api/accounts/$contact->account_id/contacts/$contact->id", 
        [
            'home_phone' => 1234567824,
            'mobile_phone' => 1234567824,
            'work_phone' => 1234567824,
            'name' => 'John Foreman',
            'email' => 'test@example.com',
            'primary' => 1
        ]);
        
        $response->assertStatus(401);

        $this->assertDatabaseMissing('contacts', [
            'name' => 'John Foreman'
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cant_delete_a_contact()
    {
        $contact = factory(Contact::class)->create();

        $this->assertDatabaseHas('contacts', [
            'name' => $contact->name
        ]);
        $response = $this->json('DELETE',"/api/accounts/$contact->account_id/contacts/$contact->id");

        $response->assertStatus(401);

        $this->assertDatabaseHas('contacts', [
            'name' => $contact->name
        ]);
    }

}
