<?php
	
	class Error {
		const no_translation = 1;
		const db_error = 2;
		const arg_not_valid = 3;
		const ambiguously = 4;
		const not_found = 5;
		const error = 6;

		public static $type = 'error';
		public $mesg = '';
		public $id = self::error;

		function Error($mesg = '', $id = self::error) {
			$this->mesg = $mesg;
			$this->id = $id;
		}

		public static function IsType($error, $type) {
			if (is_a($error, 'Error')) {
				return ($error->id === $type);
			} else {
				return $error === $type;
			}
		}

		public static function ToString($err) {
			if (is_a($err, 'Error')) {
				return Error::ToString($err->id).': '.$err->mesg;
			}
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