#!/usr/bin/python

import sys

if len(sys.argv) < 2:
	print "Please choose from part [1] or part [2]"
	exit()

def part1():
	frequency = 0

	file = open("input.txt")
	for line in file:
		line = line.replace("\n","")
		if line == "":
			continue

		if line[0] == "+":
			frequency = frequency + int(line.replace("+",""))
		elif line[0] == "-":
			frequency = frequency - int(line.replace("-",""))
		else:
			exit("ERROR: Check input text")
	return frequency


def part2():
	print "Part 2 - Work in progress"


if sys.argv[1] == "1":
	print part1()
elif sys.argv[1] == "2":
	part2()
else:
	print "What?"
	exit()


