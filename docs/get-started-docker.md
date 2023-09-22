:arrow_left: [Index](index.md)

# Inizializzazione docker LAMP 

Come installare ed eseguire lo stack.

## How To

### Install

#### Tools
installa sul tuo ambiente locale se non già installati i seguenti tools:
- [git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
- [docker](https://docs.docker.com/engine/install/)
- [docker compose](https://docs.docker.com/compose/install/)

#### Preparazione
Clone questo repository con:
```bash
git clone git@bitbucket.org:alepacifici/docker-lamp-nginx.git `<dir>`
```

dove `<dir>`è la directory in cui vuoi clonare il repository.

Attenzione :warning: : se il processo di clonazione fallisce, è probabilmente a causa delle autorizzazioni ssh, in tal caso consulta i documenti di Github e assicurati che il tuo utente github abbia accesso al repository e abbia la tua chiave ssh associata.

Passa al progetto `<dir>`(ad esempio con mv `<dir>`).

### Run
Nell'ambiente locale abbiamo bisogno di una composizione docker aggiuntiva, quindi è necessario copiare il file docker-compose.override.yml.dist in docker-compose.override.yml.

Ora esegui il pull delle immagini necessarie ( solo se si aggiungono/ immagini da utilizzare ):
```bash
docker compose pull
```

Ora esegui la build dei containers ( solo se si aggiungono/modificano le configurazioni dei container ):
```bash
docker compose build
```

Avvia tutti i container containers attivi:
```bash
docker compose up -d
```

Controlla tutti i containers attivi:
```bash
docker compose ps
```

Importa il database necessario al progetto da gestire:
```bash
docker compose run php importDb `<dbname>` `<sqlImport>`
```
dove `<dbname>`è il nome completo del database, `<sqlImport>`è il nome completo del file sql che si vuole importare

ES: `docker compose run php importDb trading trading20230120.sql`


Dovresti vedere tutti i servizi docker-compose.yml e docker-compose.override.yml in esecuzione.