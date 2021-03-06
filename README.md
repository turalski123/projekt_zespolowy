# projekt_zespolowy WSB


# Jak Odpalic *local env*:

by odpalic projekt lokalnie potrzeba nam paru zaleznosci:
- Docker
- Docker-Compose
zaleznie od srodowiska uruchomieniowego bedziemy jeszcze potrzebowali:
- Docker-Machine

do uruchomienia srodowiska uzywamy komendy w terminalu
```shell
docker-compose -f docker-compose.dev.yaml up

# lub dla wiekszej ilosci workerow
docker-compose -f docker-compose.dev.yaml up --scale queue-worker=3
```

po skonczonym buildowaniu obrazu oraz pobraniach warstw bedziemy mieli dostep do konkretnych serwisow poprzez porty:

- 8025: web ui do mail catchera
- 27017: mongo (potrzeba clienta np "compass")
- 15672: kolejka rabbitMQ
- 3000: frontend aplikacji
- 8080: backend aplikacji (potrzeba clienta np "postman")
