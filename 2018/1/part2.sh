#!/bin/bash

FREQ=0

if [ -f /run/shm/scratch ]; then
	rm -Rf /run/shm/scratch
fi
touch /run/shm/scratch

X=0
while [ true ]; do
	X=$(echo $X + 1 | bc)
	echo "Iteration $X"
	for i in $(cat input.txt); do

	        FREQ=$(echo $FREQ $i | bc)
		CHECK=$(grep -E "^$FREQ\$" /run/shm/scratch | wc -l)

		if [ "$CHECK" == "1" ]; then
			#Found
			echo $FREQ
			exit
		fi
	        echo $FREQ >> /run/shm/scratch
	done
done
