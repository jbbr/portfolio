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

      - HELP_URL=https://fizban05.rz.tu-harburg.de/itbh/portfolio-team/portfolio-hilfe
      - IMPRINT_URL=/imprint
      - PRIVACY_URL=/privacy

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

  admin:
    image: 'phpmyadmin/phpmyadmin'
    ports:
      - '8030:80'
    depends_on:
      - db
    links:
      - db
    mem_limit: 512MB

volumes:
  db-data:

```

#### Starten der Umgebung

```
cd ~/portfolio
docker-compose up
```

#### Account registrieren

- Im Browser die URLs `localhost:8080` und `localhost:8025` öffnen.
- Unter `localhost:8080` einen Account anlegen
- unter `localhost:8025` findet sich die Anwendung *MailHog*, in der die Bestätigungsmail für den Account bestätigt werden muss. Natürlich ist das auch durch das direkte Bearbeiten eines Accounts möglich, ähnlich dem Vorgehen, wie unter **Bereits registrierten Account auf Admin hochstufen** beschrieben.

#### Bereits registrierten Account auf Admin hochstufen

- Im Browser die URL `localhost:8030` öffnen.
- Unter `localhost:8030` findet sich die Anwendung *phpMyAdmin*
- Mit den Zugangsdaten anmelden, die in der Datei `docker-compose.yml` für den Zugang zur Datenbank definiert sind
- In der Tabelle `portfolio.users` dem gewünschten Account im Feld `is_admin` eine `1` eintragen