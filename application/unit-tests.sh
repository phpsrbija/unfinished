#!/usr/bin/env bash
packages=(Admin Article Category Meetup Menu Newsletter Page Std Web)
for package in "${packages[@]}"
    do vendor/bin/phpunit --configuration="packages/$package/tests/phpunit.xml" --bootstrap="packages/$package/tests/bootstrap.php" --coverage-clover="packages/$package/tests/clover.xml" || exit
    if [ -f packages/$package/tests/clover.xml ];
        then
#            php vendor/digitronac/coverage-checker/coverage-checker.php packages/$package/tests/clover.xml 100 || exit
            php vendor/digitronac/coverage-checker/coverage-checker.php packages/$package/tests/clover.xml 100
    fi
done