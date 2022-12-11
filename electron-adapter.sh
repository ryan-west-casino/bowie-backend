#!/bin/bash
BUILD_PATH="/Users/ryan/multipass/bowie/electron_builds/${2}"
mkdir $BUILD_PATH
docker run --rm -v ${BUILD_PATH}:/target/ cf1d00a90776 ${1} /target/ --platform ${3} --portable
