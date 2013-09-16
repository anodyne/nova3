# Comparisons and Conditional Statements

Conditional statements, or logic, allow you to make decisions as your code is running. The most basic form of conditional statements is the if/else statement.

<pre>if ($number == 15)
{
	echo 'The number is 15';
}
else
{
	echo 'The number is not 15';
}</pre>

You aren't limited to just if/else, you can also use if/elseif/else as well.

<pre>$result = 70;

if ($result >= 75)
{ 
    echo "Passed: Grade A";
}
elseif ($result >= 60)
{
    echo "Passed: Grade B";
} 
elseif ($result >= 45)
{
    echo "Passed: Grade C";
}
else
{
    echo "Failed";
}</pre>

## Ternary Operators

Sometimes, when you need to do a simple if/else statement, it can be easier to use a ternary operator. The result is the same but with less code.

<pre>$result = 70;

$passed = ($result >= 45) ? "Passed" : "Failed";

echo $passed;

// Would produce:
Passed</pre>

## Comparison Operators

As seen in the examples above, there are several ways to compare data. Here are some of the most common:

<pre>($result == 70)
// Result equals 70

($result != 70)
// Result does not equal 70

($result > 70)
// Result is greater than 70

($result < 70)
// Result is less than 70

($result >= 70)
// Result is greater than or equal to 70

($result <= 70)
// Result is less than or equal to 70</pre>