#!/bin/bash

echo "Running git pre-commit hook ..."
./.git/hooks/pre-commit &> /dev/null

if [ ! $? -eq 0 ]; then
	echo "Refusing to build without succeeding git pre-commit hooks";
	exit 1
fi

echo -n "Version to build: "
read VERSION

echo "Ok, building version $VERSION ... "

TMP=`date | md5`
mkdir -v /tmp/$TMP

# Base files 
cp -Rv dist/* /tmp/$TMP

# CSS 
mkdir -v /tmp/$TMP/css
cp -v css/*.css /tmp/$TMP/css

# JS
mkdir -v /tmp/$TMP/js
cp -v js/*.min.js /tmp/$TMP/js

# Pages
cp -Rv pages /tmp/$TMP

# PHP files
cp -v *php /tmp/$TMP

# Tag it 
svn copy /tmp/$TMP http://plugins.svn.wordpress.org/ultimate-tag-cloud-widget/tags/$VERSION -m "Tagged version $VERSION"

# Remove it 
rm -rfv /tmp/$TMP

# Git tag it 
git tag -a $VERSION -m "Tagged version $VERSION"

echo "All done! Remember to update stable tag in SVN repo"
