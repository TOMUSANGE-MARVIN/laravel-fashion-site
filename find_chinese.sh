#!/bin/bash
find . -type f -exec grep -l "[\x{4e00}-\x{9fff}]" {} \; | grep -v "/vendor/" | grep -v "/node_modules/"
