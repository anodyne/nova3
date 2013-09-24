# The Eloquent ORM

The Eloquent ORM included with Laravel provides a beautiful, simple ActiveRecord implementation for working with the database. Each database table has a corresponding model which is used to interact with that table.

## Basic Usage

### Retrieving Records

Retrieve all users:

<pre>$users = UserModel::all();</pre>

Retrieve a user by their ID:

<pre>$user = UserModel::find(1);</pre>

Querying using a model:

<pre>$users = UserModel::where('status', Status::ACTIVE)->get();</pre>

Count records:

<pre>$users = UserModel::where('status', Status::PENDING)->count();</pre>

### Creating Records

There are several ways to create new records in the database from a model. Below shows three different ways to create a new user.

<pre>$user = new UserModel;
$user->name = 'John';
$user->save();

$user = new UserModel(['name' => 'John']);

$user = UserModel::create(['name' => 'John']);</pre>

### Updating Records

To update a record in the database from a model, simply retrieve the record, change an attribute and call the `save()` method.

<pre>$user = UserModel::find(1);
$user->name = 'Johnny';
$user->save();</pre>

You can also run update queries against a set of records.

<pre>$affectedRows = UserModel::where('status', Status::INACTIVE)->update(array('status' => Status::REMOVED));</pre>

### Deleting Records

To delete a record in the database from a model, you can use the `delete()` method or the `destroy()` method. If you need to do more complex where statements, your only option is `delete()`.

<pre>$user = UserModel::find(1);
$user->delete();

$user = UserModel::destroy(1, 2, 7);

$user = UserModel::where('status', Status::REMOVED)->delete();</pre>