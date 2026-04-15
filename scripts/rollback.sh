#!/bin/bash
set -e

DEPLOY_USER="jose"
DEPLOY_HOST="192.168.1.33"
DEPLOY_PORT="22"
DEPLOY_PATH="/var/www/html/mi-proyecto"
RELEASES_PATH="$DEPLOY_PATH/releases"
CURRENT_LINK="$DEPLOY_PATH/current"

if [ -z "$1" ]; then
    echo "Uso: ./rollback.sh <timestamp>"
    echo ""
    echo "Releases disponibles:"
    ssh $DEPLOY_USER@$DEPLOY_HOST "ls -1t $RELEASES_PATH/"
    exit 1
fi

RELEASE_NAME="$1"
RELEASE_PATH="$RELEASES_PATH/$RELEASE_NAME"

echo "=== INICIANDO ROLLBACK ==="
echo "Release objetivo: $RELEASE_NAME"

if ssh $DEPLOY_USER@$DEPLOY_HOST "[ ! -d $RELEASE_PATH ]"; then
    echo "ERROR: Release $RELEASE_NAME no existe"
    exit 1
fi

echo "Creando enlace simbólico..."
ssh $DEPLOY_USER@$DEPLOY_HOST "ln -sfn $RELEASE_PATH $CURRENT_LINK"

echo "=== ROLLBACK COMPLETADO ==="
echo "Ahora usando: $RELEASE_NAME"
