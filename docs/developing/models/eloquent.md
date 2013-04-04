# The Eloquent ORM

The Eloquent ORM included with Laravel provides a beautiful, simple ActiveRecord implementation for working with the database. Each database table has a corresponding model which is used to interact with that table.

<p class="alert alert-info"><strong>Note:</strong> The examples that follow show how to use the Eloquent ORM. Nova provides a base model that does some of the work of creating, updating and deleting records for you. We recommend that you use the methods provided through the base model instead of these.</p>

## Basic Usage

### Retrieving Records

Retrieve all users:

<pre>$users = User::all();</pre>

Retrieve a user by their ID:

<pre>$user = User::find(1);</pre>

Querying using a model:

<pre>$users = User::where('status', Status::ACTIVE)->get();</pre>

Count records:

<pre>$users = User::where('status', Status::PENDING)->count();</pre>

### Creating Records

To create a new record in the database from a model, simply create a new model instance and call the `save()` method.

<pre>$user = new User;

$user->name = 'John';

$user->save();</pre>

You can also create a new record by calling the `create()` method.

<pre>$user = User::create(array('name' => 'John'));</pre>

### Updating Records

To update a record in the database from a model, simply retrieve the record, change an attribute and call the `save()` method.

<pre>$user = User::find(1);

$user->name = 'Jonathan';

$user->save();</pre>

You can also run update queries against a set of records.

<pre>$affectedRows = User::where('status', Status::INACTIVE)->update(array('status' => Status::REMOVED));</pre>

### Deleting Records

To delete a record in the database from a model, simply retrieve the record and call the `delete()` method.

<pre>$user = User::find(1);

$user->delete();</pre>

You can do the same operation on one line using the `destroy()` method as well.

<pre>User::destroy(1);</pre>

Like updates, you can also delete against a set of records.

<pre>$affectedRows = User::where('status', Status::PENDING)->delete();</pre>