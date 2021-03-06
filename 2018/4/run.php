#!/usr/bin/php
<?php
ini_set('memory_limit','-1');

class GuardList {
	private $guard = array();
	private $laziest = NULL;
	private $sleepiest = NULL;

	public function parse($log) {
		$whos_on = NULL;

		foreach ($log->get() as $k => $entry) {
			$action = strtok($entry['event'],' ');
			if ($action == "Guard") {
				preg_match ('/Guard #([0-9]+) .*/', $entry['event'], $m);
				$whos_on = $m[1];
				if (!array_key_exists($whos_on, $this->guard)) {
					$this->guard[$whos_on] = $this->init($whos_on);
				}
			} elseif ($action == "falls") {
				$sleep_start = array('min' => substr($entry['time'], -2), 'unix' => $entry['unix']);
			} elseif ($action == "wakes") {
				$sleep_end = array('min' => substr($entry['time'], -2), 'unix' => $entry['unix']);
				$duration = (($sleep_end['unix'] - $sleep_start['unix'])/60);

				$this->guard[$whos_on]['total'] += $duration;

				$minute = ltrim($sleep_start['min'],"0");
				if (strlen($minute) < 1) { $minute = 0; }

				for ($i = 0; $i < $duration; $i++) {
					$this->guard[$whos_on][$minute]++;
					$minute++;
					if ($minute >= 60) { $minute = 0; }
				}
			}
		}

		foreach ($this->guard as $id => $guard) {
			$guard['most'] = $this->most_minutes($guard['id']);

			if ($guard['total'] > $this->laziest['total']) {
				$this->laziest = $guard;
			}
			if ($guard['most']['tot'] > $this->sleepiest['most']['tot']) {
				$this->sleepiest = $guard;
			}
		}
	}
	
	public function laziest() {
		return $this->laziest;
	}

	public function sleepiest() {
		return $this->sleepiest;
	}
	
	private function most_minutes($guard) {
		$most = array('min' => 0, 'tot' => 0);
		for ($i = 0; $i < 60; $i++) {
			if ($this->guard[$guard][$i] > $most['tot']) {
				$most = array('min' => $i, 'tot' => $this->guard[$guard][$i]);
			}
		}
		return $most;
	}
	
	private function init($guard) {
		$array = array();
		$array['id'] = $guard;
		$array['total'] = 0;
		$array['most'] = array('min' => 0, 'tot' => 0);
		for ($i = 0; $i < 60; $i++) {
			$array[$i] = 0;
		}
		return $array;
	}
}

class EventLog {
	private $log = array();

	public function __construct() {
		foreach (file("input.txt",FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $entry) {
			preg_match("/^\[(.*)\] (.*)$/",$entry,$matches);
			$this->log[] = array('time' => $matches[1],
					'unix' => strtotime($matches[1]),
					'event' => $matches[2]
					);
		}
		if (empty($this->log)) {
			// Make Shane's Benchmark happy when
			// no one elses input is available
			echo "0\n";
			echo "0\n";
			die();
		}
	}

	public function sort() {
		usort($this->log, array($this, 'compare_dates'));
	}
	
	public function get() {
		return $this->log;
	}
	
	private function compare_dates($a, $b) {
		$val1 = $a['unix'];
		$val2 = $b['unix'];
		return $val1 - $val2;	
	}


}

$log = new EventLog();
$log->sort();

$guards = new GuardList();
$guards->parse($log);

$lazy = $guards->laziest();
echo ($lazy['id'] * $lazy['most']['min']);
echo "\n";

$sleepy = $guards->sleepiest();
echo ($sleepy['id'] * $sleepy['most']['min']);
echo "\n";
