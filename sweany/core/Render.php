<?php/** * Renderer * * * Sweany: MVC-like PHP Framework with blocks and tables (entities) * Copyright 2011-2012, Patu * * Licensed under The MIT License * Redistributions of files must retain the above copyright notice. * * @copyright	Copyright 2011-2012, Patu * @link		none yet * @package		sweany.sys * @author		Patu * @license		MIT License (http://www.opensource.org/licenses/mit-license.php) * @version		0.7 2012-07-29 13:25 * */class Render{	/**	 *	 * Creates a renderable element from a given block	 * and returns the return code with the element	 * @param String $controllerName	 * @param String $methodName	 * @param Array $params	 */	public static function block($pluginName, $controllerName, $methodName, $params)	{		$ob_callback = (\Core\Init\CoreSettings::$showPhpErrors) ? 'ob_error_handler' : 'ob_gzhandler';		// 01) Load in instantiate block		$block = Loader::loadBlock($controllerName, $pluginName);		if ( !method_exists(get_class($block), $methodName) )		{			SysLog::e('Render Block', 'Does not exist in '.get_class($block).'->'.$controllerName.'('.implode(',', $params).')', debug_backtrace());			SysLog::show();			exit();		}		// 02) set language to correct xml section		//     so that the block can use it without having		//     to specify it itself.		$block->language->set($methodName);		// 03) execute the block		/**		 * @Deprecated: too slow		 *		if ( ($ret = call_user_func_array(array($block, $methodName), $params)) === false )
		{
			SysLog::e('Attach Block', '[Call] '.get_class($block).'->'.$methodName.'('.implode(',', $params).') returns FALSE', debug_backtrace());
			SysLog::show();
			exit();
		}		* This way is around twice as fast:		*		*/		$paramSize = count($params);		switch ( $paramSize )		{			case 0:  $ret = $block->{$methodName}();break;			case 1:  $ret = $block->{$methodName}($params[0]);break;			case 2:  $ret = $block->{$methodName}($params[0], $params[1]);break;			case 3:  $ret = $block->{$methodName}($params[0], $params[1], $params[2]);break;			case 4:  $ret = $block->{$methodName}($params[0], $params[1], $params[2], $params[3]);break;			case 5:  $ret = $block->{$methodName}($params[0], $params[1], $params[2], $params[3], $params[4]);break;			case 6:  $ret = $block->{$methodName}($params[0], $params[1], $params[2], $params[3], $params[4], $params[5]);break;			case 7:  $ret = $block->{$methodName}($params[0], $params[1], $params[2], $params[3], $params[4], $params[5], $params[6]);break;			case 8:  $ret = $block->{$methodName}($params[0], $params[1], $params[2], $params[3], $params[4], $params[5], $params[6], $params[7]);break;			case 9:  $ret = $block->{$methodName}($params[0], $params[1], $params[2], $params[3], $params[4], $params[5], $params[6], $params[7], $params[8]);break;			default: $ret = call_user_func_array(array($block, $methodName), $params); break;		}		if ( $ret === false )
		{
			SysLog::e('Render Block', '[Call] '.get_class($block).'->'.$methodName.'('.implode(',', $params).') returns FALSE', debug_backtrace());
			SysLog::show();
			exit();		}		/**		 * This is the important part to determine whether the block itself will		 * hold a non renderable result, such as an ajax request.		 *		 * If so, we only need the return value here and break.		 * We also need to make sure, that we have to break the whole procedure of redering layouts, view		 * And other blocks. As This will be the only Pageoutput serving at the page controller that has included this block		 * TODO: break all actions in index.php, Render.php		 */		if ( !$block->render )		{			return array('return' => $ret, 'render' => false, 'content' => null);		}		// 04) set view variables		foreach ($bVars	= $block->getVars() as $name => $value)		{			$$name = $value;		}		// 05) get View		$view		= $block->getView();		$view_path	= strlen($pluginName) ? USR_PLUGINS_PATH.DS.$pluginName.DS.'blocks'.DS.'view'.DS.$block->getView() : USR_BLOCKS_PATH.DS.$controllerName.DS.'view'.DS.$block->getView();		// If the block is a form page and the form has been		// submitted, then the block does not necessarily need		// to load a view, but just return its state,		// so we only set a warning here and don't exit the script		if (!is_file($view_path))		{			SysLog::e('Render Block', 'Block View: '.$view_path. ' does not exist');			SysLog::show();			exit();		}		else		{			// 06) RENDER			// Turn on output buffering			// TODO: handle debug mode, so that errors will be displayed!!			if ( !ob_start($ob_callback) )			{				ob_start();			}			@include($view_path);			$content = ob_get_contents();			// 07) Clean (erase) the output buffer and turn off output buffering			ob_end_clean();		}		// 09 Restore Header		//		// In case the block Controller did set a custom header e.g,		// header("Content-Type: image/png"); then it will still be active here		// so we have to restore it		// TODO:		//header('Content-type: text/html; charset=UTF-8');		// 10 Remove setted variables		//		//foreach ($bVars as $name => $value)		//{		//	unset($$name);		//}		return array('return' => $ret, 'render' => true, 'content' => $content);	}	/**	 *	 * Renders a PageController View and returns	 * the rendered element	 * @param &Class $controller	 */	public static function view(&$controller)	{		$ob_callback	= (\Core\Init\CoreSettings::$showPhpErrors) ? 'ob_error_handler' : 'ob_gzhandler';		$class			= get_class($controller);	// the name of the controller class		$vars			= $controller->getVars();		$blocks			= $controller->getBlocks();		$plugin			= $controller->isPlugin();		// TODO: standard view name is hardcoded!!!!		$view			= ($plugin) ? USR_PLUGINS_PATH.DS.$class.DS.'pages'.DS.'view'.DS.$controller->getView() : PAGES_VIEW_PATH.DS.$class.DS.$controller->getView();		SysLog::i('Render View', 'Using: '.$view);		// ------- Check if view, layout and skeleton do exist		if (!is_file($view))		{			SysLog::e('Render View', 'view '.$view. ' does not exist');			SysLog::show();			exit;		}		// ------- Set Variables (defined by controller)		foreach ($vars as $name => $var)		{			$$name = $var;		}		// ------- Set Blocks (defined by controller)		foreach ($blocks as $name => $block)		{			$$name = $block;		}		// -------- RENDER		if ( !ob_start($ob_callback) )		{			ob_start();		}		@include($view);		$content = ob_get_contents();		ob_end_clean();		return $content;	}	public static function layout(&$controller, $view)	{		$ob_callback	= (\Core\Init\CoreSettings::$showPhpErrors) ? 'ob_error_handler' : 'ob_gzhandler';		$layout			= $controller->getLayout();		// Only execute if an actual class/method has been specified		// Otherwise just take the default layout		if ( isset($layout[0]) && isset($layout[1]) )		{			$className		= $layout[0];			$methodName		= $layout[1];			$classPath		= USR_LAYOUTS_PATH.DS.$className.'.php';			if ( is_file($classPath) )			{				include($classPath);				if ( method_exists($className, $methodName) )				{					// create instance					$layoutCtl = new $className;					// set language					$layoutCtl->language->set($methodName);					// execute method					$layoutCtl->$methodName();					$vars		= $layoutCtl->getVars();					$blocks		= $layoutCtl->getBlocks();					// ------- Set Variables (defined by controller)					foreach ($vars as $name => $var)					{						$$name = $var;					}					// ------- Set Blocks (defined by controller)					foreach ($blocks as $name => $block)					{						$$name = $block;					}					$layoutView	= USR_LAYOUTS_PATH.DS.'view'.DS.$layoutCtl->getView();				}				else				{					SysLog::e('Render Layout', 'Class or Method does not exist. <'.$className.'> -> <'.$methodName.'>');					SysLog::show();					exit;				}			}			else			{				SysLog::e('Render Layout', 'Class File does not exist: '.$classPath);				SysLog::show();				exit;			}		}		// Use default layout		else		{			SysLog::i('Render Layout', 'Not set. Using default');			$layoutView	= USR_LAYOUTS_PATH.DS.'view'.DS.$GLOBALS['DEFAULT_LAYOUT'];		}		// also set the vars from the view		$viewVars	= $controller->getVars();		//		$render_element = $view;		SysLog::i('Render Layout', 'Using Layout View: '.$layoutView);		// ------- Check if view, layout and skeleton do exist		if (!is_file($layoutView))		{			SysLog::e('Render Layout', 'Layout View: '.$layoutView. ' does not exist');			SysLog::show();			exit;		}		// ------- Set Variables (defined by controller)		foreach ($viewVars as $name => $var)		{			$$name = $var;		}		// -------- RENDER		if ( !ob_start($ob_callback) )		{			ob_start();		}		include($layoutView);		$content = ob_get_contents();		ob_end_clean();		return $content;	}}