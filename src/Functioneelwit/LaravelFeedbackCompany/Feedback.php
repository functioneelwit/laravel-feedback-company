<?php namespace Functioneelwit\LaravelFeedbackCompany;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
 
class Feedback {
 
    public function send($email){

    	$connector = Config::get('laravel-feedback-company::connector');

    	if(! $connector)
    	{
    		return 'No FeedbackCompany connector set. Please run: php artisan config:publish functioneelwit/laravel-feedback-company';
    	}

    	if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
    	{
    		return 'Not a valid e-mailaddress.';
    	}

    	$url = 'https://connect.feedbackcompany.nl/feedback/?
			action=sendInvitation
			&connector=' . $connector . '
			&user=' . $email . '
			&delay=2
			&remindDelay=4';

		$url = preg_replace("/\s*/m", "", $url);

		return $url;
    }
 
}