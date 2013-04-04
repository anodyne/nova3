# Base Model

Nova 3 provides a base model that all of Nova's models extend from. This provides a consistent API for all of Nova's models to use. If you know how to add rank items then you know how to add a post or a wiki page.

## `add()`

Adding a record to the database is as simple as calling the `add()` method and passing it an array of data where the key is the column and the value is the content you want to store.

<pre>PersonalLog::add(array(
	'title'			=> 'My Title',
	'content'		=> "This is the content for my personal log.",
	'user_id'		=> {your user ID},
	'character_id'	=> {your character ID},
));</pre>

### Parameters

__Data__: This is an array of data that will be used to create the record.

__Return Complete Object__: You have the option of returning the full object that was just created or a boolean of whether the record was created. By default, it will return a boolean, but passing `true` to the second parameter will cause the full object to be returned.

__Filter Data__: To protect the database from malicious user input, you have the option of filtering the data that comes into the database. By default, input is filtered, but passing `false` to the third parameter will cause the data to be stored unfiltered.

## `getItem()`

Retrieving a single item from the database is easy enough to do with the `find()` method, but sometimes you don't know the ID to use that. You could create a complex where clause, but if you only need to pull back an item based on some other criteria, you can use the `getItem()` method.

<pre>PersonalLog::getItem('My Title', 'title');</pre>

This will find the _first_ personal log with the title "My Title".

## `update()`

Updating an existing record in the database is as simple as calling `update()` (with a few parameters).

<pre>PersonalLog::update(1, array(
	'title' => 'My Title (Updated)'
));</pre>

### Parameters

__ID__: This is the numerical ID for the record. You can also pass `false` and run the update for all the records in that database table.

__Data__: This is an array of data that will be used to update the record(s).

__Return Complete Object__: You have the option of returning the full updated object or a boolean of whether the record was updated. By default, it will return a boolean, but passing `true` to the third parameter will cause the full object to be returned.

__Filter Data__: To protect the database from malicious user input, you have the option of filtering the data that comes into the database. By default, input is filtered, but passing `false` to the fourth parameter will cause the data to be stored unfiltered.

## `remove()`

Deleting an existing record from the database is equally as simple.

<pre>PersonalLog::remove(1);

PersonalLog::remove(array(
	'title' => 'My Title (Updated)'
));</pre>

### Parameters

__Arguments__: This is a highly dynamic field. You can choose to pass a simple numerical ID to the method and that record will be deleted. You can also pass an array to the method with conditions for a where clause to figure out which item(s) to delete. Using an array only allows for simple AND/= operations. In other words, you can't pass advanced where statements with different conditions to the remove method. If you need to do advanced deletions, you'll need to make explicit calls to the model, like below:

<pre>PersonalLog::where('title' 'like', 'My Title%')
	->orWhere('content', 'like', '%some phrase%')
	->delete();</pre>

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