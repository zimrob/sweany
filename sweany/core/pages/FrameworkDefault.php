<?php/** * Internal Controller holding 404, robots and note/inform actions * * * Sweany: MVC-like PHP Framework with blocks and tables (entities) * Copyright 2011-2012, Patu * * Licensed under The MIT License * Redistributions of files must retain the above copyright notice. * * @copyright	Copyright 2011-2012, Patu * @link		none yet * @package		sweany.default * @author		Patu * @license		MIT License (http://www.opensource.org/licenses/mit-license.php) * @version		0.7 2012-07-29 13:25 * */class FrameworkDefault extends PageController{	public function url_not_found($request = null)	{		switch ( $_SERVER['REQUEST_URI'] )		{			case '/robots.txt':			{				$this->render = false;				$handle = @fopen(ROOT.DS.'robots.txt', 'r');				$output	= '';				if ($handle)				{					while ( ($output .= fgets($handle, 4096)) !== false );				}				fclose($handle);				return $output;			}			default:			{				// VIEW VARIABLES				$this->language->setCore('notFound');				$this->set('language', $this->language);				$this->set('url', $request);				// VIEW OPTIONS				$this->view('url_not_found.tpl.php');			}		}	}	public function info_message()	{		if ( !Session::exists('info_message_data') )		{			$this->redirectHome();			return;		}		$info	= Session::get('info_message_data');		$title	= $info['title'];		$body	= $info['body'];		$url	= $info['url'];		$delay	= $info['delay'];		$this->language->setCore('redirect');		$this->set('language', $this->language);		$this->set('title', $title);		$this->set('body', $body);		$this->set('url', $url);		$this->set('delay', $delay);		$this->view('info_message.tpl.php');		if (\Core\Init\CoreSettings::$showFwErrors)		{			echo '<font color="red">Delayed Redirect Call: </font><a href="'.$url.'">'.$url.'</a> in '.$delay.' seconds [automatic redirect disabled during debug mode]';		}		else		{			HtmlTemplate::setRedirect($url, $delay);		}		Session::del('info_message_data');	}	public function change_settings($key = null, $value = null)	{	}}