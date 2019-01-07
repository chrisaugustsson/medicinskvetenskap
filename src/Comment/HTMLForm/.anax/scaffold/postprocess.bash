#!/usr/bin/env bash
#
# Postprocess scaffold
#

# Include ./functions.bash
source .anax/scaffold/functions.bash

#
# Read values from user input
#
NAMESPACE=$( input "Namespace" "${ANAX_NAMESPACE:-Anax\\\\XXX}" )
CLASS_NAME=$( input "Class name" "ClassName" )

# Update default config file
sedi "s/NAMESPACE/$NAMESPACE/g" CLASS_NAME.php
sedi "s/CLASS_NAME/$CLASS_NAME/g" CLASS_NAME.php
mv CLASS_NAME.php "$CLASS_NAME.php"
