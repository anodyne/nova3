# Events

## Overriding Nova's Events

Event handlers set up within the Nova core automatically have a key of 0. That key of 0 is translated to a priority of 100 when Nova sets up the event handlers. If you want to override the event handler that Nova is using, you will need to create a new entry with a key of 0. In that instance, your event handler will be used instead of Nova's.

<pre>'nova.user.userCreated' => [0 => 'MyUserEventHandler@onSomething']</pre>

## Event Priority

If you want to create a new event handler that runs _before_ Nova's event handler runs, you'll need to create a new entry with a key above 100. In that instance, your event handler will be run with a priority equal to the key. This allows you granular control over the order in which event handlers are executed. The higher the key (which translates to its priority), the higher its priority.

<pre>'nova.user.userCreated' => [
	110 => 'MyUserEventHandler@onSomething',
	120 => 'MySecondUserEventHandler@onSomethingElse'
]</pre>

If you want to create a new event handler that runs _after_ Nova's event handler runs, you'll need to create a new entry with a key below 100. In that instance, your event handler will be run with a priority equal to the key. This allows you granular control over the order in which event handlers are executed. The lower the key (which translates to its priority), the lower its priority.

<pre>'nova.user.userCreated' => [
	90 => 'MyUserEventHandler@onSomething',
	10 => 'MySecondUserEventHandler@onSomethingElse'
]</pre>

## Events Fired by Nova

Unless otherwise specified, all events are passed the object that was created/updated/deleted and the full input array.

#### System Events

- nova.start
	- `$app`: An instance of the application container
- nova.shutdown
	- `$app`: An instance of the application container

#### General Admin Events

- nova.nav.created
- nova.nav.deleted
- nova.nav.duplicated
- nova.nav.updated
- nova.route.created
- nova.route.deleted
- nova.route.duplicated
- nova.route.updated
- nova.sitecontent.created
- nova.sitecontent.deleted
- nova.sitecontent.updated

#### Form Management Events

- nova.form.formCreated
- nova.form.formDeleted
- nova.form.formUpdated
- nova.form.tabCreated
- nova.form.tabDeleted
- nova.form.tabUpdated
- nova.form.sectionCreated
- nova.form.sectionDeleted
- nova.form.sectionUpdated
- nova.form.fieldCreated
- nova.form.fieldDeleted
- nova.form.fieldUpdated
- nova.form.valueCreated
- nova.form.valueDeleted
- nova.form.valueUpdated
- nova.form.entryCreated

#### User Management Events

- nova.user.created
- nova.user.deleted
- nova.user.updated