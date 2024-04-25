#!/bin/bash

if [ $# -ne 1 ]; then
    echo "Usage: bash $0 <filename>"
    exit 1
fi

filename=$1
word_freq=$(tr -cs '[:alpha:]' '\n' < $filename | sort | uniq -c | sort -nr | head -n 10)
echo "-------------------------------------------"
echo "Top 10 most frequent words:"
echo "$word_freq"
echo "-------------------------------------------"
punc_freq=$(tr -cs '[:punct:]' '\n' < $filename | sort | uniq -c | sort -nr | head -n 10)
echo "Top 10 most frequent punctuation:"
echo "$punc_freq"
