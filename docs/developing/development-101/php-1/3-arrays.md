# Arrays

Arrays are an incredibly convenient and powerful way to store and organize data quickly and efficiently. An array is a key-value pair. The value can be any type of data, even other arrays. You can access the individual elements of an array by reference their index within the array.

<pre>$dwarves = [
	0 => 'Bashful',
	1 => 'Doc',
	2 => 'Dopey',
	3 => 'Grumpy',
	4 => 'Happy',
	5 => 'Sleepy',
	6 => 'Sneezy',
];

echo $dwarves[3];

// Would produce:
Grumpy</pre>

The above array is known as an indexed array. We could also eliminate specifically using the indices and it would work the same. It is also possible to use strings as the indices in an array. Commonly referred to as associative arrays, they can often help organize data better.

<pre>$dwarves = [
	'Bashful' => 'Scotty Mattraw',
	'Doc' => 'Roy Atwell',
	'Dopey' => 'Eddie Collins',
	'Grumpy' => 'Pinto Colvig',
	'Happy' => 'Otis Harlan',
	'Sleepy' => 'Pinto Colvig',
	'Sneezy' => 'Billy Gilbert',
];

echo $dwarves['Grumpy'];

// Would produce:
Pinto Colvig</pre>