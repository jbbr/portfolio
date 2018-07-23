# Portfolio

## Installation

1. Git Repository klonen:
```
$ git clone https://collaborating.tuhh.de/itbh/portfolio-team/Neuentwicklung-Portfolio.git
$ cd Neuentwicklung-Portfolio/
```

2. Portfolio Docker Image erstellen (kann zwischen 10 - 15 Minuten dauern):
```
$ docker build -t portfolio .
```

3. Container abgekoppelt (-d) starten. Hinweis: Vorher überprüfen, dass kein weiterer Webserver auf Port 80 lauscht:
```
$ docker-compose up -d
```

4. Portfolio im Browser öffnen: http://localhost/


5. MailHog im Browser öffnen um Bestätigunsmails abzufangen: http://localhost:8025/