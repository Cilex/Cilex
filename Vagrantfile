# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant::Config.run do |config|
  config.vm.box = "trusty64"
  config.vm.box_url = "https://cloud-images.ubuntu.com/vagrant/trusty/current/trusty-server-cloudimg-amd64-vagrant-disk1.box"

  config.vm.provision :puppet do |puppet|
     puppet.manifests_path = ".puppet/manifests"
     puppet.manifest_file  = "manifest.pp"
     puppet.options        = [ '--verbose' ]
  end
end
