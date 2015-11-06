<?php

	class MyCache {

		private $map = [];

		public function add_key($key, $val) {
			if ($val === NULL) {
				if (isset($this->map[$key])) unset($this->map[$key]);
				return;
			}
			$this->map[$key] = $val;
		}

		public function get_val($key) {
			if (isset($this->map[$key])) return $this->map[$key];
			return NULL;
		}
		
		public function key_exists($key) {
			return isset($this->map[$key]);
		}
	};
	
?>