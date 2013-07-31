Exec { path => [ '/bin/', '/sbin/', '/usr/bin/', '/usr/sbin' ] }

exec { 'apt-get update':
  command => 'apt-get update',
  timeout => 60,
  tries => 3
}

class { 'apt':
  always_apt_update => true,
}

package { ['python-software-properties']:
  ensure => 'installed',
  require => Exec['apt-get update'],
}

$sysPackages = ['build-essential', 'git', 'curl']
package { $sysPackages:
  ensure => 'installed',
  require => Exec['apt-get update'],
}

class { 'apache': }

apache::module { 'rewrite': }
apache::module { 'expires': }
apache::module { 'headers': }

apache::vhost { 'default':
  docroot => '/vagrant/web/',
  server_name => false,
  priority => '',
  template => 'apache/virtualhost/vhost.conf.erb',
}

class { 'php': }

$phpModules = ['imagick', 'xdebug', 'curl', 'mysql', 'cli', 'intl', 'mcrypt', 'gd']

php::module { $phpModules: }

php::ini { 'php':
  value => ['date.timezone = "America/Chicago"'],
  target => 'php.ini',
  service => 'apache',
}

class { 'mysql':
  root_password => 'root',
  require => Exec['apt-get update'],
}

mysql::grant { 'now':
  mysql_privileges => 'ALL',
  mysql_db => 'now',
  mysql_user => 'now',
  mysql_password => 'now',
  mysql_host => 'localhost',
  mysql_grant_filepath => '/home/vagrant/puppet-mysql',
}
