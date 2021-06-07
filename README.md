# Super Potato 🥔

`Super Potato` is an ADD (Aerodrom Data Display) used by controllers on the VATSIM online flying network.

The tool displays valuable information for online vATC like active runways, decoded METAR information, visual departures, closed runways and missed approaches.

`Super Potato` was developed to be used while controlling Austrian airspace only.

## Usage

### Basics

To use `Super Potato`, you need a VATSIM account which is associated to the VACC Austria sub-divison.
The login is only possible via VATSIM Connect.

The data displayed by `Super Potato` is fetched from the VATSIM data feed as well as the VATSIM METAR API.
`Super Potato` can only display data if an ATIS is set online on the concerning airports.

#### Notifications

If you first enter `Super Potato`, your browser may ask for permissions to let `Super Potato` send notifications.
If you grant permission, you'll get notifications for events such as missed approached and closed runways including the concering airport.

#### Menu

In the menu, you can navigate between the dashboard and all supported airports by clicking on the menu item or pressing the numeric key displayed on the menu items on your keyboard.
If certain conditions are met (missed approach, closed runway), you'll see a red notification dot on the corresponding airport menu item.

#### Dashboard

The dashboard displays the arrival runway(s), departure runway(s) as well as the transition level of all supported airports.
Additionally, a log of all users who triggered certain actions (missed approach, closed runway and reopened runway) will be displayed if such events occurred.

#### Airport view

Each airport view is divided into the ATIS/METAR widget, the runway widget, the action widget and the raw METAR widget

##### ATIS/METAR Widget

This widgets displays the current ATIS Letter, the transition level, the QNH, the wind (mean speed, mean direction), gusts (if present) and the current MET conditions (VMC, LVP1, LVP2 and LVP3). 

##### Runway Widget

This widget displays the following data

- All runways of the airport
- The current departure runway(s)
- The current arrival runway(s)
- Closed runway(s), if present
- A windrose on each runway
- The current RVR on each runway, if present
- Crosswind (X), head (H) or tailwind (T) components for each runway, if the wind is not VRB
- A missed approach indicator, if present
- A wind shear indicator, if present

##### Action Widget

This widget allows certain actions to be triggered

###### Visual Departures

A controller can indicate that visual departures are approved to one or many of the four cardinal directions.

###### Closed Runways

A controller can indicate that a certain runway is currently closed. This action triggers an audible warning and has a time out of 30 seconds before it can be canceled and re-triggered. Once a runway is reopened, an audible sound will be triggered.

###### Missed Approach

A controller can indicate that a missed approach is in progress. This action triggers an audible warning and has a time out of 30 seconds before it be canceled and re-triggered.

##### Raw METAR Widget

This widget displays the current raw METAR

## Setup

### Requirements

`Super Potato` is build with CakePHP v4, Vue.js v3 and Tailwind CSS v2.
To install `Super Potato`, you need a machine with the following things installed:

- Apache 2.4 (you should be able to use nginx as well)
- MySQL 8.0 or newer
- PHP 7.4 or newer with the common, intl, mbstring and the zmq extension
- node.js 14 or newer
- composer 2.0 or newer
- Yarn 1.0 or newer (Yarn 2.0 is not supported)

### Installation

- Create a new database using the `utf8mb4` encoding and `utf8mb4_unicode_520_ci` collation
- Clone this repository into your web-serves webroot directory
- Create a copy of the `config/.env.default` file named `config/.env` and fill out the values. As an alternative, populate your serves environment with the needed variables
- Run `composer intall --no-dev` to install all composer dependencies
- Run `yarn install --frozen-lock` to install all node_modules dependencies
- Run `bin\cake migrations migrate` to populate the database
- Import the `Seeds/airport.sql` file into your database
- Run `yarn prod` to the build all frontend assets

### Supervisor

`Super Potato` uses various long running php processes to fetch data and push data via web-sockets.
To control these processes, add the following to the `supervisor` config.

```
[program:pusher]
command=sh -c "exec bin/cake push"
directory=/var/www/super-potato
user=deployer
autostart=true
autorestart=true
stdout_logfile=/var/www/super-potato/logs/pusher.log
stdout_logfile_maxbytes=1MB
stderr_logfile=/var/www/super-potato/logs/pusher.log
stderr_logfile_maxbytes=1MB

[program:feed]
command=sh -c "exec bin/cake fetch_feed"
directory=/var/www/super-potato
user=deployer
autostart=true
autorestart=true
stdout_logfile=/var/www/super-potato/logs/feed.log
stdout_logfile_maxbytes=1MB
stderr_logfile=/var/www/super-potato/logs/feed.log
stderr_logfile_maxbytes=1MB

[program:metar]
command=sh -c "exec bin/cake fetch_metar"
directory=/var/www/super-potato
user=deployer
autostart=true
autorestart=true
stdout_logfile=/var/www/super-potato/logs/metar.log
stdout_logfile_maxbytes=1MB
stderr_logfile=/var/www/super-potato/logs/metar.log
stderr_logfile_maxbytes=1MB
```

### Apache

To enable web-sockets, you have to enable the apache `proxy_wstunnel`, `proxy_http` and the `proxy` module.
Thereafter, add a `ProxPass` config to your apache `VirtualHost` config.

```
<VirtualHost *:443>
        ...
        ProxyPass /wss ws://localhost:8080/
        ...
</VirtualHost>
```

### Cron Jobs

Add two cron jobs for the deployer user.

```
0 5 * * * sudo supervisorctl restart all
* * * * * cd /var/www/super-potato/; bin/cake reset_missed_approach
0 * * * * cd /var/www/super-potato/; bin/cake fetch_taf
```
