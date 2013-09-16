# Variables

The simplest of concepts when it comes to PHP is _variables_. A variable holds some type of data. That content can be just about anything you want. Generally, a variable will contain text (string), numbers (integer), yes/no (boolean), nothing (null) or a collection of information (arrays and objects). Here are a few things to remember when creating variables in PHP:

- Variables starts with the `$` sign, followed by the name of the variable.
- Variables are assigned using a single equal sign (=). This should not be confused with evaluating if two things are true which uses the double equal sign (==).
- Variable names _must_ start with a letter or underscore.
- Variable names can only contain letters, numbers and an underscore.
- Variable names cannot contain spaces.
- Variable names are case-sensitive (`$x` and `$X` are two different variables).
- PHP statements must end with a semicolon (;).

<pre>// Putting text into a variable
$text = 'A string of text';

// Putting a number into a variable
$number = 15;

// Putting a yes (true) or no (false) value into a variable
$yesNo = true;

// Putting an array into a variable
$array = ['one', 'two', 'three'];</pre>