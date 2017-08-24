<?php

function curl_get_contents($url)
{ 
	$curlHandle = curl_init(); 
	curl_setopt( $curlHandle , CURLOPT_URL, $url ); 
	curl_setopt( $curlHandle , CURLOPT_RETURNTRANSFER, 1 ); 
	curl_setopt( $curlHandle , CURLOPT_TIMEOUT, 20 ); 
	curl_setopt( $curlHandle , CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt( $curlHandle , CURLOPT_SSL_VERIFYHOST, FALSE);
	$curl_errno = curl_errno( $curlHandle ); 
	$result = curl_exec( $curlHandle ); 
	curl_close( $curlHandle ); 
	return $result; 
}

function g_pull()
{
	$txt = curl_get_contents('https://raw.githubusercontent.com/gfwlist/gfwlist/master/gfwlist.txt');
	file_put_contents('gfwlist/gfwlist.txt', $txt);
}

function g_2pac()
{
	$list = base64_decode(file_get_contents('gfwlist/gfwlist.txt'));
	$list = explode("\n", $list);
	$count = 0;
	$p_array = array();
	foreach ($list as $index => $rule) {
		if(empty($rule))
		{
			continue;
		}
		else if (substr($rule, 0, 1) == '!' || substr($rule, 0, 1) == '[')
		{
			continue;
		}
		$p_array[$count] = $rule;
		$count += 1;
	}
	$p_content = '';
	$count = 1;
	foreach ($p_array as $rule) {
		if($count === count($p_array))
		{
			$p_content .= '  "' . $rule . '"' . "\r\n";
		}
		else
		{
			$p_content .= '  "' . $rule . '",' . "\r\n";
		}
		$count += 1;
	}
	$before_pac = 'var proxy = "__PROXY__";';
	$after_pac = file_get_contents('part/after_pac.txt');
	$pac = $before_pac . "\r\n" . 'var rules = [' . "\r\n" . $p_content . '];' . "\r\n" . $after_pac;
	file_put_contents('gfwlist_p_e.pac', $pac);
}

function g_comb()
{
	$list = base64_decode(file_get_contents('gfwlist/gfwlist.txt'));
	$list = explode("\n", $list);
	$count = 0;
	$p_array = array();
	foreach ($list as $index => $rule)
	{
		if(empty($rule))
		{
			continue;
		}
		else if (substr($rule, 0, 1) == '!' || substr($rule, 0, 1) == '[')
		{
			continue;
		}
		$p_array[$count] = $rule;
		$count += 1;
	}
	// unshift
	$unshift = json_decode(file_get_contents('custom.json'),true);
	foreach ($unshift as $unshift_rule)
	{
		array_unshift($p_array, $unshift_rule);
	}
	$p_content = '';
	$count = 1;
	foreach ($p_array as $rule)
	{
		if($count === count($p_array))
		{
			$p_content .= '  "' . $rule . '"' . "\r\n";
		}
		else
		{
			$p_content .= '  "' . $rule . '",' . "\r\n";
		}
		$count += 1;
	}
	$before_pac = 'var proxy = "__PROXY__";';
	$after_pac = file_get_contents('part/after_pac.txt');
	$pac = $before_pac . "\r\n" . 'var rules = [' . "\r\n" . $p_content . '];' . "\r\n" . $after_pac;
	file_put_contents('gfwlist_p.pac', $pac);
}