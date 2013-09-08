# Events

## Listening to Events

## Listening to Events with Classes

The recommended way to listen to events fired by Nova is with class listeners. You can define any number of class listeners to any event, providing for a wide range of flexibility throughout Nova. To add a class listener, you will need to first define the class you want to use.

If you only have one event you're listening to, you can declare the listener in the config file like so:

<pre>'nova.start' => array('YourClass')</pre>

If you don't define in the config, you'll need to ensure your class has a `handle()` method that will take the actions you want.

If you want your class to handle multiple events, you can declare the listener in the config file like so:

<pre>'nova.start' => array('YourClass@onNovaStart')

'nova.end' => array('YourClass@onNovaEnd')</pre>

If you define methods in the config, make sure your class has methods for each of the methods you define otherwise an exception will be thrown.

## Event Subscribers