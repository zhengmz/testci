#!/bin/sh

git push origin master
ssh zhengmz@aws "sh update.sh"
