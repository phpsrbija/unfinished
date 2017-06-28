#!/usr/bin/env bash
packages=(Admin Article Category Meetup Menu Newsletter Page Std Web)
for package in "${packages[@]}"
    do vendor/bin/phpunit --configuration="packages/$package/tests/phpunit.xml" --bootstrap="packages/$package/tests/bootstrap.php" || exit
done