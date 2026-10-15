#!/bin/sh
set -eu

DB_HOST="mariadb"
DB_PORT="3306"
DB_NAME="bd_grh"
DB_USER="root"
DB_PASS="root"

APP_DIR="/var/www/html"
LOGIN_LISTENER="${APP_DIR}/src/Users/UsersBundle/EventListener/LoginListener.php"
SECURITY_FILE="${APP_DIR}/app/config/security.yml"

if [ -n "${APP_HOST_UID:-}" ]; then
  echo "✅ UID/GID reçus depuis le host"
else
  echo "⚠️ Variables host non fournies, fallback conteneur"
  APP_HOST_USER="$(whoami)"
  APP_HOST_UID="$(id -u)"
  APP_HOST_GID="$(id -g)"
fi

APP_HOST_USER="${APP_HOST_USER:-$(whoami)}"
APP_HOST_UID="${APP_HOST_UID:-$(id -u)}"
APP_HOST_GID="${APP_HOST_GID:-$(id -g)}"

echo "👤 Utilisateur utilisé : ${APP_HOST_USER} (${APP_HOST_UID}:${APP_HOST_GID})"

echo "⏳ Attente de MariaDB sur ${DB_HOST}:${DB_PORT}..."
until nc -z "$DB_HOST" "$DB_PORT"; do
  sleep 2
done
echo "✅ Port MariaDB accessible"

echo "⏳ Attente de MariaDB prête..."
until mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USER" -p"$DB_PASS" -e "SELECT 1;" >/dev/null 2>&1; do
  sleep 2
done
echo "✅ MariaDB prête"

echo "📦 Vérification/création de la base ${DB_NAME}..."
mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USER" -p"$DB_PASS" \
  -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

cd "${APP_DIR}"

echo "📁 Ajustement des droits sur le projet..."
chown -R "${APP_HOST_UID}:${APP_HOST_GID}" "${APP_DIR}" || true

mkdir -p "${APP_DIR}/app/cache" "${APP_DIR}/app/logs"
chown -R "${APP_HOST_UID}:${APP_HOST_GID}" "${APP_DIR}/app/cache" "${APP_DIR}/app/logs" || true
chmod -R 777 "${APP_DIR}/app/cache" "${APP_DIR}/app/logs" || true

timestamp="$(date +%Y%m%d_%H%M%S)"

backup_file() {
  src="$1"
  if [ -f "$src" ]; then
    backup="${src}.bak_container_${timestamp}"
    cp "$src" "$backup"
    echo "🗂️ Backup créé : $backup"
  else
    echo "⚠️ Fichier introuvable pour backup : $src"
  fi
}

comment_login_listener_block() {
  file="$1"

  if [ ! -f "$file" ]; then
    echo "⚠️ LoginListener introuvable : $file"
    return 0
  fi

  if grep -q "https://www.dge.gouv.ci" "$file"; then
    backup_file "$file"

    sed -i \
      -e "s|^\([[:space:]]*\)header('Location: https://www.dge.gouv.ci');|\1// header('Location: https://www.dge.gouv.ci');|" \
      -e "s|^\([[:space:]]*\)exit;|\1// exit;|" \
      "$file"

    echo "✅ Lignes header(...) et exit; commentées dans LoginListener.php"
  else
    echo "ℹ️ Aucune ligne cible trouvée dans LoginListener.php"
  fi
}

remove_https_requires_channel() {
  file="$1"

  if [ ! -f "$file" ]; then
    echo "⚠️ security.yml introuvable : $file"
    return 0
  fi

  if grep -q "requires_channel:[[:space:]]*https" "$file"; then
    backup_file "$file"
    sed -i '/requires_channel:[[:space:]]*https/d' "$file"
    echo "✅ Toutes les lignes requires_channel: https ont été retirées de security.yml"
  else
    echo "ℹ️ Aucune ligne requires_channel: https trouvée dans security.yml"
  fi
}

echo "🛠️ Patch des fichiers applicatifs..."
comment_login_listener_block "$LOGIN_LISTENER"
remove_https_requires_channel "$SECURITY_FILE"

if [ -f app/console ]; then
  echo "🚀 Mise à jour du schéma Doctrine..."
  php -d memory_limit=512M app/console doctrine:schema:update --force --no-interaction || true

  echo "🧹 Nettoyage du cache prod..."
  php -d memory_limit=512M app/console cache:clear --env=prod --no-debug || true

  echo "🧹 Nettoyage du cache dev..."
  php -d memory_limit=512M app/console cache:clear --env=dev --no-debug || true

  echo "✅ Initialisation Symfony terminée"
else
  echo "⚠️ app/console introuvable dans ${APP_DIR}"
fi

echo "▶️ Démarrage de php-fpm"
exec "$@"