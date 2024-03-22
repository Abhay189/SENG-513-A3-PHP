#!/bin/bash

# Replace ADMIN_PASSWORD_PLACEHOLDER in your SQL script with the actual admin password from the environment
sed -i "s/ADMIN_PASSWORD_PLACEHOLDER/${ADMIN_PASSWORD}/g" /docker-entrypoint-initdb.d/init-admin.sql.template

# Rename the file to ensure it ends with .sql so it's executed by MySQL's entrypoint
mv /docker-entrypoint-initdb.d/init-admin.sql.template /docker-entrypoint-initdb.d/init-admin.sql

# Call the original entrypoint script
exec docker-entrypoint.sh "$@"
