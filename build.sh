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

# Checkout SVN repo
mkdir build
svn co http://plugins.svn.wordpress.org/ultimate-tag-cloud-widget/tags build/tags

# Create new tag
mkdir build/tags/$VERSION

# Base files 
cp -Rv dist/* build/tags/$VERSION/

# CSS 
mkdir -v build/tags/$VERSION/css
cp -v css/*.css build/tags/$VERSION/css

# JS
mkdir -v build/tags/$VERSION/js
cp -v js/*.min.js build/tags/$VERSION/js

# Pages
cp -Rv pages build/tags/$VERSION/

# PHP files
cp -v *php build/tags/$VERSION/

# Add and commit
svn add build/tags/$VERSION

cd build/tags
svn ci -m "Tagged version $VERSION"

# Cleanup
cd ../..
rm -rf build

# Git tag it
# git tag -a $VERSION -m "Tagged version $VERSION"

echo "All done! Remember to update stable tag in SVN repo"
