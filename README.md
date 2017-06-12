# unfinished

[![Build Status](https://travis-ci.org/phpsrbija/unfinished.svg?branch=master)](https://travis-ci.org/phpsrbija/unfinished)
[![Coverage Status](https://coveralls.io/repos/github/phpsrbija/unfinished/badge.svg?branch=master)](https://coveralls.io/github/phpsrbija/unfinished?branch=master)
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

### Reafctoring 

- [x] Introduce a new package "Page" for a single pages like "about us"
- [ ] Add type to the category (post, video, event, discussion...) also add "is_visible" and SEO tags
- [ ] Pull apart current **Article** package into separated packages per article type, allowing easy to add new type or remove. New packages would be: 
     - [ ] PostArticle, 
     - [ ] VideoArticle, 
     - [ ] EventArticle, 
     - [ ] DiscussionArticle
     
- [ ] Get rid of the Core package as completely unnecessary package
- [ ] Refactor Admin package to hold only layout.phtm with admin style (css/html)
- [ ] Create AdminUser package
- [ ] Create AdminAcl package
- [ ] Better naming of variables/functions & write the documentation
- [ ] Devops things as well as rise up code coverage with Unit testing
- [ ] Scale images during upload process

### New packages
- [ ] Contact Us
- [x] News Letter
- [ ] Media (for images)
- [ ] User (for web users)
