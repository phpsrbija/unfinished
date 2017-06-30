# Project Unfinished

[![Build Status](https://travis-ci.org/phpsrbija/unfinished.svg?branch=master)](https://travis-ci.org/phpsrbija/unfinished)
[![Coverage Status](https://coveralls.io/repos/github/phpsrbija/unfinished/badge.svg)](https://coveralls.io/github/phpsrbija/unfinished)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/phpsrbija/unfinished/badges/quality-score.png?s=4023c984fc1163a44f4220cd7d57406643ced9f2)](https://scrutinizer-ci.com/g/phpsrbija/unfinished/)

## Instalation

```
git clone https://github.com/phpsrbija/unfinished.git
cd unfinished
vagrant up

open file /etc/hosts and at the end add one line: 
192.168.33.3 unfinished.dev
```

Open in your browser http://unfinished.dev and voila!

Admin is at http://unfinished.dev/admin  
user: admin@unfinished.com    
pass: testtest

## Our main philosophy of software architecture

Packages, packages and packages... 


Main goal is to break all code to fully separated packages with no dependencies. 
If some package have dependence with other that should relay in composer.json
For eg. article can have dependence from category package.

Such a way will lead us to easier: 
- Adding new features as separated package (scale by team)
- Replace or refactor some functionality or whole package - not whole app 
- Software versioning - Versioning of functionality through package versioning

## Road Map

### New packages
- [x] News Letter
- [ ] Contact Us
- [ ] Media (for images, admin)
- [ ] User (for web users)

### Reafctoring 
     
- [ ] Refactor and extend Admin packages. Wee need to have:
     - [ ] Admin package (very tiny, hold only layout.phtm with navigation config)
     - [ ] AdminUser package
     - [ ] AdminPermissions package

- [ ] Pull apart current **Article** package into separated packages per article type, allowing easy to add/remove type
     - [ ] PostArticle, 
     - [ ] VideoArticle, 
     - [ ] EventArticle, 
     - [ ] DiscussionArticle

- [ ] Introduce Entities and Hydration (as in Page package)

### Wish list
- [ ] Switch current Zend-Router router with FastRoute 
- [ ] Move all packages in separate repository (main repo need to have install process)
- [ ] Scale images during upload process; change upload lib.
- [ ] Better naming of variables/functions & write the documentation
- [ ] Devops things as well as rise up code coverage with Unit testing
- [ ] Better handling exceptions per package

## Local development setup

The local development is meant to be used in a vagrant provisioned box.

The provisioner for the project is ansible.

Once you have the prerequisites setup, you can run the
```
vagrant up
```
from you terminal to start the process up.

If you do not see an error message, go get yourself a cup of coffee or your favorite beverage,
you deserve it.

If you start seeing the connection timeout after adding of the private key
```
    default: SSH username: vagrant
    default: SSH auth method: private key
    default: Warning: Connection timeout. Retrying...
    default: Warning: Connection timeout. Retrying...
```
You should open up the Virtualbox, click the vm running (name should be along the lines of 4cinc-thinkfasttoys....)
and reset it (on OSX it is cmd+t). This is due to some weird bug somewhere on intersection of vagrant, virtualbox and
this ubuntu cloud image.
After the initial virtual machine build, you will not need to use this.

## SSH into the Vagrant box

If you are not already in vagrant, ssh into the Vagrant box by running from you terminal
```bash
vagrant ssh
```

Once you are in Vagrant box shell, change to the project root directory by running from you terminal
```bash
cd /var/www/unfinished
```

## Xdebug

When you need to debug something, and var_dump just does not cut it (and it never should),
you can use XDebug remote debugging abilities to step debug through the problem.
Xdebug has been installed, and has been configured for remote debugging.

Your debugger should listen for ide key: **vagrant-xdebug**

For PHPStorm setup follow the [PHP Remote Debug][phpstorm-remote-debug] instructions, and set the ide key to ``vagrant-xdebug``.

If you prefer standalone debuggers take a look at awesome [pugdebug] by [Robert Basic][robertbasic]

## Database info

You have a local mysql database setup, the db name is `unfinished`, the user is `dev` the password is `dev`.

## Mailhog

For convenience [Mailhog][mailhog] has been setup, so any and all email should be send to the local mailhog
server during development.
To send emails to mailhog, use `127.0.0.1` as smtp/mailer host, and use port 1025 in your config

When you need to access the mailhog web ui, you need to open url `http://192.168.33.11:8025` in your browser

## Redis

For convenience, [Redis][redis] has also been setup, you can access it from you vagrant box by executing `redis-cli`

[Vagrant]: http://www.vagrantup.com/downloads.html
[Ansible]: http://docs.ansible.com/intro_installation.html
[phpstorm-remote-debug]: https://confluence.jetbrains.com/display/PhpStorm/Debugging+PHP+Web+Applications+with+Run+Debug+Configurations
[pugdebug]: https://github.com/robertbasic/pugdebug
[robertbasic]: http://twitter.com/robertbasic
[mailhog]: https://github.com/mailhog/MailHog
[redis]: https://redis.io
