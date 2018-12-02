#!/bin/bash

YEAR="${1}"
DAY="${2}"

cd /code/${YEAR}/${DAY}/

if [ -e "run.php" ]; then
	php run.php 1
	php run.php 2
elif [ -e "day${DAY}.py" ]; then
	pypy day${DAY}.py 1
	pypy day${DAY}.py 2
fi;
