<?php
if (! function_exists ( 'config_path' )) {
	
	/**
	 * Get the configuration path.
	 *
	 * @param string $path        	
	 * @return string
	 */
	function config_path($path = '') {
		return app ()->basePath () . '/config' . ($path ? '/' . $path : $path);
	}
}

if (! function_exists ( 'bcrypt' )) {
	
	/**
	 * Hash the given value.
	 *
	 * @param string $value        	
	 * @param array $options        	
	 * @return string
	 */
	function bcrypt($value, $options = []) {
		return app ( 'hash' )->make ( $value, $options );
	}
}

/*
 * |--------------------------------------------------------------------------
 * | IP address of the current user
 * |--------------------------------------------------------------------------
 * |
 */
if (! function_exists ( 'getUserIp' )) {
	function getUserIp($integer_format = true) {
		$ip_address = Request::ip ();
		return $integer_format ? ip2long ( $ip_address ) : $ip_address;
	}
}

/*
 * |--------------------------------------------------------------------------
 * | User agent (web browser) being used by the current user
 * |--------------------------------------------------------------------------
 * |
 */
if (! function_exists ( 'getUserAgent' )) {
	function getUserAgent() {
		return (! isset ( $_SERVER ['HTTP_USER_AGENT'] )) ? FALSE : $_SERVER ['HTTP_USER_AGENT'];
	}
}

/**
 * Generate a globally unique identifier
 */
if (! function_exists ( 'generateGUID' )) {
	function generateGUID($opt = false) { // Set to true/false as your default way to do this.
		if (function_exists ( 'com_create_guid' )) {
			if ($opt) {
				return com_create_guid ();
			} else {
				return trim ( com_create_guid (), '{}' );
			}
		} else {
			mt_srand ( ( double ) microtime () * 10000 ); // optional for php 4.2.0 and up.
			$charid = strtoupper ( md5 ( uniqid ( rand (), true ) ) );
			$hyphen = chr ( 45 ); // "-"
			$left_curly = $opt ? chr ( 123 ) : ""; // "{"
			$right_curly = $opt ? chr ( 125 ) : ""; // "}"
			$uuid = $left_curly . substr ( $charid, 0, 8 ) . $hyphen . substr ( $charid, 8, 4 ) . $hyphen . substr ( $charid, 12, 4 ) . $hyphen . substr ( $charid, 16, 4 ) . $hyphen . substr ( $charid, 20, 12 ) . $right_curly;
			return $uuid;
		}
	}
}

/**
 * Dump helper.
 * Functions to dump variables to the screen, in a nicley
 * formatted manner.
 *
 * @author Joost van Veen
 * @version 1.0
 */
if (! function_exists ( 'dump' )) {
	function dump($var, $label = 'Dump', $echo = TRUE) {
		// Store dump in variable
		ob_start ();
		var_dump ( $var );
		$output = ob_get_clean ();
		
		// Add formatting
		$output = preg_replace ( "/\]\=\>\n(\s+)/m", "] => ", $output );
		$output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';
		
		// Output
		if ($echo == TRUE) {
			echo $output;
		} else {
			return $output;
		}
	}
}

if (! function_exists ( 'dump_exit' )) {
	function dump_exit($var, $label = 'Dump', $echo = TRUE) {
		dump ( $var, $label, $echo );
		exit ();
	}
}

/**
 * Get source id from device type android|ios
 *
 * @param string $deviceOs        	
 * @return mixed
 */
if (! function_exists ( 'getChannelId' )) {
	function getChannelId($deviceOs) {
		$channel ['web'] = 1;
		$channel ['android'] = 2;
		$channel ['ios'] = 3;
		
		return $channel [strtolower ( $deviceOs )];
	}
}

/**
 * Get the random generated integer for OTP.
 *
 * @return integer
 */
if (! function_exists ( 'generateOtp' )) {
	function generateOtp() {
		return rand ( 1000, 9999 );
	}
}
/**
 * sendSms
 */
if (! function_exists ( 'sendSms' )) {
	function sendSms($mobileNumber, $textMsg = '') {
		$senderID = env ( 'SMS_SENDER_ID' );
		$user = env ( 'SMS_USER_NAME' ) . ':' . env ( 'SMS_PASSWORD' );
		
		// open connection
		$ch = curl_init ();
		
		// set the url, POST data
		curl_setopt ( $ch, CURLOPT_URL, env ( 'SMS_BASE_URL' ) );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, "user=$user&senderID=$senderID&receipientno=$mobileNumber&msgtxt=$textMsg" );
		
		// execute post
		$buffer = curl_exec ( $ch );
		$httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		
		// Close connection
		curl_close ( $ch );
	}
}

/**
 * Calculate OTP expiration time in minutes
 *
 * @param timestamp $otpSentAt        	
 * @return int
 */
