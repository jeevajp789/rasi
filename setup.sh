#!/bin/bash
 
# Dependency check
DEPENDENCIES='apache2'
DEPENDENCIES+=' mysql-server'
DEPENDENCIES+=' php5'

# TODO: Can add an additional check to filter out and install only missing packages
echo "Installing dependencies..."
sudo apt-get --force-yes --yes install $DEPENDENCIES

# Create a symlink in /var/www/ to the current directory
CWD=$(pwd)
DEPLOY_DIR='/var/www/rasi'
echo "Linking $CWD to /var/www/rasi"

if [[ -f $DEPLOY_DIR ]]
then
  rm -f $DEPLOY_DIR
fi

sudo ln -vs $CWD $DEPLOY_DIR

# Setup the base db from the db dump
# TODO: Should avoid using 'root'...
echo ""
echo "Creating database..."
echo "Enter MySQL root password..."
echo "CREATE DATABASE rasi" | mysql -u root -p

ret=$?
if [[ $ret -ne 0 ]]
then
  echo "Couldn't create database... Check if a database by name 'rasi' already exists"
fi

echo ""
echo "Setting up the database..."
echo "Enter MySQL root password..."
mysql -u root rasi -p < ${CWD}/rasi-rating.sql

ret=$?
if [[ $ret -ne 0 ]]
then
  echo "Something went wrong. Please check the error message."
  exit 1
else
  echo "Completed setup. Go to http://localhost/rasi"
  exit 0
fi

#TODO: Setup the dbConfig.php script with the db password.
