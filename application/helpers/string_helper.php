<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


// --------------------------------------------------------------------

/**
 * Evaluates a strings PHP code. Used especially for outputing FUEL page data
 *
 * @param 	string 	string to evaluate
 * @param 	mixed 	variables to pass to the string
 * @return	string
 */
if (!function_exists('eval_string'))
{
	function eval_string($str, $vars = array())
	{
		$CI =& get_instance();
		extract($CI->load->get_vars()); // extract cached variables
		extract($vars);

		// fix XML
		$str = str_replace('<?xml', '<@xml', $str);

		ob_start();
		if ((bool) @ini_get('short_open_tag') === FALSE AND $CI->config->item('rewrite_short_tags') == TRUE)
		{
			$str = eval('?>'.preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?=', '<?php ?>'.$str.'<?php ')));
		}
		$str = ob_get_clean();
		
		// change XML back
		$str = str_replace('<@xml', '<?xml', $str);
		return $str;
	}
}

// --------------------------------------------------------------------

/**
 * Add an s to the end of s string based on the number 
 *
 * @param 	int 	number to compare against to determine if it needs to be plural
 * @param 	string 	string to evaluate
 * @param 	string 	plural value to add
 * @return	string
 */
//
if (!function_exists('pluralize'))
{ 
	function pluralize($num, $str = '', $plural = 's')
	{
		if (is_array($num))
		{
			$num = count($num);
		}
		
		if ($num != 1)
		{
			$str .= $plural;
		}
		return $str;
	}
}

// --------------------------------------------------------------------

/**
 * Strips extra whitespace from a string
 *
 * @param 	string
 * @return	string
 */
if (!function_exists('strip_whitespace'))
{
	function strip_whitespace($str)
	{
		return trim(preg_replace('/\s\s+|\n/m', '', $str));
	}
}

// --------------------------------------------------------------------

/**
 * Trims extra whitespace from the end and beginning of a string on multiple lines
 *
 * @param 	string
 * @return	string
 */
if (!function_exists('trim_multiline'))
{
	function trim_multiline($str)
	{
		return trim(implode("\n", array_map('trim', explode("\n", $str))));
	}
}

// --------------------------------------------------------------------

/**
 * Converts words to title case and allows for exceptions
 *
 * @param 	string 	string to evaluate
 * @param 	mixed 	variables to pass to the string
 * @return	string
 */
if (!function_exists('smart_ucwords'))
{
	function smart_ucwords($str, $exceptions = array('of', 'the'))
	{
		$out = "";
		$i = 0;
		foreach (explode(" ", $str) as $word)
		{
			$out .= (!in_array($word, $exceptions) OR $i == 0) ? strtoupper($word[0]) . substr($word, 1) . " " : $word . " ";
			$i++;
		}
		return rtrim($out);
	}
}

// --------------------------------------------------------------------

/**
 * Removes "Gremlin" characters 
 *
 * (hidden control characters that the remove_invisible_characters function misses)
 *
 * @param 	string 	string to evaluate
 * @param 	string 	the value used to replace a gremlin
 * @return	string
 */
if (!function_exists('zap_gremlins'))
{
	function zap_gremlins($str, $replace = '')
	{
		// there is a hidden bullet looking thingy that photoshop likes to include in it's text'
		// the remove_invisible_characters doesn't seem to remove this
		$str = preg_replace('/[^\x0A\x0D\x20-\x7E]/', $replace, $str);
		return $str;
	}
}

// --------------------------------------------------------------------

/**
 * Removes javascript from a string
 *
 * @param 	string 	string to remove javascript
 * @return	string
 */
if (!function_exists('strip_javascript'))
{
	function strip_javascript($str)
	{
		$str = preg_replace('#<script[^>]*>.*?</script>#is', '', $str);
		return $str;
	}
}

// --------------------------------------------------------------------

/**
 * Safely converts a string's entities without encoding HTML tags and quotes
 *
 * @param 	string 	string to evaluate
 * @param 	boolean determines whether to encode the ampersand or not
 * @return	string
 */
if (!function_exists('safe_htmlentities'))
{
	function safe_htmlentities($str, $protect_amp = TRUE)
	{
		// convert all hex single quotes to numeric ... 
		// this was due to an issue we saw with htmlentities still encoding it's ampersand again'... 
		// but was inconsistent across different environments and versions... not sure the issue
		// may need to look into other hex characters
		$str = str_replace('&#x27;', '&#39;', $str);
		
		// setup temp markers for existing encoded tag brackets 
		$find = array('&lt;','&gt;');
		$replace = array('__TEMP_LT__','__TEMP_GT__');
		$str = str_replace($find,$replace, $str);
		
		// encode just &
		if ($protect_amp)
		{
			$str = preg_replace('/&(?![a-z#]+;)/i', '__TEMP_AMP__', $str);
		}

		// safely translate now
		if (version_compare(PHP_VERSION, '5.2.3', '>='))
		{
			//$str = htmlspecialchars($str, ENT_NOQUOTES, 'UTF-8', FALSE);
			$str = htmlentities($str, ENT_NOQUOTES, config_item('charset'), FALSE);
		}
		else
		{
			$str = preg_replace('/&(?!(?:#\d++|[a-z]++);)/ui', '&amp;', $str);
			$str = str_replace(array('<', '>'), array('&lt;', '&gt;'), $str);
		}
		
		// translate everything back
		$str = str_replace($find, array('<','>'), $str);
		$str = str_replace($replace, $find, $str);
		if ($protect_amp)
		{
			$str = str_replace('__TEMP_AMP__', '&', $str);
		}
		return $str;
	}
}


// --------------------------------------------------------------------

/**
 * Convert PHP syntax to templating syntax
 *
 * @param 	string 	string to evaluate
 * @return	string
 */
function php_to_template_syntax($str, $engine = NULL)
{
	$CI =& get_instance();
	if (empty($engine))
	{
		$engine = $CI->fuel->config('parser_engine');
	}
	return $CI->fuel->parser->set_engine($engine)->php_to_syntax($str);
}

// --------------------------------------------------------------------
/**
 * Convert string to  templating syntax
 *
 * @param 	string 	string to evaluate
 * @param 	array 	variables to parse with string
 * @param 	string	the templating engine to use
 * @param 	array 	an array of configuration variables like compile_dir, delimiters, allowed_functions, refs and data
 * @return	string
 */
function parse_template_syntax($str, $vars = array())
{
	CI()->load->library('parser');
	CI()->parser->set_delimiters('{','}');
	return CI()->parser->parse_string($str, $vars, TRUE);	
}


function url_slug($str, $options = array()) {
	// Make sure string is in UTF-8 and strip invalid UTF-8 characters
	$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
	
	$defaults = array(
		'delimiter' => '-',
		'limit' => null,
		'lowercase' => true,
		'replacements' => array(),
		'transliterate' => false,
	);
	
	// Merge options
	$options = array_merge($defaults, $options);
	
	$char_map = array(
		// Latin
		'??' => 'A', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'AE', '??' => 'C', 
		'??' => 'E', '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'I', '??' => 'I', '??' => 'I', '??' => 'I', 
		'??' => 'D', '??' => 'N', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'O', 
		'??' => 'O', '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'Y', '??' => 'TH', 
		'??' => 'ss', 
		'??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'ae', '??' => 'c', 
		'??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', 
		'??' => 'd', '??' => 'n', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', 
		'??' => 'o', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'y', '??' => 'th', 
		'??' => 'y',

		// Latin symbols
		'??' => '(c)',

		// Greek
		'??' => 'A', '??' => 'B', '??' => 'G', '??' => 'D', '??' => 'E', '??' => 'Z', '??' => 'H', '??' => '8',
		'??' => 'I', '??' => 'K', '??' => 'L', '??' => 'M', '??' => 'N', '??' => '3', '??' => 'O', '??' => 'P',
		'??' => 'R', '??' => 'S', '??' => 'T', '??' => 'Y', '??' => 'F', '??' => 'X', '??' => 'PS', '??' => 'W',
		'??' => 'A', '??' => 'E', '??' => 'I', '??' => 'O', '??' => 'Y', '??' => 'H', '??' => 'W', '??' => 'I',
		'??' => 'Y',
		'??' => 'a', '??' => 'b', '??' => 'g', '??' => 'd', '??' => 'e', '??' => 'z', '??' => 'h', '??' => '8',
		'??' => 'i', '??' => 'k', '??' => 'l', '??' => 'm', '??' => 'n', '??' => '3', '??' => 'o', '??' => 'p',
		'??' => 'r', '??' => 's', '??' => 't', '??' => 'y', '??' => 'f', '??' => 'x', '??' => 'ps', '??' => 'w',
		'??' => 'a', '??' => 'e', '??' => 'i', '??' => 'o', '??' => 'y', '??' => 'h', '??' => 'w', '??' => 's',
		'??' => 'i', '??' => 'y', '??' => 'y', '??' => 'i',

		// Turkish
		'??' => 'S', '??' => 'I', '??' => 'C', '??' => 'U', '??' => 'O', '??' => 'G',
		'??' => 's', '??' => 'i', '??' => 'c', '??' => 'u', '??' => 'o', '??' => 'g', 

		// Russian
		'??' => 'A', '??' => 'B', '??' => 'V', '??' => 'G', '??' => 'D', '??' => 'E', '??' => 'Yo', '??' => 'Zh',
		'??' => 'Z', '??' => 'I', '??' => 'J', '??' => 'K', '??' => 'L', '??' => 'M', '??' => 'N', '??' => 'O',
		'??' => 'P', '??' => 'R', '??' => 'S', '??' => 'T', '??' => 'U', '??' => 'F', '??' => 'H', '??' => 'C',
		'??' => 'Ch', '??' => 'Sh', '??' => 'Sh', '??' => '', '??' => 'Y', '??' => '', '??' => 'E', '??' => 'Yu',
		'??' => 'Ya',
		'??' => 'a', '??' => 'b', '??' => 'v', '??' => 'g', '??' => 'd', '??' => 'e', '??' => 'yo', '??' => 'zh',
		'??' => 'z', '??' => 'i', '??' => 'j', '??' => 'k', '??' => 'l', '??' => 'm', '??' => 'n', '??' => 'o',
		'??' => 'p', '??' => 'r', '??' => 's', '??' => 't', '??' => 'u', '??' => 'f', '??' => 'h', '??' => 'c',
		'??' => 'ch', '??' => 'sh', '??' => 'sh', '??' => '', '??' => 'y', '??' => '', '??' => 'e', '??' => 'yu',
		'??' => 'ya',

		// Ukrainian
		'??' => 'Ye', '??' => 'I', '??' => 'Yi', '??' => 'G',
		'??' => 'ye', '??' => 'i', '??' => 'yi', '??' => 'g',

		// Czech
		'??' => 'C', '??' => 'D', '??' => 'E', '??' => 'N', '??' => 'R', '??' => 'S', '??' => 'T', '??' => 'U', 
		'??' => 'Z', 
		'??' => 'c', '??' => 'd', '??' => 'e', '??' => 'n', '??' => 'r', '??' => 's', '??' => 't', '??' => 'u',
		'??' => 'z', 

		// Polish
		'??' => 'A', '??' => 'C', '??' => 'e', '??' => 'L', '??' => 'N', '??' => 'o', '??' => 'S', '??' => 'Z', 
		'??' => 'Z', 
		'??' => 'a', '??' => 'c', '??' => 'e', '??' => 'l', '??' => 'n', '??' => 'o', '??' => 's', '??' => 'z',
		'??' => 'z',

		// Latvian
		'??' => 'A', '??' => 'C', '??' => 'E', '??' => 'G', '??' => 'i', '??' => 'k', '??' => 'L', '??' => 'N', 
		'??' => 'S', '??' => 'u', '??' => 'Z',
		'??' => 'a', '??' => 'c', '??' => 'e', '??' => 'g', '??' => 'i', '??' => 'k', '??' => 'l', '??' => 'n',
		'??' => 's', '??' => 'u', '??' => 'z'
	);
	
	// Make custom replacements
	$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
	
	// Transliterate characters to ASCII
	if ($options['transliterate']) {
		$str = str_replace(array_keys($char_map), $char_map, $str);
	}
	
	// Replace non-alphanumeric characters with our delimiter
	$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
	
	// Remove duplicate delimiters
	$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
	
	// Truncate slug to max. characters
	$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
	
	// Remove delimiter from ends
	$str = trim($str, $options['delimiter']);
	
	return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}

function check_date($string){

	if (preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $string, $matches)) {
	    if (!checkdate($matches[2], $matches[1], $matches[3])) {
	        $error = true;
	    }else{
	    	$error=false;
	    }
	} else {
	    $error = true;
	}

	return $error;
}

function check_format($string,$format){
	if (!preg_match($format, $string, $matches)){
		return false;
	}else{
		return true;
	}
}

function check_time_format($date, $format = 'h:i:s'){

    $dateObj = DateTime::createFromFormat($format, $date);
    return $dateObj && $dateObj->format($format) == $date;
}

 function isTime($time)
{
return preg_match("#([0-1]{1}[0-9]{1}|[2]{1}[0-3]{1}):[0-5]{1}[0-9]{1}#", $time);
}

function columnLetter($c){

    $c = intval($c);
    //if ($c<= 0) return '';

    $letter = '';
             
    while($c != 0){
       $p = ($c - 1) % 26;
       $c = intval(($c - $p) / 26);
       $letter = chr(65 + $p) . $letter;
    }
    
    return $letter;
        
}


function odd_even($number){
	if ($number % 2 == 0){
		return true;//even
	}else{
		return false;//odd
	}
}

function check_your_datetime($x) {
    return (date('d-M-Y', strtotime($x)) == $x);
}

/* End of file MY_string_helper.php */