# Super Potato 🥔

## Supervisor

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

## Apache
```
<VirtualHost *:443>
        ...
        ProxyPass /wss ws://localhost:8080/
        ...
</VirtualHost>
```