if (! function_exists ( 'calculateOtpSessTime' )) {
	function calculateOtpSessTime($otpSentAt) {
		$current = Carbon::now ();
		return $current->diffInMinutes ( new Carbon ( $otpSentAt ) );
	}
}

/**
 * Generate random MAC address
 */
if (! function_exists ( 'generateMacAddress' )) {
	function generateMacAddress($doHash = false) {
		if ($doHash) {
			return implode ( ':', str_split ( str_pad ( base_convert ( mt_rand ( 0, 0xffffff ), 10, 16 ) . base_convert ( mt_rand ( 0, 0xffffff ), 10, 16 ), 12 ), 2 ) );
		}
		return implode ( ':', str_split ( substr ( md5 ( mt_rand () ), 0, 12 ), 2 ) );
	}
}
/*
 * |--------------------------------------------------------------------------
 * | Modify .env file helper function
 * |--------------------------------------------------------------------------
 * |
 * | Source: http://laravelsnippets.com/snippets/env-file-modify-helper
 *
 * | You can easily modify .env file by putting key and value into modifyEnv helper function
 * | // you can update any value you want. Just type $key which exists and wanted value to replace.
 * | $data = [
 * | 'APP_ENV' => 'your_environment',
 * | 'APP_KEY' => 'your_key',
 * | 'APP_DEBUG' => 'trueOrFalse',
 * | 'DB_DATABASE' => 'test',
 * | 'DB_USERNAME' => 'test',
 * 'DB_PASSWORD' => 'test',
 * 'DB_HOST' => 'localhost',
 * 'CACHE_DRIVER' => 'file',
 * 'SESSION_DRIVER' => 'file',
 *
 * // Custom
 *
 * 'CUSTOM' => 'value',
 * ];
 *
 * // or
 * $data = [
 * 'DB_HOST' => '127.0.0.1',
 * ];
 *
 * | modifyEnv($data);
 * |
 */

if (! function_exists ( 'modifyEnv' )) {
	function modifyEnv(array $data) {
		$envPath = base_path () . DIRECTORY_SEPARATOR . '.env';
		
		$contentArray = collect ( file ( $envPath, FILE_IGNORE_NEW_LINES ) );
		
		$contentArray->transform ( function ($item) use ($data) {
			foreach ( $data as $key => $value ) {
				if (str_contains ( $item, $key )) {
					return $key . '=' . $value;
				}
			}
			
			return $item;
		} );
		
		$content = implode ( $contentArray->toArray (), "\n" );
		// file_put_contents($envPath, $content);
		
		\File::put ( $envPath, $content );
	}
}

if (! function_exists ( 'changeLocale' )) {
	function changeLocale($locale) {
		app ( 'translator' )->setLocale ( $locale );
	}
}

if (! function_exists ( 'getTitleViaLink' )) {
	function getTitleViaLink($url) {
		$pageTitle = '';
		$str = file_get_contents ( $url );
		if (strlen ( $str ) > 0) {
			$str = trim ( preg_replace ( '/\s+/', ' ', $str ) ); // supports line breaks inside <title>
			preg_match ( "/\<title\>(.*)\<\/title\>/i", $str, $title ); // ignore case
			$pageTitle = $title [1];
		}
		return $pageTitle;
	}
}

/**
 * Generate unique file name
 */
if (! function_exists ( 'generateFileName' )) {
	
	/**
	 * Return the custom name for uploaded file
	 *
	 * @param
	 *        	$id
	 * @param string $moduleName        	
	 * @return string
	 */
	function generateFileName($fileExtension) {
		return time () . "-" . uniqid () . '.' . $fileExtension;
	}
}

if (! function_exists ( 'classActivePath' )) {
	function classActivePath($path) {
		return Request::is ( $path ) ? ' class="active"' : '';
	}
}
if (!function_exists('classActiveTopic')) {
	function classActiveTopic($topicId)
	{
		return $topicId == 1 ? 'active ' : '';
	}
}
/**
 * Render HTML helper block
 */
if (! function_exists ( 'classHelperBlock' )) {
	function classHelperBlock($errors, $name) {
		if ($errors->has ( $name )) {
			return '<span class="help-block">' . $errors->first ( $name ) . '</span>';
		}
	}
}
/**
 * Render HTML 'has-error' class
 */
if (! function_exists ( 'classHasError' )) {
	function classHasError($errors, $name, $class = 'has-error') {
		if ($errors->has ( $name )) {
			return $class;
		}
		return '';
	}
}
/**
 * Render HTML 'has-error' class
 */
if (! function_exists ( 'classControlLabel' )) {
	function classControlLabel($errors, $name, $class = 'has-error') {
		if ($errors->has ( $name )) {
			return [
					'class' => "control-label"
			];
		}
		return [ ];
	}
}