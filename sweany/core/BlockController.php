<?php/** * Abstract parent for block controller * * * Sweany: MVC-like PHP Framework with blocks and tables (entities) * Copyright 2011-2012, Patu * * Licensed under The MIT License * Redistributions of files must retain the above copyright notice. * * @copyright	Copyright 2011-2012, Patu * @link		none yet * @package		sweany.sys * @author		Patu * @license		MIT License (http://www.opensource.org/licenses/mit-license.php) * @version		0.7 2012-07-29 13:25 * */abstract Class BlockController extends BaseController{	/* ***************************************************** VARIABLES ***************************************************** */	/**	 *  This is an overriden variable from the	 *  BaseController and its only function is	 *  to tell the loadModel function, that it should	 *  directly load a block model instead of a normal model	 */	protected $block	= true;	private $blockName	= null;	//public $render = false;	/* ***************************************************** CONSTRUCTOR ***************************************************** */	function __construct()	{		parent::__construct();		$this->blockName	= get_called_class();		$this->language	= new \Core\Init\CoreLanguage($this->plugin, 'block', get_class($this));	}	function __destruct()	{		parent::__destruct();	}}