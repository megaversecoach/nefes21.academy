#!/usr/bin/env bash
set -euo pipefail
DOMAIN="nefes21.academy"
WEBROOT="/www/wwwroot/${DOMAIN}"
REPO_DIR="/opt/nefes21-academy-backup"
STAMP="$(date +%F_%H%M)"
cd "$REPO_DIR"

DB_NAME=$(grep -E "define\(\s*'DB_NAME'"     "$WEBROOT/wp-config.php" | sed -E "s/.*'DB_NAME',\s*'([^']+)'.*/\1/")
DB_USER=$(grep -E "define\(\s*'DB_USER'"     "$WEBROOT/wp-config.php" | sed -E "s/.*'DB_USER',\s*'([^']+)'.*/\1/")
DB_PASS=$(grep -E "define\(\s*'DB_PASSWORD'" "$WEBROOT/wp-config.php" | sed -E "s/.*'DB_PASSWORD',\s*'([^']+)'.*/\1/")
DB_HOST=$(grep -E "define\(\s*'DB_HOST'"     "$WEBROOT/wp-config.php" | sed -E "s/.*'DB_HOST',\s*'([^']+)'.*/\1/")
DB_HOST="${DB_HOST:-127.0.0.1}"

mkdir -p db
MYSQL_PWD="${DB_PASS}" mysqldump -u "${DB_USER}" -h "${DB_HOST}" \
  --single-transaction --quick --routines --triggers \
  --no-tablespaces \
  "${DB_NAME}" > "db/${DB_NAME}_${STAMP}.sql"
gzip -f "db/${DB_NAME}_${STAMP}.sql"
ln -sfn "${DB_NAME}_${STAMP}.sql.gz" "db/${DB_NAME}_latest.sql.gz"

mkdir -p web
rsync -a --delete \
  --exclude=".git" \
  --exclude="wp-content/cache" \
  --exclude="wp-content/uploads/cache" \
  --exclude="*.log" \
  "${WEBROOT}/" "web/"

git lfs install || true
git lfs track "*.sql.gz" || true
git add -A
git commit -m "Backup: ${DOMAIN} ${STAMP}" || echo "No changes."
git push origin main || true
