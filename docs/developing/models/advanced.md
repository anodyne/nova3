# Advanced Model Work

## Positions

The position model allows you to pull a subset of positions based on scope (all/open) and department type (playing/nonplaying). If you want to dig a little deeper, you can use Eloquent's `filter` mechanism to further narrow your set of data with a Closure.

<pre>Position::getItems('open.playing')->filter(function($item)
{
	return ($item->type == 'senior');
});</pre>

The above code will provide you a Collection of senior level positions in playing departments that are open.