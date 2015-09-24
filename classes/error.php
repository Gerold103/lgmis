<?php
	
	class Error {
		const no_translation = 0;
		const db_error = 1;

		public static function IsError($ob) {
			return ($ob === Error::no_translation) || ($ob === Error::db_error);
		}
	}
	
?>