#!/bin/bash


FREQ=0

for i in $(cat input.txt); do
	FREQ=$(echo $FREQ $i | bc)
done

echo $FREQ

