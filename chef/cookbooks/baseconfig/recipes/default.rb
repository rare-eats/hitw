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
package "apache2"
package "unzip"
package "php"
package "postgresql"

cookbook_file "ntp.conf" do
  path "/etc/ntp.conf"
end
execute 'ntp_restart' do
  command 'service ntp restart'
end

cookbook_file "apache2.conf" do
  path "/etc/apache2/apache2.conf"
end
execute 'apache2_restart' do
  command 'service apache2 restart'
end
