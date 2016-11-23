VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.provider "virtualbox" do |v|
          v.memory  = 1024
          v.cpus    = 1
  end
  config.vm.box = "ubuntu/trusty64"
  config.vm.provision :shell, path: "bootstrap.sh"
  config.vm.network :forwarded_port, guest: 80, host: 4587
  config.vm.network "private_network", ip: "192.168.33.3"
  config.vm.synced_folder ".", "/var/www/unfinished"
end
