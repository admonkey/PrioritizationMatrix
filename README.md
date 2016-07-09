---------------------
Prioritization Matrix
---------------------

This project provides summary analysis for aggregate evaluations.

In order to prioritize items, a series of metrics must be created to assess each item.
The metrics should take the form of a question, which are *limited to 255 characters.*
The questions must have a weight and scale defined. The default weight is 100.
A binary yes/no question should have a scale of 1. (Rated as either zero or one.)
The default scale is 10. (Rated anywhere between zero and ten.)

Example binary question:

    Has this project been approved for funding?

Example scaled question:

    How useful will this project be to all departments? (10 is very useful, and 0 is not useful.)

Similar measures may be encapsulated with component metrics.

Example parent metric with components:

    Feasibility

      Does this project have a difficult scope?
      Is this project expensive?
      Will this project take a long time to implement?
      Does this project require maintenance after completion?
      Are there many risks to this project?

# Requirements

* PHP >= 5.5.9

The install script uses [wget][3] to download the dependency package manager [Composer v1.1.2][2].
If you do not have [wget][3], then you will need to [manually download Composer][2]
and place `composer.phar` in the project root directory.

# Installation

If you're installing this for production use, then you can get all the dependencies with the script.

    ./install --prod

----------

# Development

You can run the install script with the `--dev` flag to grab the developer tools like [PHPUnit][4].

    ./install --dev

## Testing

To run the test suite, use the `test` script.

    ./test

----------

[1]:http://php.net/manual/en/book.pdo.php
[2]:https://getcomposer.org/download/
[3]:https://www.gnu.org/software/wget/
[4]:https://phpunit.de/

> Written with [StackEdit](https://stackedit.io/).
