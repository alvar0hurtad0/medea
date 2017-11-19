#!/bin/bash

# Define the root of the GIT repository.
cd ${0%/*}
ROOT=$(pwd)
cd $ROOT

if [ ! -f "$ROOT"/config.sh ]; then
  echo
  echo -e "${BGRED}                                                                 ${RESTORE}"
  echo -e "${BGLRED}  ERROR: No configuration file found!                            ${RESTORE}"
  echo -e "${BGRED}  > Check if the ${BGLRED}config.sh${BGRED} file exists in the same               ${RESTORE}"
  echo -e "${BGRED}    directory of the ${BGLRED}install${BGRED} script.                             ${RESTORE}"
  echo -e "${BGRED}  > If not create one by creating a copy of ${BGLRED}default.config.sh${BGRED}.   ${RESTORE}"
  echo -e "${BGRED}                                                                 ${RESTORE}"
  echo
  exit 1
fi

# Include the configuration file.
source "$ROOT"/config.sh

composer install

ln -sf $ROOT/$PROFILE_NAME $ROOT/web/profiles/

cd $ROOT/web

drush cc drush

drush site-install $PROFILE_NAME --db-url="mysql://$MYSQL_USERNAME:$MYSQL_PASSWORD@$MYSQL_HOSTNAME/$MYSQL_DB_NAME"  --account-name=$ADMIN_USERNAME --account-pass=$ADMIN_PASSWORD --yes
drush cset system.site uuid $SITE_UUID --yes
drush cim --yes

# Add default content.
drush en $PROFILE_NAME_default_content --yes
drush migrate-import --group=default_content

drush uli --uri=$BASE_DOMAIN_URL