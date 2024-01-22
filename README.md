# Desarrollo de una API de consulta de datos de Stack Overflow
- Desarrolla una API REST en Symfony (versión 4 o superior).
- Debe contener al menos un endpoint que permita obtener datos de los foros de Stack
Overflow. Estos datos se pueden obtener de distintas fuentes. Por ejemplo, de conjuntos
de datos públicos de BigQuery. Puedes elegir usar esta fuente u otra que prefieras.
- Entrega la API en un repositorio de Github.

## Instalación
- Clonar el repositorio
- Ejecutar `docker-compose build` para construir la máquina virtual
- Ejecutar `docker-compose up -d` para levantar la máquina virtual
- Ejecutar `docker-compose exec php-fpm composer install` para instalar las dependencias


## Configuración
- Poner el fichero de las credenciales de google en `var/storage/credentials.json`
- Por defecto el fichero de credenciales se expone a la maquina virtual desde una variable de entorno configurada en el fichero `docker-compose.yml`

## Endpoints
- `api/stackvoerflow/get-posts` para obtener los posts de stackoverflow
  - Filtros disponibles: 
    - Limit: Limitar el número de registros que devuelve (100 por defecto) -> `api/stackvoerflow/get-posts?limit=1000`
    - Offset: Devuelve los registros a partir de este número (0 por defecto) -> `api/stackvoerflow/get-posts?offset=1000`
    - Sort: Ordena los resultados por ascendente o descendente (DESC por defecto) -> `api/stackvoerflow/get-posts?sort=ASC`

## Tests
- Ejecutar `docker-compose exec php-fpm bin/phpunit` para ejecutar los tests