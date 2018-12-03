#!/bin/bash

YEAR="${1}"
DAY="${2}"

cd /code/${YEAR}/${DAY}/

if [ -e "run.php" ]; then
#	php run.php 1
#	php run.php 2
	php run.php both
elif [ -e "day${DAY}.py" ]; then
#	python day${DAY}.py 1
#	python day${DAY}.py 2
	python day${DAY}.py both
fi;
