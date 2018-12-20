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
CLASSNAME=$( input "Class name" "ClassName" )
# cLASSNAME=${CLASSNAME,} # Need bash 4, fails on Mac
cLASSNAME=$( echo $CLASSNAME | cut -c1 | tr '[:upper:]' '[:lower:]' )$( echo $CLASSNAME | cut -c2- )

# Model
file="MODEL.php"
sedi "s/NAMESPACE/$NAMESPACE/g" "$file"
sedi "s/CLASSNAME/$CLASSNAME/g" "$file"
mv "$file" "$CLASSNAME.php"

# Controller
file="CONTROLLER.php"
sedi "s/NAMESPACE/$NAMESPACE/g" "$file"
sedi "s/CLASSNAME/$CLASSNAME/g" "$file"
sedi "s/cLASSNAME/$cLASSNAME/g" "$file"
mv "$file" "${CLASSNAME}Controller.php"

# CreateForm
file="HTMLForm/CreateForm.php"
sedi "s/NAMESPACE/$NAMESPACE/g" "$file"
sedi "s/CLASSNAME/$CLASSNAME/g" "$file"
sedi "s/cLASSNAME/$cLASSNAME/g" "$file"

# UpdateForm
file="HTMLForm/UpdateForm.php"
sedi "s/NAMESPACE/$NAMESPACE/g" "$file"
sedi "s/CLASSNAME/$CLASSNAME/g" "$file"
sedi "s/cLASSNAME/$cLASSNAME/g" "$file"

# DeleteForm
file="HTMLForm/DeleteForm.php"
sedi "s/NAMESPACE/$NAMESPACE/g" "$file"
sedi "s/CLASSNAME/$CLASSNAME/g" "$file"
sedi "s/cLASSNAME/$cLASSNAME/g" "$file"

# Routes for the controller
path="extra/config/router"
file="100_CONTROLLER.php"
sedi "s/NAMESPACE/$NAMESPACE/g" "$path/$file"
sedi "s/cLASSNAME/$cLASSNAME/g" "$path/$file"
sedi "s/CLASSNAME/$CLASSNAME/g" "$path/$file"
mv "$path/$file" "$path/100_${cLASSNAME}Controller.php"

# Prepare database table MySQL
path="extra/sql/ddl"
file="mysql.sql"
sedi "s/CLASSNAME/$CLASSNAME/g" "$path/$file"
mv "$path/$file" "$path/${cLASSNAME}_$file"

# Prepare database table SQLite
path="extra/sql/ddl"
file="sqlite.sql"
sedi "s/CLASSNAME/$CLASSNAME/g" "$path/$file"
mv "$path/$file" "$path/${cLASSNAME}_$file"

# view for create
file="extra/view/CLASSNAME/crud/create.php"
sedi "s/cLASSNAME/$cLASSNAME/g" "$file"

# view for update
file="extra/view/CLASSNAME/crud/update.php"
sedi "s/cLASSNAME/$cLASSNAME/g" "$file"

# view for delete
file="extra/view/CLASSNAME/crud/delete.php"
sedi "s/cLASSNAME/$cLASSNAME/g" "$file"

# view for view-all
file="extra/view/CLASSNAME/crud/view-all.php"
sedi "s/cLASSNAME/$cLASSNAME/g" "$file"

# Prepare view directory
path="extra/view"
file="CLASSNAME"
install -d "$path/${cLASSNAME}/crud/"
rsync -a "$path/$file/" "$path/${cLASSNAME}/"
rm -rf "${path:?}/$file"
