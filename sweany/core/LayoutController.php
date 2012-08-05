<?php/** * Abstract parent for layout controller * * * Sweany: MVC-like PHP Framework with blocks and tables (entities) * Copyright 2011-2012, Patu * * Licensed under The MIT License * Redistributions of files must retain the above copyright notice. * * @copyright	Copyright 2011-2012, Patu * @link		none yet * @package		sweany.sys * @author		Patu * @license		MIT License (http://www.opensource.org/licenses/mit-license.php) * @version		0.7 2012-07-29 13:25 * */abstract class LayoutController extends BaseController{	private $blocks	= array();	// pre-rendered blocks (if any)	public function __construct()	{		parent::__construct();		$this->language	= new \Core\Init\CoreLanguage($this->plugin, 'layout', get_class($this));		// default Layout		$this->view($GLOBALS['DEFAULT_LAYOUT']);	}	/* ***************************************************** SETTER ***************************************************** */	protected function attachBlock($varName, $blockPluginName, $blockControllerName, $blockMethodName, $blockMethodParams = array())	{		if ( \Core\Init\CoreSettings::$showFwErrors > 2 || \Core\Init\CoreSettings::$logFwErrors > 2 )			$start = getmicrotime();		$output = Render::block($blockPluginName, $blockControllerName, $blockMethodName, $blockMethodParams);		if ( \Core\Init\CoreSettings::$showFwErrors > 2 || \Core\Init\CoreSettings::$logFwErrors > 2 )			SysLog::i('Attach Block', '(Done) | [to Layout] from: '.$blockPluginName.'\\'.$blockControllerName.'::'.($blockControllerName).'->'.$blockMethodName, null, $start);		// 08) store block into array		$this->blocks[$varName]	= $output['content'];		return $output['return'];	}	/* ***************************************************** GETTER ***************************************************** */	public function getBlocks()	{		return $this->blocks;	}}