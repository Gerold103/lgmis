<?php
	
	class Error {
		const no_translation = 0;
		const db_error = 1;
		const arg_not_valid = 2;
		const ambiguously = 3;
		const not_found = 4;
		const error = 5;

		public static $type = 'error';
		public $mesg = '';
		public $id = self::error;

		function Error($mesg = '', $id = self::error) {
			$this->mesg = $mesg;
			$this->id = $id;
		}

		public static function ToString($err) {
			if (is_a($err, 'Error')) $err = $err->id;
			switch ($err) {
				case self::no_translation: return Language::Word('no translation');
				case self::db_error: return Language::Word('internal database error');
				case self::arg_not_valid: return Language::Word('argument not valid');
				case self::ambiguously: return Language::Word('ambigiously');
				case self::not_found: return Language::Word('not found');
				case self::error: return Language::Word('error');
			}
		}

		public static function IsError($ob) {
			return ($ob === Error::no_translation) || ($ob === Error::db_error) || ($ob === Error::arg_not_valid) ||
			($ob === Error::ambiguously) || ($ob === Error::not_found) || (is_a($ob, 'Error'));
		}
	}
	
?>