#!/bin/bash

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
  CREATE USER efiempresa WITH PASSWORD 'secret';

  CREATE DATABASE app;
  GRANT ALL PRIVILEGES ON DATABASE app TO efiempresa;
EOSQL
echo "Auth Schema created successfully!"

