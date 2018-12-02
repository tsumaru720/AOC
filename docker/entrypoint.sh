#!/bin/bash

YEAR="${1}"
DAY="${2}"

if ! [[ "${YEAR}" =~ ^[0-9]+$ ]]; then
	echo 'Invalid Year: '${YEAR};
	exit 1;
fi;

if ! [[ "${DAY}" =~ ^[0-9]+$ ]]; then
	echo 'Invalid Day: '${DAY};
	exit 1;
fi;

if [ ! -e "/code/${YEAR}/${DAY}/" ]; then
	echo 'Unknown Year/Day: '${YEAR}'/'${DAY};
	exit 1;
fi;

time /runBoth.sh ${YEAR} ${DAY}
