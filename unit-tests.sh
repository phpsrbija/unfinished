#!/usr/bin/env bash
#packages=( )
for package in Admin Article Category Menu Newsletter Page Web
    do vendor/bin/phpunit --configuration="packages/$package/tests/phpunit.xml" --bootstrap="packages/$package/tests/bootstrap.php" --coverage-clover="packages/$package/tests/clover.xml" || exit
    if [ -f packages/$package/tests/clover.xml ];
        then
#            php vendor/digitronac/coverage-checker/coverage-checker.php packages/$package/tests/clover.xml 100 || exit
            php vendor/digitronac/coverage-checker/coverage-checker.php packages/$package/tests/clover.xml 100
    fi
done