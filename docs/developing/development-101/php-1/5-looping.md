# Looping

Sometime it's necessary to repeat the same block of code a given number of times, or until a certain condition is met. This is accomplished by using _loops_. PHP has two major groups of looping statements: `for` and `while`.

## while

While loops execute a block of code _if_ and _as long_ as a specified condition evaluates to true. If the condition becomes false, the statements within the loop stop executing.

<pre>$i=0;

while ($i <= 5)
{
   echo "The number is ".$i;
   $i++;
}

// Would produce:
The number is 0
The number is 1
The number is 2
The number is 3
The number is 4
The number is 5</pre>

## for

For loops are used when you know how many times you want to execute a statement or a list of statements. For this reason, `for` loops are known as definite loops.

<pre>for ($i=0; $i <= 5; $i++) 
{
   echo "The number is ".$i;
}

// Would produce:
The number is 0
The number is 1
The number is 2
The number is 3
The number is 4
The number is 5</pre>

## foreach

Arrays are actually _iterable_ items, which means you can step through each record of the set with a loop.

<pre>$array['one', 'two', 'three', 'four', 'five'];

foreach ($array as $key => $value)
{
	echo $key.' - '.$value;
}

// Would produce:
0 - one
1 - two
2 - three
3 - four
4 - five</pre>

As you'll remember from talking about arrays, arrays as a key-value pair, so every value has an index. This can be a number or a string. When using a `foreach` loop, you don't have to use the key, you can just pull the value.

<pre>$array['one', 'two', 'three', 'four', 'five'];

foreach ($array as $value)
{
	echo $value;
}

// Would produce:
one
two
three
four
five</pre>

These are very simple examples, but you can see that looping through an array of telling code to execute a certain number of times can create some powerful tools for a developer to use.