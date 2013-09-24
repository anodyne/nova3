# Base Model

Nova 3 provides a base model that all of Nova's models extend from. This provides a consistent API for all of Nova's models to use. If you know how to add rank items then you know how to add a post or a wiki page.

## Get Records

Retrieving items from the database is easy enough to do with Eloquent's `find()` method, but sometimes you don't know the primary key, so that method is useless. You could create a where clause inline or even create a new model method, but the base model provides you with a method to pull back records based on simple criteria using the `getItems()` method.

<pre>PersonalLogModel::getItems('title', 'My Title');</pre>

This will find the all personal logs with the title "My Title". If multiple rows are returned and you just want to grab the first item, you can use the `first()` method on the `Collection`.

<pre>PersonalLogModel::getItems('title', 'My Title')->first();</pre>

You can also pass an array of conditions to `getItems()` for more advanced selection.

<pre>PersonalLogModel::getItems(['title' => 'My Title', 'status' => Status::ACTIVE]);</pre>

## Create Records

Adding a record to the database is as simple as calling the `create()` method and passing it an array of data where the key is the column and the value is the content you want to store.

<pre>PersonalLogModel::create([
	'title'			=> 'My Title',
	'content'		=> "This is the content for my personal log.",
	'user_id'		=> {your user ID},
	'character_id'	=> {your character ID},
]);</pre>

For security reasons, all data passed through the `create()` method is filtered for malicious content. If you don't want the data filtered, you will have to instantiate a new object and pass `false` to the second parameter.

<pre>$log = new PersonalLogModel([
	'title'			=> 'My Title',
	'content'		=> "This is the content for my personal log.",
	'user_id'		=> {your user ID},
	'character_id'	=> {your character ID},
], false);</pre>

## Update Records

Updating an existing record in the database is as simple as calling `update()` (with a few parameters).

<pre>PersonalLogModel::where('id', 1)->update(['title' => 'My Title (Updated)']);</pre>

You can also find the item you want to update and change individual columns as well.

<pre>$log = PersonalLogModel::find(1);
$log->title = 'My Title (Updated)';
$log->save()</pre>

## Remove Records

Deleting an existing record from the database is equally as simple.

<pre>PersonalLogModel::destroy(1);
// Removes the personal log with ID 1

PersonalLogModel::where('title' => 'My Title (Updated)')->delete();
// Removes all personal logs with the title "My Title (Updated)"</pre>

## `startQuery()`

Because there are often static methods scattered throughout the models, we need to kick off a new query builder instance sometimes to get information out of the database. Instead of duplicating this code repeatedly, the base model contains a method that will start the query for you and return the query builder instance. From there, you can create new queries to get the data you're looking for.

<pre>public static function someMethod()
{
	// Start a new query
	$query = static::startQuery();

	return $query->where('status', Status::ACTIVE)
		->orderBy('order', 'desc')
		->get();
}</pre>