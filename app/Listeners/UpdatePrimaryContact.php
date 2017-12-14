<?php

namespace App\Listeners;

use App\Account;
use App\Events\ContactModified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatePrimaryContact
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ContactModified $event)
    {
        $contact = $event->contact;
        $account = Account::find($contact->account_id);
        $primary = $account->primary();
        if ($contact->primary && $primary->id != $contact->id) {
            $primary->primary = false;
            $primary->save();
        }
    }
}
