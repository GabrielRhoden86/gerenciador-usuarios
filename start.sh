#!/bin/sh

# Substitui ${PORT} no nginx.conf por seu valor real
envsubst '${PORT}' < /etc/nginx/http.d/default.conf > /etc/nginx/http.d/default.conf.final

# Usa o arquivo final como configuração
mv /etc/nginx/http.d/default.conf.final /etc/nginx/http.d/default.conf

# Inicia o Supervisor normalmente
./docker-entrypoint.sh
