#!/usr/bin/env bash

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

ansible-playbook /vagrant/provisioning/vagrant.yml -c local -i localhost,
