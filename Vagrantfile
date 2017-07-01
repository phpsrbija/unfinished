# setup the os detection helper
module OS
    def OS.windows?
        (/cygwin|mswin|mingw|bccwin|wince|emx/ =~ RUBY_PLATFORM) != nil
    end

    def OS.mac?
        (/darwin/ =~ RUBY_PLATFORM) != nil
    end

    def OS.unix?
        !OS.windows?
    end

    def OS.linux?
        OS.unix? and not OS.mac?
    end
end

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://atlas.hashicorp.com/search.
  config.vm.box = "ubuntu/trusty64"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  config.vm.network :forwarded_port, guest: 80, host: 4587
  config.vm.network "private_network", ip: "192.168.33.3"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  config.vm.synced_folder "./application", "/var/www/unfinished", owner: "www-data", group: "www-data"

  config.vm.boot_timeout = 9000

  config.vm.hostname = "unfinished"

  config.vm.provider "virtualbox" do |vb|
    # Boot with headless mode
    # vb.gui = true

    # Use VBoxManage to customize the VM. For example to change memory:
    vb.customize ["modifyvm", :id, "--memory", "1024"]
    vb.customize ["modifyvm", :id, "--cpus", "1"]
  end

  config.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"
  config.vm.provision :shell, path: "provisioning/windows.sh",
                      :keep_color => true

  #if OS.windows?
  #  config.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"
  #  config.vm.provision :shell, path: "provisioning/windows.sh",
  #                      :keep_color => true
  #else
  #  config.vm.provision "ansible" do |ansible|
  #    ansible.playbook = "provisioning/vagrant.yml"
  #    # output as much as you can, or comment this out for silence
  #    # ansible.verbose = "vvvv"
  #    ansible.sudo = true
  #  end
  #end

end
