# Autodiscover

IMAP/SMTP autodiscover for email clients.

## Usage

Copy the contents of the `.env.example` file in this repository to a new file called `.env`, and replace the values with your own. Next up, create a `docker-compose.yml` file with the following content:

```yml
services:
  autodiscover:
    image: ghcr.io/wardpieters/autodiscover:latest
    ports:
      - "8000:80"
    env_file:
      - .env
```

Run `docker-compose up -d` to start the service. The autodiscover service will be available on port 8000.
