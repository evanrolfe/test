#!/bin/bash
FILES=/home/evan/www/yacht/public/uploads/*
for f in $FILES
do
  echo ${f##*/};
done
