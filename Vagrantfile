Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/focal64"
  config.vm.network "private_network", ip: "192.168.33.10"
  config.vm.network "forwarded_port", guest: 80, host: 8080
  
  config.vm.provider "virtualbox" do |vb|
    vb.memory = "2048"
    vb.cpus = 2
  end

  config.vm.provision "shell", inline: <<-SHELL
    apt-get update
    apt-get install -y apache2 php8.2 php8.2-curl php8.2-gd php8.2-mbstring php8.2-xml php8.2-zip unzip

    # Install Composer
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer

    # Configure Apache
    a2enmod rewrite
    sed -i 's!/var/www/html!/var/www/html/web!g' /etc/apache2/sites-available/000-default.conf
    systemctl restart apache2
  SHELL
end 