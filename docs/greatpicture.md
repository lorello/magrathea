Magrathea

## About
>Magrathea is the planet where your app become web services

Its an API and a command-line client

It stay on top of a Puppet-based infrastructure: a bounce of VM hosts, grouped in clusters of ubuntu servers.

For our internal needs, the first running version will not be complete and will not be another-docker-paas. We have many clusters based on IspConfig control panel, Magrathea will manage hosts inside current clusters.

### Magrathea v1 will:

1. let you configure your app to run on multiple clusters, with similar, but unique configuration on each of them.
2. let you access logs and shells on the clusters in some basic way
3. have some basic resource accounting: disk space & web traffic
4. manage app based on LAMP stack and not many more (ok, varnish & haproxy will stay in front of apache)
5. learn us to create apps ready for the cloud, for continous integrations aand continous deploy

### Magrathea v1 will NOT:

1. manage dynamic clusters, cannot autoscale and cannot be created on-the-fly, it's all statically defined

### Magrathea v2 ?

This v1 is not a big project, we hope that many opensource projects currently [under](http://flynn.io) [heavy](http://reverbrain.com/cocaine/) [development](https://github.com/unbit/uwsgi.it) will bring to us a ready-to-use PaaS, docker and ReST based, with resource accounting and scaling and so on... If this will not happen, we will develop v2 :-)

## Glossary:

* an `app`: is an application defined by a name, made up of source code and stack configuration
* an `instance`
* an `environment`

### Copyright

Magrathea is mainly ispired by all the platforms I tried or read about:
 * [dotcloud](http://docs.dotcloud.com/firststeps/how-it-works/)
 * [pagodabox](http://help.pagodabox.com/customer/portal/articles/175475)
 * [fortrabbit](http://fortrabbit.com/docs/essentials/platform-overview)
 * [flynn](https://github.com/flynn/flynn-guide/blob/master/ARCHITECTURE.md)

### Service layers

### IspConfig2 integrations points

### Basic developer workflow

### Multiple configurations for the same app

### Deploy phases

### Clusters Layers



