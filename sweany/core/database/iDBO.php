<?phpnamespace Sweany;interface iDBO{	// used to check if the DataBase	const _implemented = true;	public function escape($string, $quote);	/**
	 *	Prepares and escapes a statement
	 *
	 *	@param	mixed[]	$statement
	 *
	 *		example:
	 *		Array (
	 *			[0]	=>	'`id` = :id AND `username` LIKE %:name%',
	 *			[1]	=>	Array (
	 *				':id' 	=> 5,
	 *				':name'	=> 'unsage string %<>#@$'
	 *			),
	 *		);
	 *
	 *	@return	string	escape safe string
	 */
	public function prepare($statement);	/* ******************************************** GENERIC SELECT ******************************************** */	/**	 *	Raw select function (optional with callback)	 *	 *	Use with caution and escape the query before you go	 *	 *	@param	string		$query	 *	@param	function	$callback = function ($row, &$data){}	 *	@param	string		$return	(object|array) if no callback is given, how do you want to retrieve the results?	 *	@return	mixed[]		$data	 */	public function select($query,  $callback = null, $return = 'object');	/* **************************************************** FETCH **************************************************** */	/**	 *	Fetch a specific field by WHERE condition	 *	 *	@param	string		$table		Table to work on	 *	@param	string		$field_name	Name of the field	 *	@param	mixed[]		$condition	Escapable condition	 *		Array (	 *			[0]	=>	'`id` = :foo AND `username` LIKE %:bar%',	 *			[1]	=>	Array (	 *				':foo' 	=> $id,	 *				':bar'	=> $name	 *			),	 *		);	 *	@return	mixed		Value of the field (or null if empty)	 */	public function fetchField($table, $field_name, $condition);	/**	 *	Fetch a specific field of a row (by id)	 *	 *	@param	string		$table		Table to work on	 *	@param	string		$field_name	Name of the field	 *	@param	integer		$id			Id of the row	 *	@return	mixed		Value of the field (or null if empty)	 */	public function fetchRowField($table, $field_name, $id);	/* **************************************************** COUNT **************************************************** */	/**	 *	Count Row(s) by WHERE condition	 *	 *	@param	string		$table		Table to work on	 *	@param	mixed[]		$condition	Escapable condition	 *		Array (	 *			[0]	=>	'`id` = :foo AND `username` LIKE %:bar%',	 *			[1]	=>	Array (	 *				':foo' 	=> $id,	 *				':bar'	=> $name	 *			),	 *		);	 *	@return	integer		Number of rows	 */	public function count($table, $condition);	/**	 *	Count Row(s) by Distinct field and WHERE condition	 *	 *	@param	string		$table		Table to work on	 *	@param	string		$field		Field to apply DISTINCT() on	 *	@param	mixed[]		$condition	Escapable condition	 *		Array (	 *			[0]	=>	'`id` = :foo AND `username` LIKE %:bar%',	 *			[1]	=>	Array (	 *				':foo' 	=> $id,	 *				':bar'	=> $name	 *			),	 *		);	 *	@return	integer		Number of rows	 */	public function countDistinct($table, $field, $condition);	/**	 *	Check if Row (by id) exists	 *	 *	@param	string		$table		Table to work on	 *	@param	integer		$id			Id of the row	 *	@return	boolean		yes|no	 */	public function rowExists($table, $id);	/* **************************************************** ADD **************************************************** */	/**	 *	Insert	 *	 *	@param	string			$table				Table to work on	 *	@param	mixed[]			$fields				Array of name-value pairs of fields to update	 *	@param	boolean			$ret_ins_id			Return last insert id?	 *	@return	boolean|integer	success|insert id	 */	public function insert($table, $fields, $ret_ins_id);	/* **************************************************** UPDATE **************************************************** */	/**	 *	Update Row(s) by WHERE condition	 *	 *	@param	string		$table		Table to work on	 *	@param	mixed[]		$fields		Array of name-value pairs of fields to update	 *	@param	mixed[]		$condition	Escapable condition	 *		Array (	 *			[0]	=>	'`id` = :foo AND `username` LIKE %:bar%',	 *			[1]	=>	Array (	 *				':foo' 	=> $id,	 *				':bar'	=> $name	 *			),	 *		);	 *	@return	boolean		success	 */	public function update($table, $fields, $condition);	/**	 *	Update Row by Id	 *	 *	@param	string		$table		Table to work on	 *	@param	intege		$id			Id of the row	 *	@param	mixed[]		$fields		Array of name-value pairs of fields to update	 *	@return	boolean		success	 */	public function updateRow($table, $fields, $id);	/**	 *	Increment fields(s) and update other fields (such as modified)	 *	 *	@param	string		$table	 *	@param	string[]	$incFields	Array of field names to increment	 *	@param	mixed[]		$updFields	Array of name-value pair of fields to update	 *	@param	mixed[]		$condition	Escapable condition	 *		Array (	 *			[0]	=>	'`id` = :foo AND `username` LIKE %:bar%',	 *			[1]	=>	Array (	 *				':foo' 	=> $id,	 *				':bar'	=> $name	 *			),	 *		);	 *	@return	boolean	success	 */	public function incrementFields($table, $incFields, $updFields, $condition);	/* **************************************************** DELETE **************************************************** */	/**	 *	Delete by WHERE condition	 *	 *	@param	string	$table	 *	@param	mixed[]	$condition	escapable condition	 *		Array (	 *			[0]	=>	'`id` = :foo AND `username` LIKE %:bar%',	 *			[1]	=>	Array (	 *				':foo' 	=> $id,	 *				':bar'	=> $name	 *			),	 *		);	 *	@return	boolean	success	 */	public function delete($table, $condition);	/**	 *	Delete row by ID	 *	 *	@param	string	$table	 *	@param	integer	$id	 *	@return	boolean	success	 */	public function deleteRow($table, $id);	/* ******************************************** HELPER ******************************************** */	public function getNowDateTime();	public function getNowTimeStamp();	public function getNowUnixTimeStamp();	public function tableExists($table);	public function getColumnNames($table);	public function getColumnTypes($table);	public function getPrimaryKey($table);	public function getTotalQueryTime();}