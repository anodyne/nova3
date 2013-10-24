# Events

Event handlers set up within the Nova core automatically have a key of 0. That key of 0 is translated to a priority of 100 when Nova sets up the event handlers. If you want to override the event handler that Nova is using, you will need to create a new entry with a key of 0. In that instance, your event handler will be used instead of Nova's.

<pre>'nova.user.created' => [0 => 'MyUserEventHandler@onSomething']</pre>

If you want to create a new event handler that runs _before_ Nova's event handler runs, you'll need to create a new entry with a key above 100. In that instance, your event handler will be run with a priority equal to the key. This allows you granular control over the order in which event handlers are executed. The higher the key (which translates to its priority), the higher its priority.

<pre>'nova.user.created' => [
	110 => 'MyUserEventHandler@onSomething',
	120 => 'MySecondUserEventHandler@onSomethingElse'
]</pre>

If you want to create a new event handler that runs _after_ Nova's event handler runs, you'll need to create a new entry with a key below 100. In that instance, your event handler will be run with a priority equal to the key. This allows you granular control over the order in which event handlers are executed. The lower the key (which translates to its priority), the lower its priority.

<pre>'nova.user.created' => [
	90 => 'MyUserEventHandler@onSomething',
	10 => 'MySecondUserEventHandler@onSomethingElse'
]</pre>

## Events Fired by Nova

nova.form.entryCreated

nova.form.formCreated
nova.form.formDeleted
nova.form.formUpdated

nova.user.created
	- The user object
	- All input data sent

nova.user.deleted
	- The user object

nova.user.updated
	- The user object
	- All input data sent