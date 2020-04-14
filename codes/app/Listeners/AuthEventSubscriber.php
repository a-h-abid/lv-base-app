<?php

namespace App\Listeners;

use Altek\Accountant\Models\Ledger;
use Altek\Accountant\Notary;
use Altek\Accountant\Resolve;
use Illuminate\Support\Facades\Config;

class AuthEventSubscriber
{
    /**
     * Handle user login events.
     */
    public function handleUserLogin($event)
    {
        $this->storeLedger($event, 'loggedin');
    }

    /**
     * Handle user logout events.
     */
    public function handleUserLogout($event)
    {
        $this->storeLedger($event, 'loggedout');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            self::class.'@handleUserLogin',
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            self::class.'@handleUserLogout',
        );
    }

    protected function storeLedger($event, $eventName)
    {
        $userPrefix = Config::get('accountant.user.prefix');
        $user = $event->user;

        $ledger = new Ledger();
        $ledger->{$userPrefix.'_id'} = $user->id;
        $ledger->{$userPrefix.'_type'} = get_class($user);
        $ledger->{'context'} = Resolve::context();
        $ledger->{'event'} = $eventName;
        $ledger->{'recordable_id'} = $user->id;
        $ledger->{'recordable_type'} = get_class($user);
        $ledger->{'properties'} = $user->toArray();
        $ledger->{'modified'} = [];
        $ledger->{'pivot'} = [];
        $ledger->{'extra'} = [];
        $ledger->{'url'} = Resolve::url();
        $ledger->{'ip_address'} = Resolve::ipAddress();
        $ledger->{'user_agent'} = Resolve::userAgent();
        $ledger->{'signature'} = Notary::sign([]);
        $ledger->save();
    }
}