#!/bin/bash
# This script should be run in the background via the command: bash ./get_top.sh &
top -b -d 300 > ./datasets/top.txt