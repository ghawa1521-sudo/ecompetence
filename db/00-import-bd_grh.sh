#!/bin/sh
set -e

echo "Création de la base bd_grh si absente..."
mysql -uroot -proot -e "CREATE DATABASE IF NOT EXISTS bd_grh CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

echo "Import du dump SQL dans bd_grh..."
mysql -uroot -proot bd_grh < /docker-entrypoint-initdb.d/zz_bd_grh.sql

echo "Import terminé."