#!/usr/bin/env bash

echo "────────────────────────────────────────────────────────────────────────────────────────────────────────
 __________  ___ _____________    _________           ___     __                       __            _
 \______   \/   |   \______   \  /   _____/ __________\_ |__ |__|____    _______ __ __|  | ________ | |
  |     ___/    ~    \     ___/  \_____  \ / __ \_  __ \ __ \|  \__  \   \_  __ \  |  \  | \___   / | |
  |    |   \    Y    /    |      /        \  ___/|  | \/ \_\ \  |/ __ \_  |  | \/  |  /  |__/    /   \|
  |____|    \___|_  /|____|     /_______  /\___  |__|  |___  /__(____  /  |__|  |____/|____/_____ \  __
                  \/                    \/     \/          \/        \/                          \/  \/"
echo "────────────────────────────────────────────────────────────────────────────────────────────────────────"

echo "
────────────────────────────────────────────────────────────────────────────────────────────────────────
   Sit back, relax, this may take a while
────────────────────────────────────────────────────────────────────────────────────────────────────────"

if [ $(dpkg-query -W -f='${Status}' ansible 2>/dev/null | grep -c "ok installed") -eq 0 ];
then
    echo "Add APT repositories"
    export DEBIAN_FRONTEND=noninteractive
    sudo apt-get install -y python-software-properties
    sudo apt-get install -y python-setuptools

    echo "Installing Ansible"
    sudo easy_install pip
    sudo pip install ansible
    echo "Ansible installed"
fi

ansible-playbook /var/www/unfinished/provisioning/vagrant.yml -c local -i localhost,

echo "
────────────────────────────────────────────────────────────────────────────────────────────────────────
   Almost done,
   In your /etc/hosts file add line
   192.168.33.3 unfinished.dev
────────────────────────────────────────────────────────────────────────────────────────────────────────"
