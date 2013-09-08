# Eloquent Collections

All multi-result sets returned by Nova (either via the `get()` method or a relationship) return an Eloquent `Collection` object. This object implements the `IteratorAggregate` PHP interface so it can be iterated over like an array. However, this object also has a variety of other helpful methods for working with result sets.

## `toSimpleArray()`

Invoking this method on a `Collection` object will convert the object to a simple array. Just pass the property you want to use as the key and the value as the first two parameters. By default, this will put the `id` as the key and the `name` as the value. Make sure that the model you're calling this on has those two properties otherwise an exception will be thrown.

<pre>User::get()->toSimpleArray();

// Returns:
array(
	'1' => 'John Doe',
	'2' => 'Jane Doe',
)

// You can also use other properties
User::get()->toSimpleArray('email', 'name');

// Returns:
array(
	'john@example.com' => 'John Doe',
	'jane@example.com' => 'Jane Doe',
)</pre>

This method is especially helpful when you want to take a result set and make something that can be used by a select menu helper. Say you want to get a list of access roles and put them into a dropdown you can use. Doing this couldn't be easier:

<pre>{{ Form::select('roles', AccessRole::get()->toSimpleArray()) }}</pre>

<p class="alert alert-info"><strong>Note:</strong> In reality, you'd probably choose to use the `Form::roles()` method, but this was meant as an illustration of how you can quickly populate a select menu with data using the `toSimpleArray()` method.</p>

## `toSimpleObject()`