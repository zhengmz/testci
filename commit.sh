#!/bin/sh

echo "Now input github user's password..."
git push origin master

echo ""
echo "Now input aws user's password..."
ssh zhengmz@aws "sh update.sh"
