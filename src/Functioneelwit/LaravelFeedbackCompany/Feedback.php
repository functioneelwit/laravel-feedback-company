<?php namespace Functioneelwit\LaravelFeedbackCompany;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
 
class Feedback {
 
    public function send($email){

    	if(! Config::has('laravel-feedback-company::connector'))
    	{
    		return 'Can\'t find config file. Please run: php artisan config:publish functioneelwit/laravel-feedback-company';
    	} 

    	$connector = Config::get('laravel-feedback-company::connector');
    	$uri = Config::get('laravel-feedback-company::uri');

    	if(Config::has('laravel-feedback-company::delay'))
    	{
    		$delay = Config::get('laravel-feedback-company::delay');

    		if(! $delay)
    		{
    			unset($delay);
    		}
    	}

    	if(Config::has('laravel-feedback-company::remindDelay'))
    	{
    		$remindDelay = Config::get('laravel-feedback-company::remindDelay');

    		if(! $remindDelay)
    		{
    			unset($remindDelay);
    		}
    	}
    	
    	// remove spacing, linebreaks & lowercase emailaddress
    	$email = strtolower(preg_replace("/\s*/m", "", $email));

    	if(! $connector)
    	{
    		return 'No connector setting in config.';
    	}

    	if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
    	{
    		return 'Not a valid e-mailaddress.';
    	}

    	$url = $uri . '?
			action=sendInvitation
			&connector=' . $connector . '
			&user=' . $email . '
			&Chksum=' . $this->checksum($email);

		if(isset($delay))
		{
			$url .= '&delay=' . $delay;
		}

		if(isset($remindDelay))
		{
			$url .= '&remindDelay=' . $remindDelay;
		}

		$url = preg_replace("/\s*/m", "", $url);

		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_RETURNTRANSFER => 1,
    		CURLOPT_URL => $url
		]);
		
		$result = curl_exec($curl);

		var_dump($result);
		
		curl_close($curl);
		
    }

    private function checksum($string)
    {
    	return array_sum(array_map('ord', str_split($string)));
    }
 
}