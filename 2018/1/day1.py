#!/usr/bin/python

import sys

if len(sys.argv) < 2:
	print "Please choose from part [1] or part [2]"
	exit()


duplicate = False
frequency = 0
history = {}

def iterate():
	global frequency, history, duplicate

	file = open("input.txt")
#	file = open("test.txt")
	for line in file:
		line = line.replace("\n","")
		if line == "":
			continue

		frequency += int(line)

		if frequency in history:
			#We've seen this before!
			duplicate = True
			return frequency

		history[frequency] = True
	return frequency

def part1():
	return iterate()

def part2():
	global duplicate, history
	while True:
		result = iterate()
		if duplicate == True:
			return result

if sys.argv[1] == "1":
	print part1()
elif sys.argv[1] == "2":
	print part2()
elif sys.argv[1] == "both":
	print part1()
	print part2()
else:
	print "What?"
	exit()


