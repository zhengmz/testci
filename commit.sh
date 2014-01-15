#!/bin/sh

echo "Now prepare to push to github ..."
git push origin master

echo ""
echo "Now prepare to update to aws ..."
ssh aws "sh update.sh"

echo ""
echo "Now prepare to update to 2u ..."
ssh 2u "sh update.sh"
