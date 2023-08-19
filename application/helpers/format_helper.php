<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

function formatBytes($bytes, $precision = 2) { 
  $units = array('KB', 'MB', 'GB', 'TB'); 

  $bytes = max($bytes, 0); 
  $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
  $pow = min($pow, count($units) - 1); 

  return round($bytes, $precision) . ' ' . $units[$pow]; 
} 


function timeago($date) {
  $timestamp = strtotime($date);	
  
  $strTime = array("second", "minute", "hour", "day", "month", "year");
  $length = array("60","60","24","30","12","10");

  $currentTime = time();
  if($currentTime >= $timestamp) {
   $diff     = time()- $timestamp;
   for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
   $diff = $diff / $length[$i];
   }

   $diff = round($diff);
   return $diff . " " . $strTime[$i] . "(s) ago ";
  }
}

function date_id($tanggal, $cetak_hari = false) {

	$hari = array ( 1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);
			
			
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split 	  = explode('-', $tanggal);
	$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	
	if ($cetak_hari) {
		$num = date('N', strtotime($tanggal));
		return $hari[$num] . ', ' . $tgl_indo;
	}
	return $tgl_indo;
}

function date_en($tanggal, $cetak_hari = false) {

	$hari = array ( 1 =>    'Monday',
				'Tuesday',
				'Wednesday',
				'Thursday',
				'Friday',
				'Saturday',
				'Sunday'
			);
			
	$bulan = array (1 =>   'January',
				'February',
				'March',
				'April',
				'May',
				'June',
				'July',
				'August',
				'September',
				'October',
				'November',
				'December'
			);
	$split 	  = explode('-', $tanggal);
	$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	
	if ($cetak_hari) {
		$num = date('N', strtotime($tanggal));
		return $hari[$num] . ', ' . $tgl_indo;
	}
	return $tgl_indo;
}

function date_en_sort($tanggal, $cetak_hari = false) {

	$hari = array ( 1 =>    'Monday',
				'Tuesday',
				'Wednesday',
				'Thursday',
				'Friday',
				'Saturday',
				'Sunday'
			);
			
	$bulan = array (1 =>   'Jan',
				'Feb',
				'March',
				'Apr',
				'May',
				'June',
				'July',
				'August',
				'Sept',
				'Oct',
				'Nov',
				'Dec'
			);
	$split 	  = explode('-', $tanggal);
	$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	
	if ($cetak_hari) {
		$num = date('N', strtotime($tanggal));
		return $hari[$num] . ', ' . $tgl_indo;
	}
	return $tgl_indo;
}

function encrypt($plaintext){

	$method = 'aes-256-cbc';
	$key = config_item('encryption_key');
	$password = substr(hash('sha256', $key, true), 0, 32);
	$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
	$encrypted = base64_encode(openssl_encrypt($plaintext, $method, $password, OPENSSL_RAW_DATA, $iv));

	return $encrypted;
}

function decrypt($encrypted){

	$method = 'aes-256-cbc';
	$key = config_item('encryption_key');
	$password = substr(hash('sha256', $key, true), 0, 32);
	$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

	$decrypted = openssl_decrypt(base64_decode($encrypted), $method, $password, OPENSSL_RAW_DATA, $iv);

	return $decrypted;

}

// Function to generate OTP
function generateNumericOTP($n) {
        
	// Take a generator string which consist of
	// all numeric digits
	$generator = "1357902468";

	// Iterate for n-times and pick a single character
	// from generator and append it to $result
	
	// Login for generating a random character from generator
	//     ---generate a random number
	//     ---take modulus of same with length of generator (say i)
	//     ---append the character at place (i) from generator to result

	$result = "";

	for ($i = 1; $i <= $n; $i++) {
		$result .= substr($generator, (rand()%(strlen($generator))), 1);
	}

	// Return result
	return $result;
}
?>