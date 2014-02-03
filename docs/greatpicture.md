Magrathea

## About
>Magrathea is the planet where your source code become a scalable & resilient web service

Its an API and a command-line client

It stay on top of a Puppet-based infrastructure: a bounce of VM hosts, grouped in clusters of ubuntu servers.

For our internal needs, the first running version will not be complete and will not be another-docker-paas. We have many clusters based on IspConfig control panel, Magrathea will manage hosts inside current clusters.

### Magrathea v1 will:

1. let you configure your app to run on multiple clusters, with similar, but unique configuration on each of them.
2. let you access logs and shells on the clusters in some basic way
3. have some basic resource accounting: disk space & web traffic
4. manage app based on LAMP stack and not many more (ok, varnish & haproxy will stay in front of apache)
5. learn us to create apps ready for the cloud, for continuous integration and continuous deploy

### Magrathea v1 will NOT:

1. manage dynamic clusters, they cannot autoscale and cannot be created on-the-fly, they are all statics from an application point of view.

### Magrathea v2 ?

This v1 is not a big project, we hope that many opensource projects currently [under](http://flynn.io) [heavy](http://reverbrain.com/cocaine/) [development](https://github.com/unbit/uwsgi.it) will bring to us a ready-to-use PaaS, docker based and ReST speaking, with resource accounting and scaling and oAuth2 security and many other beautiful buzz-features ... If this will not happen, we will develop v2 :-)

## Glossary:

* an `app`: is an application defined by a name, made up of source code and stack configuration
* an `instance`: is an app living on a cluster
* an `cluster`: is a group of nodes

### Copyright

Magrathea is mainly ispired by all the platforms I tried or read about:
 * [dotcloud](http://docs.dotcloud.com/firststeps/how-it-works/)
 * [pagodabox](http://help.pagodabox.com/customer/portal/articles/175475)
 * [fortrabbit](http://fortrabbit.com/docs/essentials/platform-overview)
 * [flynn](https://github.com/flynn/flynn-guide/blob/master/ARCHITECTURE.md)
 * [cocaine](https://github.com/cocaine/cocaine-core/wiki/architecture)

### Service layers

Each cluster is made of layers, each one erogating single services

### IspConfig2 integrations points

* after each ispconfig write, app instances will be statically updated on magrathea

### Basic developer workflow

Create a [YAML file](http://yaml.org/start.html) for your app

[Test it](http://yamllint.com/) if you are not sure it's syntactically valid

Invoke _Think Deep_:
    
    td app deploy

### Multiple configurations for the same app

Simply use labels inside configuration file `magrathea.yml`

### Deploy phases

[...]

### Clusters Layers

layer 1 - storage: 

  shared-storage: files, 
  local-storage: code?
  writable paths, readonly paths

layer 2 - db: memcache, mysql

layer 3 - app: php-fpm, tomcat, apache

layer 4 - proxy: varnish, nginx

layer 5 - routing: haproxy

layer 6 - support: cron, monitoring, backup

### Security

Until now, IP based access list

