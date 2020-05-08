#!/usr/bin/env bash
set -e

root_dir="$PWD/"

mkdir -p repo-build-dev
echo "{}" > ${root_dir}repo-build-dev/composer.json

module_name="POData"
module_dir="$root_dir"

cd ${root_dir}repo-build-dev/
composer config repositories.ModuleBimLibM2Source${module_name} \
    "{\"type\": \"path\",\"url\": \"$module_dir\",\"options\": {\"symlink\": true}}"

mv "${root_dir}repo-build-dev/composer.json" "${root_dir}repo-build-dev/repositories.json"

