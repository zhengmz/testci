#!/bin/sh

echo "Now prepare to push to github ..."
git push origin master

echo ""
echo "Now prepare to update to aws ..."
ssh zhengmz@aws "sh update.sh"
