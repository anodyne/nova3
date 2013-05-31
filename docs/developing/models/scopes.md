# Model Scopes

Model scopes allow you to easily limit the data being returned by a model.

## Examples

<pre>// Get all active users
User::active()->get();

// Get all pending users
User::pending()->get();</pre>

## Identifying Scopes

Scopes are different depending on the model, but the way to identify scopes when looking at an existing model is to find methods that start with the word `scope`. From there, you'll just invoke that scope by using a camel-cased version of the method, minus the word `scope`.

## Creating Scopes

Creating new scopes for your models or extending existing models with new scopes is easy. In order to create a scope, simply create a new method that's prefaced with the word `scope`. The method should be passed a `$query` variable as the first parameter (which Laravel will populate for you) and then you can use that instance of the builder to limit what you want.

<pre>public function scopeIsSysAdmin($query)
{
	$query->where('role_id', AccessRole::SYSADMIN);
}

public function scopeHasRole($query, $role)
{
	$query->where('role_id', $role);
}

public function scopeHasAtLeastRole($query, $role)
{
	$query->where('role_id', '>=', $role);
}</pre>

You would use these scopes by simplying calling them on the User model.

<pre>User::isSysAdmin()->get();

User::hasRole(AccessRole::USER)->get();

User::hasAtLeastRole(AccessRole::POWERUSER)->get();</pre>

You can even chain scopes, so if you wanted to get all active system administrators, you could do this now:

<pre>User::active()->isSysAdmin()->get();</pre>

<p class="alert alert-info"><strong>Note:</strong> The above examples are meant to illustrate some of the things you can do with model scopes. Practically speaking, Sentry provides a better interface for interacting with users and their roles and permissions.</p>

## Provided Scopes

Nova comes with several pre-defined scopes in the base model that you can use on almost all models.

### `active()`

The `active()` scope will a where clause to the query to only pull back items that have a status of active. (See the Status class document for more information on how Nova handles statuses.)

### `inactive()`

The `inactive()` scope will a where clause to the query to only pull back items that have a status of inactive. (See the Status class document for more information on how Nova handles statuses.)

<p class="alert alert-info"><strong>Note:</strong> In the event that a table doesn't contain a `status` column, the scope won't have any impact on the query.</p>

### `orderAsc()`

### `orderDesc()`

### `group()`