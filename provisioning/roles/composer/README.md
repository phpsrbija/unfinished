Composer
========

Composer tool setup, upon completion it will 
execute composer install in the project directory

Requirements
------------

This role requires Ansible 1.4 or higher and tested platforms are listed in the metadata file.

Role Variables
--------------

The variables that can be passed to this role and a brief description about
them are as follows.

    # project root location
    PROJECT_ROOT: "/var/www"
    
    # should dev libs be installed or not
    use_composer_no_dev: no

Dependencies
------------

PHP module.


Author Information
------------------

Created by Vranac Srdjan http://twitter.com/vranac
