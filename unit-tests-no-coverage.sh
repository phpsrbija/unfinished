#!/usr/bin/env bash
packages=( Admin Article Category Menu Newsletter Page Web)
for package in "${packages[@]}"
    do vendor/bin/phpunit --configuration="packages/$package/tests/phpunit.xml" --bootstrap="packages/$package/tests/bootstrap.php" || exit
done