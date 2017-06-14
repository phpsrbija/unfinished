#!/usr/bin/env bash
#packages=( )
for package in Admin Article Category Core Menu Newsletter Page Web
    do vendor/bin/phpunit --configuration="packages/$package/tests/phpunit.xml" --bootstrap="packages/$package/tests/bootstrap.php" || exit
done