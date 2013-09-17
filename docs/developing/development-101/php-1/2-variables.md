# Variables

The simplest of concepts is _variables_. A variable holds some type of data. That content can be just about anything you want. Generally though, a variable will contain text (string), numbers (integer), yes/no (boolean), nothing (null) or a collection of information (arrays and objects). Here are a few things to remember when creating variables in PHP:

- Variables starts with the `$` sign, followed by the name of the variable.
- Variables are assigned using a single equal sign (=). This should not be confused with evaluating if two things are true which uses the double equal sign (==).
- Variable names _must_ start with a letter or underscore.
- Variable names can only contain letters, numbers and underscores.
- Variable names cannot contain spaces.
- Variable names are case-sensitive (`$x` and `$X` are two different variables).
- PHP statements must end with a semicolon (;).

The best way to learn is to follow along with the lessons in a text editor and your local server. This will help you understand the concepts and even play around with what we're talking about before you move on.

## Printing Variables Out

Before we dive into variables, you'll notice the term `echo` in the examples. In PHP, `echo` will display the content in the `echo` statement out to the browser.

<pre>echo 'Statement';
// Would produce: Statement</pre>

## Strings

If you just want to create a string of text, you can simply assign that content to a variable. Strings must be wrapped by either single quotes `'` or double quotes `"`.

<pre>$firstText = 'A string of text';

$secondText = "Another string of text";</pre>

### Escaping Strings

If you're creating strings with single and/or double quotes in the content, you need to _escape_ those characters. Let's show three different examples.

<pre>$text = "This uses double quotes because we're using a single quote character inside the string.";</pre>

In the first example, we're using a single quote in the body of our text, so to avoid escaping it, we used double quotes around the entire statement.

<pre>$text = 'This uses "single quotes" to wrap the text because we're using double quotes inside the string.';</pre>

Likewise, in the second example, we're using double quotes in the body of our text, so we use single quotes around the entire statement so we don't have to escape anything.

<pre>$text = 'In this case, we\'re using single quotes inside of single quotes, so we have to escape it with the forward slash (\)';</pre>

In some situations though, we can't avoid escaping quotes. The above is a great example. We have to use a forward slash in front of the character we want to escape `\'` so we don't accidentally end the string. If we didn't escape the single quote character, PHP would throw a syntax error. (In this case, PHP would throw the following error: "Parse error: syntax error, unexpected 't' (T_STRING)".)

### Strings and Variables

Let's say you have a string of text and you want to use a variable within that string. Like we've mentioned above, you can use either single or double quotes for the string, but there are differences when using both.

Single quotes cannot evaluate a variable, they'll simply print it. Double quotes, on the other hand, _will_ evaluate a variable and print the output.

<pre>$variable = 10;

echo 'My variable is equal to $variable';
// Would produce: My variable is equal to $variable

echo "My variable is equal to $variable";
// Would produce: My variable is equal to 10</pre>

You can also use braces `{ }` to surround a variable in the event you have other characters (like underscores and dashes in object properties). In Nova, we generally use braces around variables within a string.

<pre>$variable = 10;

echo "My variable is equal to {$variable}";</pre>

It is still possible to use single quotes in this situation, but you have to concatenate the result into the string (more on concatenation below).

<pre>$variable = 10;

echo 'My variable is equal to '.$variable;</pre>

## Numbers

Unlike strings, numbers don't need to be wrapped in quotes. Instead, you can just enter the number. If you have a number greater than 999, you won't use commas to separate numbers, but you will use a decimal point for floating point numbers.

<pre>$firstNumber = 15;

$secondNumber = 32.987;

$thirdThumb = 89473;</pre>

### Formatting Numbers

Sometimes, you may need to format a number with commas. PHP includes a handy function to do just that.

<pre>echo number_format(8738291);

// Would produce: 8,738,291</pre>

## Booleans

A boolean is a yes/no value. It can only be one or the other. Instead of using yes/no though, PHP uses `true` and `false`. You'll find that booleans are handy when doing logic and looping through data sets (which we'll cover later in this course).

<pre>$boolTrue = true;

$boolFalse = false;</pre>

In programming, boolean values are also equal to numbers. A `true` value is also equal to `1` and a `false` value is equal to `0`. (We will cover some of the gotchas with this later in this course.)

### Casting

Through a process known as _casting_, we can tell PHP to evaluate a value as something else. This is done frequently in Nova to ensure we're storing boolean values in the database as numbers. In most cases, you'll find yourself casting `int`s and `bool`s, but there may be times where you want to cast `array`s and `string`s as well.

<pre>$boolTrue = (bool) 1;
// Would produce: true

$intTrue = (int) true;
// Would produce: 1

$boolFalse = (bool) 0;
// Would produce: false

$intFalse = (int) false;
// Would produce false</pre>

When casting an integer to a boolean, any number higher than `1` will evaluate to `true`.

## Combining Variables

It's possible to combine, or concatenate, variables together to make a different value. In PHP, you will use a period `.` to concatenate items together. When concatenating variables, the values will be combined in the order they're given to produce a new value.

<pre>$hello = 'Hello';
$world = 'World';

echo "{$hello} {$world}";
// Would produce: Hello World

$first = 5;
$second = 9;

echo $first.$second;
// Would produce: 59

echo $first.' '.$second;
// Would produce: 5 9</pre>

## Doing a Little Math

Similar to concatenation, it's possible to do math with PHP when dealing with integers. You can do any simple arithmetic you want:

<pre>echo 15 + 15;
// Would produce: 30

echo 30 - 15;
// Would produce: 15

echo 10 * 2;
// Would produce: 20

echo 100 / 10;
// Would produce: 10</pre>

Remember the rules about order of operation and the precedence of parentheses that you learned in school when doing math with PHP!