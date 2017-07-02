Mailhog
========

Installs [MailHog](https://github.com/mailhog/MailHog), a Go-based SMTP server and web UI/API for displaying captured emails, on RedHat or Debian-based linux systems.

Also installs [mhsendmail](https://github.com/mailhog/mhsendmail) so you can redirect system mail to MailHog's built-in SMTP server.

If you're using PHP and would like to route all PHP email into MailHog, you will need to update the `sendmail_path` configuration option in php.ini, like so:

    sendmail_path = "{{ mailhog_install_dir }}/mhsendmail"

(Replace `{{ mailhog_install_dir }}` with the actual MailHog installation directory, which is `/usr/bin` by default—e.g. `/usr/bin/mhsendmail`).

Requirements
------------

This role requires Ansible 1.4 or higher and tested platforms are listed in the metadata file.

Role Variables
--------------

Available variables are listed below, along with default values (see `defaults/main.yml`):

    mailhog_install_dir: /usr/bin

The directory into which the MailHog binary will be installed.

    mailhog_binary_url: https://github.com/mailhog/MailHog/releases/download/v0.2.1/MailHog_linux_amd64

The MailHog binary that will be installed. You can find the latest version or a 32-bit version by visiting the [MailHog project releases page](https://github.com/mailhog/MailHog/releases).

    mhsendmail_binary_url: https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64

The mhsendmail binary that will be installed. You can find the latest version or a 32-bit version by visiting the [mhsendmail project releases page](https://github.com/mailhog/mhsendmail/releases).


Author Information
------------------

Created by Vranac Srdjan http://twitter.com/vranac
