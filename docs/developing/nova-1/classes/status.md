# Statuses in Nova 3

In previous versions of Nova, statuses were stored as plain strings or enumerated lists of options. While this worked for the most part, it created a disjointed API that was inconsistent from table to table. We've taken steps to correct that in Nova 3 and have changed every status in the database to be numerically based. In addition to storing less information, this also allowed us to provide a consistent interface for statuses throughout Nova.

## The Status Class

Nova 3 comes with a simple status class that provides the means of easily retrieving statuses or translating statuses from a number to a string.

### The Constants

- PENDING
- INACTIVE
- ACTIVE
- REMOVED
- IN_PROGRESS
- APPROVED
- REJECTED

Each of these constants has a single numerical value that's used by the database tables. When it comes time to use them, you can simply call them from the Status class:

<pre>Status::ACTIVE

Status::APPROVED

Status::IN_PROGRESS</pre>

### `toString()`

Sometimes you may want to get a string representation of a status. The Status class has a `toString()` method that you can use to retrieve that.

<pre>Status::toString(Status::ACTIVE);

// Would return: active</pre>

### `toInt()`

Sometimes, you may want to pass a string and get back the status value. The Status class has a `toInt()` method that you can use to do just that.

<pre>Status::toInt('pending');

// Would return: 1</pre>