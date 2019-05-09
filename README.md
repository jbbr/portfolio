# Portfolio

Wenige Kommandos führen zu einer Portfolio-Installation auf dem eigenen System:

Notwendige Voraussetzungen sind [Docker CE](https://docs.docker.com/install/) und [Docker Compose](https://docs.docker.com/compose/install/).

#### Erstellen eines Verzeichnisses für die Portfolio Docker Compose Konfiguration 

```
mkdir ~/portfolio
cd ~/portfolio
```

#### Kopieren der folgenden Konfiguration in die Datei `docker-compose.yml` im Verzeichnis `~/portfolio`

```
version: '2'

services:
  php:
    image: itbh/portfolio
    ports:
      - "8080:80"
    depends_on:
      - db
    environment:
      - APP_ENV=local
      - APP_DEBUG=true
      - APP_LOG_LEVEL=debug
      - APP_URL=http://localhost

      - DB_CONNECTION=mysql
      - DB_HOST=db
      - DB_PORT=3306
      - DB_DATABASE=portfolio
      - DB_USERNAME=portfolio
      - DB_PASSWORD=portfolio

      - BROADCAST_DRIVER=log
      - CACHE_DRIVER=redis
      - SESSION_DRIVER=redis
      - QUEUE_DRIVER=sync

      - REDIS_HOST=redis
      - REDIS_PASSWORD=null
      - REDIS_PORT=6379

      - MAIL_DRIVER=smtp
      - MAIL_HOST=mailhog
      - MAIL_PORT=1025
      - MAIL_USERNAME=null
      - MAIL_PASSWORD=null
      - MAIL_ENCRYPTION=null
      - MAIL_FROM_ADDRESS=team@ausbildungsportfolio.net
      - MAIL_FROM_NAME=Ausbildungsportfolio

  db:
    image: mariadb
    ports:
      - "3306"
    environment:
      - MYSQL_ROOT_PASSWORD=portfolio
      - MYSQL_DATABASE=portfolio
      - MYSQL_USER=portfolio
      - MYSQL_PASSWORD=portfolio
    volumes:
      - db-data:/var/lib/mysql

  redis:
    image: redis
    ports:
      - "6379"

  mailhog:
    image: mailhog/mailhog
    ports:
      - "8025:8025"

volumes:
  db-data:
```

#### Starten der Umgebung

```
docker-compose up
```

#### Account registrieren

- Im Browser die URLs localhost:8080 und localhost:8025 öffnen.
- Unter localhost:8080 einen Account anlegen
- unter localhost:8025 in der Bestätigungsmail den Account bestätigen