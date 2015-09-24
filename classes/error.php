<?php
	
	class Error {
		const no_translation = 0;
		const db_error = 1;
		const arg_not_valid = 2;
		const ambiguously = 3;
		const not_found = 4;

		public static function IsError($ob) {
			return ($ob === Error::no_translation) || ($ob === Error::db_error) || ($ob === Error::arg_not_valid) ||
			($ob === Error::ambiguously) || ($ob === Error::not_found);
		}
	}
	
?>