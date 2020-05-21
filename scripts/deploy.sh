#!/usr/bin/env bash

SERVER="$1"
SSH_USER="$2"
SSH_KEY="$3"
SSH_PORT="$4"
REMOTE_DIR="$5"
REMOTE_COMPOSER="$6"

echo "$SSH_KEY > var/.ssh"

rsync -arvz -e "ssh -i var/.ssh -p $SSH_PORT" --exclude ".*" --exclude "var" --exclude "vendor" --progress --delete ./ "$SSH_USER@$SERVER:$REMOTE_DIR"

ssh -i var/.ssh -p "$SSH_PORT" "$SSH_USER@$SERVER" "cd $REMOTE_DIR && $REMOTE_COMPOSER install"

rm var/.ssh
