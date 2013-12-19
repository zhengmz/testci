#!/bin/sh

echo "Now prepare to input github user's password..."
git push origin master

echo ""
echo "Now prepare to input aws user's password..."
ssh zhengmz@aws "sh update.sh"
