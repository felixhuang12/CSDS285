#!/bin/bash

if [ $# -ne 1 ]; then
    echo "Usage: bash $0 <filename>"
    exit 1
fi

filename=$1

while IFS="" read -r p || [ -n "$p" ]
do
  printf '%s\n' "$p"
done < $filename