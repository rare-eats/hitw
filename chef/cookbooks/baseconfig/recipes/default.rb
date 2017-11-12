# Make sure the Apt package lists are up to date, so we're downloading versions that exist.
cookbook_file "apt-sources.list" do
  path "/etc/apt/sources.list"
end
execute 'apt_update' do
  command 'apt-get update'
end

# Base configuration recipe in Chef.
package "wget"
package "ntp"
package "unzip"
package "apache2"
package "php"
package "libapache2-mod-php"
package "postgresql"
package "php-pgsql"


cookbook_file "ntp.conf" do
  path "/etc/ntp.conf"
end
execute 'ntp_restart' do
  command 'service ntp restart'
end

cookbook_file "apache2.conf" do
  path "/etc/apache2/apache2.conf"
end
cookbook_file "rareeats.conf" do
	path "/etc/apache2/sites-available/rareeats.conf"
end

execute 'disable_default_site' do
	command 'a2dissite 000-default'
end
execute 'enable_rare_eats_site' do
	command 'a2ensite rareeats.conf'
end

execute 'enable_enmod' do
	command 'a2enmod rewrite'
end

execute 'apache2_restart' do
  command 'service apache2 restart'
end

execute 'postgres_setup' do
	command 'echo "CREATE DATABASE webbase; CREATE USER webuser WITH PASSWORD \'password\'; GRANT ALL PRIVILEGES ON DATABASE webbase TO webuser;" | sudo -u postgres psql'
end