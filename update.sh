#!/bin/bash

# Define the root of the GIT repository.
cd ${0%/*}
ROOT=$(pwd)
cd $ROOT

cd $ROOT/web

drush cc drush

drush cim
