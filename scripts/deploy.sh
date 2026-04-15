#!/bin/bash
set -e

DEPLOY_USER="jose"
DEPLOY_HOST="192.168.1.33"
DEPLOY_PORT="22"
DEPLOY_PATH="/var/www/html/mi-proyecto"
RELEASES_PATH="$DEPLOY_PATH/releases"
CURRENT_LINK="$DEPLOY_PATH/current"
KEEP_RELEASES=5

TIMESTAMP=$(date +%Y%m%d%H%M%S)
RELEASE_NAME="$TIMESTAMP"
RELEASE_PATH="$RELEASES_PATH/$RELEASE_NAME"

echo "=== INICIANDO DEPLOY ==="
echo "Timestamp: $TIMESTAMP"
echo "Release: $RELEASE_NAME"

ssh $DEPLOY_USER@$DEPLOY_HOST "mkdir -p $RELEASES_PATH"

echo "Subiendo archivos..."
rsync -az --exclude '.git' --exclude 'node_modules' --exclude 'vendor' --exclude '.env' -e "ssh -p $DEPLOY_PORT" ./ $DEPLOY_USER@$DEPLOY_HOST:$RELEASE_PATH/

echo "Instalando dependencias..."
ssh $DEPLOY_USER@$DEPLOY_HOST "cd $RELEASE_PATH && composer install --no-dev --optimize-autoloader 2>/dev/null || true"

echo "Creando enlace simbólico..."
ssh $DEPLOY_USER@$DEPLOY_HOST "ln -sfn $RELEASE_PATH $CURRENT_LINK"

echo "Limpiando releases antiguas (manteniendo $KEEP_RELEASES)..."
ssh $DEPLOY_USER@$DEPLOY_HOST "cd $RELEASES_PATH && ls -1t | tail -n +$((KEEP_RELEASES + 1)) | xargs -r rm -rf"

echo "=== DEPLOY COMPLETADO ==="
echo "Release: $RELEASE_NAME"
echo "Path: $RELEASE_PATH"
