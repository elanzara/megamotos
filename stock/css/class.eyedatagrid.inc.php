<?php
/**
 * EyeDataGrid
 * Provides datagrid control features
 *
 * LICENSE: This source file is subject to the BSD license
 * that is available through the world-wide-web at the following URI:
 * http://www.eyesis.ca/license.txt.  If you did not receive a copy of
 * the BSD License and are unable to obtain it through the web, please
 * send a note to mike@eyesis.ca so I can send you a copy immediately.
 *
 * @author     Micheal Frank <mike@eyesis.ca>
 * @copyright  2008 Eyesis
 * @license    http://www.eyesis.ca/license.txt  BSD License
 * @version    v1.1.6 12/3/2008 10:04:44 AM
 * @link       http://www.eyesis.ca/projects/datagrid.html
 */

class EyeDataGrid
{
	private $results_per_page = 10;
	private $column_count = 0; // Num of columns
	private $row_count = 0; // Number of rows
	private $hide_header = false; // Header visibility
	private $hide_footer = false; // Footer visibility
	private $hide_order = false; // Show ordering option
	private $show_checkboxes = false; // Show checkboxes
	private $allow_filters = false; // Allow filters or not
	private $row_select = false; // Enable row selection
	private $create_button = false; // Show create button
	private $reset_button = false; // Show reset grid button
	private $show_row_number = false; // Show row numbers
	private $hide_page_list = false; // Hide page list
	private $page = 1; // Current page
	private $primary = ''; // Tables primary key column
	private $query; // SQL query
	private $hidden = array(); // Hidden columns
	private $header = array(); // Header titles
	private $type = array(); // Column types
	private $controls = array(); // Row controls, std or custom
	private $order = false; // Current order
	private $filter = false; // Current filter
	private $limit = false; // Current limit
	private $_db, $result; // Database related
	private $select_fields = ''; // Field used to select
	private $select_where = ''; // Where clause
	private $select_table = ''; // Table to read
	private $image_path = ''; // Path to images
    private $orderby = ''; //order by para la cosnulta
    private $valoresFiltro = array("","");

	 // Filename of required images
	public $img_edit = 'edit.png';
	public $img_delete = 'delete.png';
	public $img_create = 'create.png';
	public $img_reset = 'reset.png';


	// Configuration constants
	const CUSCTRL_TEXT = 1;
	const CUSCTRL_IMAGE = 2;
	const STDCTRL_EDIT = 3;
	const STDCTRL_DELETE = 4;
	const TYPE_DATE = 1;
	const TYPE_IMAGE = 2;
	const TYPE_ONCLICK = 3;
	const TYPE_ARRAY = 4;
	const TYPE_DOLLAR = 5;
	const TYPE_HREF = 6;
	const TYPE_CHECK = 7;
	const TYPE_PERCENT = 8;
	const TYPE_CUSTOM = 9;
	const TYPE_FUNCTION = 10;
    const TYPE_NUMBER = 11;
	const ORDER_DESC = 'DESC';
	const ORDER_ASC = 'ASC';


	// Default text
	const TXT_RESET = 'Actualizar';//'Reset Table';
	const TXT_NORESULTS = 'No hay datos disponibles.';//'No results found!';

	/**
	* Constructor
	*
	* @param EyeMySQLAdap $_db The Eyesis MySQL Adapter class
	* @param string $image_path The path to datagrid images
	*/
	public function __construct(EyeMySQLAdap $_db, $image_path = '')
	{
		$this->_db = $_db;
        //$_SESSION["FILTROS"] = "";
		if (empty($image_path))
			$this->image_path = 'images/';
		else
			$this->image_path = $image_path;

		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 0; // Page number
		$order = (isset($_GET['order'])) ? $_GET['order'] : ''; // Order clause
		$filter = (isset($_GET['filter'])) ? $_GET['filter'] : ''; // Filter clause
		// Set the limit
		if (empty($page) or $page <= 0)
			$this->setLimit(0, $this->results_per_page);
		else
			$this->page = $page;

		// Set the order
		if ($order)
		{
			list($column, $order) = $this->parseInputCond($order);
			$this->setOrder($column, $order);
		}

		// Set the filter
		if ($filter)
		{
		  $filtros = $this->parseInputCond2($filter);
            /*ASI LEO LOS VALORES DEL ARRAY FILTROS*/
            $count = count($filtros);
            for ($i = 0; $i < $count; $i++) {
                $filtro = $filtros[$i];
//                echo "Filtro $i: ".$filtro."<br>";    
                list($column, $value) = $this->parseInputCond($filtro);
    			$this->setFilter($column, $value);
            }
		}
	}

	private function parseInputCond2($in)
	{
		return explode(';', @ereg_replace("[\'\"\<\>\\]", '%', $in), 20);
	}


    public function setOrderBy ($porder=''){
        $this->orderby = $porder;
    }
	/**
	* Hides page drop down selection and replaces it with text
	*
	* @param $hide Show or hide the page drop down
	*/
	public function hidePageSelectList($hide = true)
	{
		$this->hide_page_list = $hide;
	}

	/**
	 * Allow filters
	 *
	 * @param boolean $allow
	 */
	public function allowFilters($allow = true)
	{
		$this->allow_filters = $allow;
	}

	/**
	 * Hide order functionality
	 *
	 * @param boolean $hide
	 */
	public function hideOrder($hide = true)
	{
		$this->hide_order = $hide;
	}

	/**
	 * Show checkboxes on each row
	 *
	 * @param boolean $show
	 */
	public function showCheckboxes($show = true)
	{
		$this->show_checkboxes = $show;
	}

	/**
	 * Hide header row
	 *
	 * @param boolean $hide
	 */
	public function hideHeader($hide = true)
	{
		$this->hide_header = $hide;
	}

	/**
	 * Hide footer row
	 *
	 * @param boolean $hide
	 */
	public function hideFooter($hide = true)
	{
		$this->hide_footer = $hide;
	}

	/**
	 * Show reset control
	 *
	 * @param string $text Display caption
	 */
	public function showReset($text = self::TXT_RESET)
	{
		$this->reset_button = $text;
	}

	/**
	 * Show row numbers
	 *
	 * @param boolean $show
	 */
	public function showRowNumber($show = true)
	{
		$this->show_row_number = $show;
	}

	/**
	 * Set the SELECT query
	 *
	 * @param string $fields Feilds to fetch from table. * for all columns
	 * @param string $table Table to select from
	 * @param string $primay Optional primary key column
	 * @param string $where Optional where condition
	 */
	public function cleanQuery(){
		$this->primary = "";

		$this->select_fields = "";
		$this->select_table = "";
		$this->select_where = "";
	   
	}
    public function setQuery($fields, $table, $primary = '', $where = '')
	{
		$this->primary = $primary;

		$this->select_fields = $fields;
		$this->select_table = $table;
		$this->select_where = $where;
//        echo "Asi se Llega el  Where1: " . $this->select_where . "<br>";
	}

	/**
	 * Set filter
	 *
	 * @param string $column Column to apply filter clause on
	 * @param string $value Value to compare to
	 */
	private function setFilter($column, $value)
	{
		$this->filter = array('Column' => $column,
							'Value' => $value);
	}

	/**
	 * Set order
	 *
	 * @param string $column Column to apply order clause on
	 * @param string $order Direction, use ORDER_* const
	 */
	private function setOrder($column, $order = self::ORDER_DESC)
	{
		$order = ($order == self::ORDER_DESC)
					? self::ORDER_DESC
					: self::ORDER_ASC;

		$this->order = array('Column' => $column,
							'Order' => $order);
	}

	/**
	* Hides a column
	*
	* @param string $column The column to be hidden
	*/
	public function hideColumn($column)
	{
		$this->hidden[] = $column;
	}

	/**
	* Change column header caption
	*
	* @param string $column The column name
	* @param string $header The new header caption
	*/
	public function setColumnHeader($column, $header)
	{
		$this->header[$column] = $header;
	}

	/**
	* Set a column type
	*
	* @param string $column The column to apply the type to
	* @param integer $type The type of column, use TYPE_* const
	* @param mixed $criteria Specific value to each column type
	* @param mixed $criteria_2 Second specific value to each column type
	*/
	public function setColumnType($column, $type, $criteria = '', $criteria_2 = '')
	{
		$this->type[$column] = array($type, $criteria, $criteria_2);
	}

	/**
	* Sets the maximum amount of rows per page
	*
	* @param integer $num Amount of rows per page
	*/
	public function setResultsPerPage($num)
	{
		$this->results_per_page = (int) $num;
		$this->setLimit(0, (int) $num);
	}

	/**
	* Adds a standard control to a row
	*
	* @param integer $type The type of standard control, use STDCTRL_* const
	* @param string $action The action of the control (onclick code or href link)
	* @param integer $action_type The type of action, use TYPE_ONCLICK or TYPE_HREF
	*/
	public function addStandardControl($type, $action, $action_type = self::TYPE_ONCLICK, $text='', $image_src = '')
	{
		$action = $this->parseLinkAction($action, $action_type);

		switch ($type)
		{
			case self::STDCTRL_EDIT:
				$this->controls[] = '<a ' . $action . '><img src="' . $this->image_path . $this->img_edit . '" alt="Edit" title="Edit" class="tbl-control-image"></a>';
				break;
			case self::STDCTRL_DELETE:
				$this->controls[] = '<a ' . $action . '><img src="' . $this->image_path . $this->img_delete . '" alt="Delete" title="Delete" class="tbl-control-image"></a>';
				break;
			case self::CUSCTRL_IMAGE:
                //$this->controls[] = '<a ' . $action . '><img width="50" height="50" src="' . $image_src . '" alt="' . $text . '" title="' . $text . '" class="tbl-control-image"></a>';
                $this->controls[] = '<a href="' . $image_src . '" class="view" rel="prettyPhoto" title="' . $text . '"><img width="50" height="50" src="' . $image_src . '" alt="' . $text . '" title="' . $text . '" class="tbl-control-image"></a>';
                break;
			default:
				// Invalid standard control
				break;
		}
	}

	/**
	* Adds a custom control to a row
	*
	* @param integer $type The type of custom control, use CUSCTRL_* const
	* @param string $action The action of the control (onclick code or href link)
	* @param integer $action_type The type of action, use TYPE_ONCLICK or TYPE_HREF
	* @param string $text The textual description of the control
	* @param string $image_path The location of the image if type is CUSCTRL_IMAGE
	*/
	public function addCustomControl($type = self::CUSCTRL_TEXT, $action, $action_type = self::TYPE_ONCLICK, $text, $image_src = '')
	{
		$action = $this->parseLinkAction($action, $action_type);

		switch ($type)
		{
			case self::CUSCTRL_IMAGE:
				$this->controls[] = '<a ' . $action . '><img width="50" height="50" src="' . $image_src . '" alt="' . $text . '" title="' . $text . '" class="tbl-control-image"></a>';
				break;
			default: // Default to text
				$this->controls[] = '<a ' . $action . '>' . $text . '</a>';
				break;
		}
	}

	/**
	* Adds a create control above the table
	*
	* @param string $action The action associated to the create (onclick code or href link)
	* @param integer $action_type The type of action, use TYPE_ONCLICK or TYPE_HREF
	* @param string $text The textual description of the create
	*/
	public function showCreateButton($action, $action_type = self::TYPE_ONCLICK, $text = 'New Record')
	{
		$action = $this->parseLinkAction($action, $action_type);

		$this->create_button = array('Action' => $action,
										'Text' => $text);
	}

	/**
	* Adds ability to select a entire row
	*
	* @param string $onclick The JS function to call when a row is clicked
	*/
	public function addRowSelect($onclick)
	{
		$this->row_select = $onclick;
	}

	/**
	* Data sanitization and control for filters and ordering
	*
	* @param string $in The value to be sanitized and parsed
	*/
	private function parseInputCond($in)
	{
		return explode(':', @ereg_replace("[\'\"\<\>\\]", '%', $in), 2);
	}

	/**
	* Replaces our variables place holders with values
	*
	* @param array $row The row associated array
	* @param string $act The string containing place holders to replace
	* @return string
	*/
	private function parseVariables(array $row, $act)
	{
		// The only way we get an array for $act is for parameters from a column type of function
		if (is_array($act))
		{
			// Loop through each passed param and replace variables where necessary
			foreach ($act as $key => $value)
				$act[$key] = $this->parseVariables($row, $value);

			return $act;
		}

		// %_P% is an alias for the primary key, replace it with the primary key
		if ($this->primary)
			$act = str_replace('%_P%', '%' . $this->primary . '%', $act);

		preg_match_all("/%([A-Za-z0-9_ \-]*)%/", $act, $vars);

		foreach($vars[0] as $v)
			$act = str_replace($v, $row[str_replace('%', '', $v)], $act);

		return $act;
	}

	/**
	* Builds a link action
	*
	* @param string $action The action
	* @param integer $action_type The type of actions (onclick code or href link)
	* @return string
	*/
	private function parseLinkAction($action, $action_type)
	{
		if ($action_type == self::TYPE_ONCLICK)
			$action = 'href="javascript:;" onclick="' . $action . '"';
		else
			$action = 'href="' . $action . '"';

		return $action;
	}

	/**
	* Sets the limit by clause
	*
	* @param integer $low The minimum row number
	* @param integer $high The maximum row number
	*/
	private function setLimit($low, $high)
	{
		$this->limit = array('Low' => $low,
							'High' => $high);
	}

	/**
	* Checks to see if this is an ajax table
	*
	* @return boolean
	*/
	public static function isAjaxUsed()
	{
		if (!empty($_GET['useajax']) and $_GET['useajax'] == 'true')
			return true;

		return false;
	}

	/**
	* Creates the table header
	*
	*/
	private function buildHeader()
	{
            // If entire header is hidden, skip all together
            if ($this->hide_header)
		return;
                echo '<thead><tr>';

		// Get field names of result
		$headers = $this->_db->fieldNameArray($this->result);
		$this->column_count = count($headers);

		// Add a blank column if the row number is to be shown
		if ($this->show_row_number)
		{
			$this->column_count++;
			echo '<td class="tbl-header">&nbsp;</td>';
		}
		// Show checkboxes
		if ($this->show_checkboxes)
		{
                    $this->column_count++;
                    echo '<td class="tbl-header tbl-checkall">
                        <input type="checkbox" name="checkall" onclick="tblToggleCheckAll()"></td>';
		}
                $i = 0;
		// Loop through each header and output it
		foreach ($headers as $t)
		{//echo't:'.$t.'</br>';
                    // Skip column if hidden
                    if (in_array($t, $this->hidden))
                    {
                            $this->column_count--;
                            continue;
                    }
                    // Check for header caption overrides
                    if (array_key_exists($t, $this->header))
                            $header = $this->header[$t];
                    else
                            $header = $t;
//echo'header:'.$header;
                    if ($this->hide_order)
                       echo '<td class="tbl-header">' . $header; // Prevent the user from changing order
                    else {
                        if ($this->order and $this->order['Column'] == $t)
                                $order = ($this->order['Order'] == self::ORDER_ASC)
                                                                 ? self::ORDER_DESC
                                                                 : self::ORDER_ASC;
                        else
                            $order = self::ORDER_ASC;
                            echo '<td class="tbl-header"><a href="javascript:;" onclick="tblSetOrder(\'' . $t . '\', \'' . $order . '\')">' . $header . "</a>";

                            // Show the user the order image if set
                            if ($this->order and $this->order['Column'] == $t)
                              echo '&nbsp;<img src="' . $this->image_path . 'sort_' . strtolower($this->order['Order']) . '.gif" class="tbl-order">';
                    }

                    // Add filters if allowed and only if the column type is not "special"
                    if ($this->allow_filters and
                            !in_array($this->type[$t][0], array(
                                                            self::TYPE_ARRAY,
                                                            self::TYPE_IMAGE,
                                                            self::TYPE_FUNCTION,
                                                            self::TYPE_DATE,
                                                            self::TYPE_CHECK,
                                                            self::TYPE_CUSTOM,
                                                            self::TYPE_PERCENT
                                                            )))
                    {
                        if ($this->filter['Column'] == $t and !empty($this->filter['Value']))
                        {
                                $filter_display = 'block';
                                $filter_value = $this->filter['Value'];
                        } else {
                                $filter_display = 'none';
                                $filter_value = '';
                        }
                        //echo '<a href="javascript:;" onclick="tblShowHideFilter(\'' . $t . '\')"><img src="' . $this->image_path . 'filter.gif" class="tbl-filter-image"></a><br><div class="tbl-filter-box" id="filter-' . $t . '" style="display:' . $filter_display . '"><input type="text" size="6" id="filter-value-' . $t . '" value="'.$filter_value.'">&nbsp;<a href="javascript:;" onclick="tblSetFilter(\'' . $t . '\')">filtro</a></div>';
                        //echo '<a href="javascript:;" onclick="tblShowHideFilter(\'' . $t . '\')"><img src="' . $this->image_path . 'filter.gif" class="tbl-filter-image"></a><br><div class="tbl-filter-box" id="filter-' . $t . '" style="display:' . $filter_display . '"><input type="text" size="6" id="filter-value-' . $t . '" value="">&nbsp;<a href="javascript:;" onclick="tblSetFilter(\'' . $t . '\')">filtro</a></div>';
                        $filter_display = "true";
//                      echo '<a href="javascript:;" onclick="tblShowHideFilter(\'' . $t . '\')">
//                        <img src="' . $this->image_path . 'filter.gif" class="tbl-filter-image">
//                      </a><br>
                        echo '<div class="tbl-filter-box" id="filter-' . $t . '" style="display:' . $filter_display . '">
                        <input type="text" size="6" id="filter-value-' . $t . '" value="">&nbsp;                        
                        </div>';
                        //<a href="javascript:;" onclick="tblSetFilter(\'' . $t . '\')" onkeyup="Navegar_prox_item(\'' . $t . '\')"
                        // >filtro</a>
                        $filtros [] =  array( $t );
                    }
                    echo '</td>';
		}//foreach
//        $_SESSION["FILTROS"] = $filtros;
        /*ASI LEO LOS VALORES DEL ARRAY FILTROS*/
//        $count = count($filtros);
//        for ($i = 0; $i < $count; $i++) {
//            $filtro = $filtros[$i];
//            echo "Filtro $i: ".$filtro[0]."<br>";    
//        }
//        $count = count($_SESSION["FILTROS"]);
//        for ($i = 0; $i < $count; $i++) {
//            $filtro = $_SESSION["FILTROS"][$i];
//            echo "Filtro $i: ".$filtro[0]."<br>";    
//        }

                /*FIN - ASI LEO LOS VALORES DEL ARRAY FILTROS*/
		// If we have controls, add a blank column
		if (count($this->controls) > 0)
		{
			$this->column_count++;
			echo '<td class="tbl-header">&nbsp;</td>';
		}
		echo '</tr></thead>';
	}
	/**
	* Creates the table footer
	*
	* @param integer $shown The amounts of rows being shown in the current page
	* @param integer $first The row number of the first row
	* @param integer $last The row number of the last row
	*/
	private function buildFooter($shown, $first = 0, $last = 0)
	{
            // Skip adding the footer if it is hidden
            if ($this->hide_footer)
			return;

            $pages = ceil($this->row_count / $this->results_per_page); // Total number of pages

            echo '<tfoot><tr class="tbl-footer"><td class="tbl-nav" colspan="' . $this->column_count . '">
                    <table width="100%" class="tbl-footer">
                    <tr><td width="33%" class="tbl-found">Encontrados <em>' . $this->row_count . '</em> registros';

            if ($this->row_count > 0)
		echo ', mostrando <em>' . $first . '</em> de <em>' . $last . '</em>';
		echo '</td><td wdith="33%" class="tbl-pages">';

            // Handle results that span multiple pages
            if ($this->row_count > $this->results_per_page)
            {
                if ($this->page > 1)
                    echo '<a href="javascript:;" onclick="tblSetPage(1)"><img src="' . $this->image_path . 'arrow_first.gif" class="tbl-arrows" alt="&lt;&lt;" title="Primera Pagina"></a><a href="javascript:;" onclick="tblSetPage(' . ($this->page - 1) . ')"><img src="' . $this->image_path . 'arrow_left.gif" class="tbl-arrows" alt="&lt;" title="Pagina Anterior"></a>';
                else
                    echo '<img src="' . $this->image_path . 'arrow_first_disabled.gif" class="tbl-arrows" alt="&lt;&lt;" title="Primera Pagina"><img src="' . $this->image_path . 'arrow_left_disabled.gif" class="tbl-arrows" alt="&lt;" title="Pagina Anterior">';

                // Special thanks to ionut for this next few lines
                $startpage = ($this->page > 10)
                                        ? $this->page - 10
                                        : 1;
                $endpage = (($pages - 10) > $this->page)
                                            ? $this->page + 10
                                            : $pages;
                // Only display a portion of the selectable pages
                for ($i = $startpage; $i <= $endpage; $i++)
		{
                    if ($i == $this->page)
                            echo '&nbsp;<span class="page-selected">' . $i . '</span>&nbsp;';
                    else
                            echo '&nbsp;<a href="javascript:;" onclick="tblSetPage(' . $i . ')">' . $i . '</a>&nbsp;';
		}

                if ($this->page < $pages)
                    echo '<a href="javascript:;" onclick="tblSetPage(' . ($this->page + 1) . ')">
                          <img src="' . $this->image_path . 'arrow_right.gif" class="tbl-arrows" alt="&gt;" title="Pagina Siguiente"></a><a href="javascript:;" onclick="tblSetPage(' . $pages . ')"><img src="' . $this->image_path . 'arrow_last.gif" class="tbl-arrows" alt="&gt;&gt;" title="Ultima Pagina"></a>';
                else
                    echo '<img src="' . $this->image_path . 'arrow_right_disabled.gif" class="tbl-arrows" alt="&gt;" title="Pagina Siguiente"><img src="' . $this->image_path . 'arrow_last_disabled.gif" class="tbl-arrows" alt="&gt;&gt;" title="Ultima Pagina">';
		}

		echo '</td><td width="33%" class="tbl-page">';
		// Only show page section if we have more than one page
		if ($pages > 0)
		{
                    echo 'Pagina ';
                    if (!$this->hide_page_list and $pages > 1)
                    {
                        // Create a selectable drop down list for pages
                        echo '<select name="tbl-page" onchange="tblSetPage(this.options[this.selectedIndex].value)">';
                        for ($x = 1; $x <= $pages; $x++)
                        {
                                echo '<option value="' . $x . '"';
                                if ($x == $this->page)
                                        echo ' selected="selected"';
                                echo '>' . $x . '</option>';
                        }
                        echo '</select>';
                    } else
                            echo $this->page; // Just write the page number, nothing to fancy
                            echo ' de ' . $pages;
		}
		echo '</td></tr></table></td></tr></tfoot>';
	}

	/**
	* Builds row controls
	*
	* @param array $row The row associated array
	*/
	private function buildControls(array $row)
	{
			// Add controls as needed
			if (count($this->controls) > 0)
			{
				echo '<td class="tbl-controls">';
				foreach ($this->controls as $ctl)
					echo $this->parseVariables($row, $ctl);
				echo '</td>';
			}
	}

	/**
	* Outputs the datagrid to the screen
	*
	*/

	public function printTableNeu($Pwhere = "")
	{
          // Set the limit
          $this->setLimit(($this->page - 1) * $this->results_per_page, $this->results_per_page);

          // FILTER
          $filter_query = '';
//        echo "Asi se setea Where 2: " . $this->select_where . "<br>";
          if ($this->select_where){
            //echo "Asi llega la printTable: " . $this->select_where . "<br>";
            $filter_query .= "(" . $this->select_where . ")";}
    
            if ($this->allow_filters and $this->filter)
            {
        	$filter = (isset($_GET['filter'])) ? $_GET['filter'] : ''; // Filter clause
                $filtros = $this->parseInputCond2($filter);
                /*ASI LEO LOS VALORES DEL ARRAY FILTROS*/
                $count = count($filtros);
//                echo "Count: ".$count."<br>";
                for ($i = 0; $i < $count; $i++) {
                    $filtro = $filtros[$i];
//                    echo "Filtro query $i: ".$filtro."<br>";
                    list($column, $value) = $this->parseInputCond($filtro);
                    $this->setFilter($column, str_replace(';','',$value));
  //                    echo "Filtro: ".$i." - ".$column." - ".$value."<br>";
                    if ($this->filter['Value']!=''){
                        if (!strstr($this->filter['Value'], '%'))
                                $filter_value = '%' . $this->filter['Value'] . '%';
                        else
                                $filter_value = $this->filter['Value'];

                        if ($this->select_where)
                                $filter_query = $filter_query . " AND ";

                        if ($this->filter['Column'] == "pro_nueva"){/*Neumaticos*/
                             $filter_query .= "(" . "(case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end)" . " LIKE '" . $filter_value . "')";
                        } else if ($this->filter['Column'] == "cantidad_Chacarita"){/*Neumaticos*/
                        $filter_query .= "(" . "(select ifnull(sum(cast(m.cantidad as signed)*(case m.tim_id when 1 then 1 else (-1) end)),0) cantidad_Chacarita
                                                from movimientos_stock m
                                                where m.estado=0
                                                and m.pro_id = p.pro_id
                                                and m.suc_id = 2)" . " LIKE '" . $filter_value . "')";
                        } else if ($this->filter['Column'] == "cantidad_Palermo"){
                        $filter_query .= "(" . "(select ifnull(sum(cast(m.cantidad as signed)*(case m.tim_id when 1 then 1 else (-1) end)),0) cantidad_Palermo
                                                from movimientos_stock m
                                                where m.estado=0
                                                and m.pro_id = p.pro_id
                                                and m.suc_id = 3)" . " LIKE '" . $filter_value . "')";
                        } else if ($this->filter['Column'] == "cantidad_Taller"){
                        $filter_query .= "(" . "(select ifnull(sum(cast(m.cantidad as signed)*(case m.tim_id when 1 then 1 else (-1) end)),0) cantidad_Taller
                                                from movimientos_stock m
                                                where m.estado=0
                                                and m.pro_id = p.pro_id
                                                and m.suc_id = 1)" . " LIKE '" . $filter_value . "')";
                        } else if ($this->filter['Column'] == "cantidad_Deposito"){
                        $filter_query .= "(" . "(select ifnull(sum(cast(m.cantidad as signed)*(case m.tim_id when 1 then 1 else (-1) end)),0) cantidad_Deposito
                                                from movimientos_stock m
                                                where m.estado=0
                                                and m.pro_id = p.pro_id
                                                and m.suc_id = 4)" . " LIKE '" . $filter_value . "')";
                        } else if ($this->filter['Column'] == "3cuotas"){/*Neumaticos*/
                             $filter_query .= "(" . "((COALESCE((select tp.tip_3cuotas from tipo_productos tp where tp.tip_id = p.tip_id),0)*p.pro_precio_costo/100)+p.pro_precio_costo)" . " LIKE '" . $filter_value . "')";
                        } else if ($this->filter['Column'] == "6cuotas"){/*Neumaticos*/
                             $filter_query .= "(" . "((COALESCE((select tp.tip_6cuotas from tipo_productos tp where tp.tip_id = p.tip_id),0)*p.pro_precio_costo/100)+p.pro_precio_costo)" . " LIKE '" . $filter_value . "')";
                        } else if ($this->filter['Column'] == "12cuotas"){/*Neumaticos*/
                             $filter_query .= "(" . "((COALESCE((select tp.tip_12cuotas from tipo_productos tp where tp.tip_id = p.tip_id),0)*p.pro_precio_costo/100)+p.pro_precio_costo)" . " LIKE '" . $filter_value . "')";
                        } else if ($this->filter['Column'] == "sucu"){/*Autos*/
                             $filter_query .= "(" . "(select s.suc_descripcion from sucursales s where s.suc_id = su.suc_id)" . " LIKE '" . $filter_value . "')";
                        } else {
                            if (!strstr($this->filter['Column'], 'select')){/*AGREGADO POR EDU*/
                                $filter_query .= "(`" . $this->filter['Column'] . "` LIKE '" . $filter_value . "')";
                            } else {
                                $filter_query .= "(" . $this->filter['Column'] . " LIKE '" . $filter_value . "')";
                            }
                        }
                    }
                } //for
            }
//    	}	
            if ($filter_query)
            {$filter = 'WHERE ' . $filter_query;
//            echo "Asi se setea filter: " . $filter . "<br>";
            }
            // ORDER
            if ($this->order)
                $order = "ORDER BY `" . $this->order['Column'] . "` " . $this->order['Order'];
             elseif ($this->orderby != '')
                $order = "ORDER BY " . $this->orderby;
             else
                $order = '';
                // LIMIT
                if ($this->limit)
                    $limit = "LIMIT " . $this->limit['Low'] . ", " . $this->limit['High'];
                else
                    $limit = '';
                    $query = 'SELECT ' . $this->select_fields . ' FROM ' . $this->select_table . ' ' . $filter;
//        echo "Asi se arma el query: " . $query ."<br>";
                    // Inform the user of any errors. Commonly caused when a column is specified in the filter or order clause that does not exist
                    //echo $query . ' ' . $order . ' ' . $limit;
                    $this->result = $this->_db->query($query . ' ' . $order . ' ' . $limit, false);
                    if (!$this->result)
                    {
			echo '<div style="color: red; font-weight: bold; border: 2px solid red; padding: 10px;">Oops! We ran into a problem while trying to output the table. <a href="javascript:;" onclick="tblReset()">Click here</a> to reset the table or <a href="javascript:;" onclick="alert(\'' . ereg_replace('[\'"]', '', $this->_db->error()) . '\')">here</a> to review the error.</div>';
			return;
                    }

                    // Count the number of rows without the limit clause
                    $this->row_count = (int) $this->_db->selectOneValue('COUNT(*)', $this->select_table, $filter_query); // Old code which does not support large data sets: $this->_db->countRows($query);

                    //        $this->setArrayFiltro();
                    if (!$this->isAjaxUsed())
                    {
                      // Print out required javascript functions
                      $this->printJavascript();
                      echo '<script type="text/javascript">function updateTable() { window.location = "?" + params; }</script>';
                    }
                    echo '<form action="#" name="dg" id="dg">';

                    // Output the create button
                    if ($this->create_button)
			echo '<span class="tbl-create">
                            <a ' . $this->create_button['Action'] . ' title="' . $this->create_button['Text'] . '">
                                <img src="' . $this->image_path . $this->img_create . '" class="tbl-create-image">' . $this->create_button['Text'] . '</a></span>';

                    // Output the reset button
                    if ($this->reset_button)
			echo '<span class="tbl-reset">
                            <a href="javascript:;" onclick="tblReset()" title="' . $this->reset_button .'">
                                <img src="' . $this->image_path . $this->img_reset . '" class="tbl-reset-image">' . $this->reset_button .'</a></span>';
                        echo '<table class="tbl" cellpadding="10" cellspacing="10" border="1">';
                        $this->buildHeader();
                        echo '<tbody>';

                    if ($this->row_count == 0)
			echo '<tr><td align="center" colspan="' . $this->column_count . '" class="tbl-noresults">' . self::TXT_NORESULTS . '</td></tr>';
                    else {
			$i = 0; $first = 0; $last = 0;

			while ($row = $this->_db->fetchAssoc($this->result))
			{
                        //if ($this->header['pro_nueva'] == 'EFECTIVO'){
                        //    echo '<tr align="center" style="background:yellow;"';

                        //}else{
                            echo '<tr align="center" class="tbl-row tbl-row-' . (($i % 2) ? 'odd' : 'even'); // Switch up the bgcolors on each row

                        //}
                            // Handle row selects
                            if ($this->row_select)
				echo ' tbl-row-highlight" onclick="' . $this->parseVariables($row, $this->row_select);
				echo '">';
				$line = ($this->page == 1)
					? $i + 1
					: $i + 1 + (($this->page - 1) * $this->results_per_page);
				$last = $line; // Last line
				if ($first == 0)
					$first = $line; // First line
				if ($this->show_row_number)
                                    echo '<td align="center" class="tbl-row-num">' . $line . '</td>';
				if ($this->show_checkboxes)
                                    echo '<td align="center">
                                          <input type="checkbox" class="tbl-checkbox" id="checkbox" name="tbl-checkbox" value="' . $row[$this->primary] . '"></td>';
				foreach ($row as $key => $value)
				{//echo'value:'.$value.'-key:'.$key.'</br>';
                                    //Agregado para modificar saldos
                                    if ($key == 'cantidad_Chacarita') {//echo'key:'.$key.'</br>';
                                        $pro_cant = new productos();
                                        $value=$pro_cant->getCantidadProducto($value, 2);//echo'v:'.$value.'-k:'.$key.'</br>';
                                    }
                                    if ($key == 'cantidad_Palermo') {//echo'key:'.$key.'</br>';
                                        $pro_cant = new productos();
                                        $value=$pro_cant->getCantidadProducto($value, 3);//echo'v:'.$value.'-k:'.$key.'</br>';
                                    }
                                    if ($key == 'cantidad_Taller') {//echo'key:'.$key.'</br>';
                                        $pro_cant = new productos();
                                        $value=$pro_cant->getCantidadProducto($value, 1);//echo'v:'.$value.'-k:'.$key.'</br>';
                                    }
                                    if ($key == 'cantidad_Deposito') {//echo'key:'.$key.'</br>';
                                        $pro_cant = new productos();
                                        $value=$pro_cant->getCantidadProducto($value, 4);//echo'v:'.$value.'-k:'.$key.'</br>';
                                    }
                                    // Skip if column is hidden
                                    if (in_array($key, $this->hidden))
					continue;
					
                                    if ($row == 14) {$this->buildControls($row);}
                    
                                    // Apply a column type to the value
                                    if (array_key_exists($key, $this->type))
                                    {
                                        list($type, $criteria, $criteria_2) = $this->type[$key];
                                        switch ($type)
                                        {
                                          case self::TYPE_ONCLICK:
                                            if ($value)
                                                $value = '<a href="javascript:;" onclick="' . $this->parseVariables($row, $criteria) . '">' . $value . '</a>';
                                                break;
                                          case self::TYPE_HREF:
                                            if ($value)
                                                $value = '<a href="' . $this->parseVariables($row, $criteria) . '">' . $value . '</a>';
                                                break;
                                          case self::TYPE_DATE:
                                            if ($criteria_2 == true)
                                                $value = date($criteria, strtotime($value));
                                            else
                                                $value = date($criteria, $value);
                                            break;
                                          case self::TYPE_IMAGE:
                                            //$value = '<img width="50" height="50" src="' . $this->parseVariables($row, $criteria) . '" id="' . $key . '-' . $i . '">';
                                            $value = '<ul id="mycarousel" class="jcarousel jcarousel-skin-tango">';
                                            $value .= '<li><a href="' . $this->parseVariables($row, $criteria) . '" rel="lightbox[roadtrip]" title="" ><img width="50" height="50" src="' . $this->parseVariables($row, $criteria) . '" id="' . $key . '-' . $i . '"></li>';
                                            $value .= '</ul>';
                                            break;
                                          case self::TYPE_ARRAY:
                                            $value = $criteria[$value];
                                            break;
                                          case self::TYPE_CHECK:
                                            if ($value == '1' or $value == 'yes' or $value == 'true' or ($criteria != '' and $value == $criteria))
                                                    $value = '<img src="' . $this->image_path . 'check.gif">';
                                            break;
                                          case self::TYPE_PERCENT:
                                            if ($criteria == true)
                                                $value *= 100; // Value is in decimal format

                                                $value = round($value); // Round to the nearest decimal
                                                $value .= '%';

                                                // Apply a bar if an array is supplied via criteria_2
                                                if (is_array($criteria_2))
                                                    $value = '<div style="background: ' . $criteria_2['Back'] . '; width: ' . $value . '; color: ' . $criteria_2['Fore'] . ';">' . $value . '</div>';
                                                break;
                                          case self::TYPE_DOLLAR:
                                            $value = '$' . number_format($value, 2);
                                            break;
                                          case self::TYPE_NUMBER:
                                            $value = number_format($value, 0);
                                            break;
                                          case self::TYPE_CUSTOM:
                                            $value = $this->parseVariables($row, $criteria);
                                            break;
                                          case self::TYPE_FUNCTION:
                                            if (is_array($criteria_2))
                                                $value = call_user_func_array($criteria, $this->parseVariables($row, $criteria_2));
                                            else
                                                $value = call_user_func($criteria, $this->parseVariables($row, $criteria_2));
                                                break;
                                                default:
                                                // Invalid column type
                                                break;
                                            }//switch
                                    }

                                    if ($type == self::TYPE_NUMBER){
                                        echo '<td class="tbl-cell" align="center">' . $value . '</td>';
                                    } else {
                                        echo '<td class="tbl-cell" align="center">' . $value . '</td>';
                                    }
				}//foreach
				$this->buildControls($row);
				echo '</tr>';

				$i++;
			}//while
            }
          echo '</tbody>';
          $this->buildFooter($i, $first, $last);
          echo '</table></form>';
	}

	public function printTable($Pwhere = "")
	{
		// Set the limit
		$this->setLimit(($this->page - 1) * $this->results_per_page, $this->results_per_page);

		// FILTER
            $filter_query = '';
//            echo "Asi se setea Where 2: " . $this->select_where . "<br>";
    		if ($this->select_where){
    			//echo "Asi llega la printTable: " . $this->select_where . "<br>";
    			$filter_query .= "(" . $this->select_where . ")";}
    
    		if ($this->allow_filters and $this->filter)
    		{
    			if (!strstr($this->filter['Value'], '%'))
    				$filter_value = '%' . $this->filter['Value'] . '%';
    			else
    				$filter_value = $this->filter['Value'];
    
    			if ($this->select_where)
    				$filter_query = $filter_query . " AND ";
    
    			if (!strstr($this->filter['Column'], 'select')){/*AGREGADO POR EDU*/
                    $filter_query .= "(`" . $this->filter['Column'] . "` LIKE '" . $filter_value . "')";
                } else {
                    $filter_query .= "(" . $this->filter['Column'] . " LIKE '" . $filter_value . "')";
                }
    		}
//    	}	
		if ($filter_query)
			{$filter = 'WHERE ' . $filter_query;
//            echo "Asi se setea filter: " . $filter . "<br>";
            }
        
		// ORDER
		if ($this->order)
			$order = "ORDER BY `" . $this->order['Column'] . "` " . $this->order['Order'];
		 elseif ($this->orderby != '')
		  $order = "ORDER BY " . $this->orderby;
		 else
			$order = '';
        
		// LIMIT
		if ($this->limit)
			$limit = "LIMIT " . $this->limit['Low'] . ", " . $this->limit['High'];
		else
			$limit = '';

		$query = 'SELECT ' . $this->select_fields . ' FROM ' . $this->select_table . ' ' . $filter;
//        echo "Asi se arma el query: " . $query ."<br>";
		// Inform the user of any errors. Commonly caused when a column is specified in the filter or order clause that does not exist
		//echo $query . ' ' . $order . ' ' . $limit;
        $this->result = $this->_db->query($query . ' ' . $order . ' ' . $limit, false);
		if (!$this->result)
		{
			echo '<div style="color: red; font-weight: bold; border: 2px solid red; padding: 10px;">Oops! We ran into a problem while trying to output the table. <a href="javascript:;" onclick="tblReset()">Click here</a> to reset the table or <a href="javascript:;" onclick="alert(\'' . ereg_replace('[\'"]', '', $this->_db->error()) . '\')">here</a> to review the error.</div>';
			return;
		}

		// Count the number of rows without the limit clause
		$this->row_count = (int) $this->_db->selectOneValue('COUNT(*)', $this->select_table, $filter_query); // Old code which does not support large data sets: $this->_db->countRows($query);

		if (!$this->isAjaxUsed())
		{
			// Print out required javascript functions
			$this->printJavascript();
			echo '<script type="text/javascript">function updateTable() { window.location = "?" + params; }</script>';
		}

		echo '<form action="#" name="dg" id="dg">';

		// Output the create button
		if ($this->create_button)
			echo '<span class="tbl-create"><a ' . $this->create_button['Action'] . ' title="' . $this->create_button['Text'] . '"><img src="' . $this->image_path . $this->img_create . '" class="tbl-create-image">' . $this->create_button['Text'] . '</a></span>';

		// Output the reset button
		if ($this->reset_button)
			echo '<span class="tbl-reset"><a href="javascript:;" onclick="tblReset()" title="' . $this->reset_button .'"><img src="' . $this->image_path . $this->img_reset . '" class="tbl-reset-image">' . $this->reset_button .'</a></span>';

		echo '<table class="tbl" cellpadding="10" cellspacing="10" border="1">';

		$this->buildHeader();

		echo '<tbody>';

		if ($this->row_count == 0)
			echo '<tr><td align="center" colspan="' . $this->column_count . '" class="tbl-noresults">' . self::TXT_NORESULTS . '</td></tr>';
		else {
			$i = 0; $first = 0; $last = 0;

			while ($row = $this->_db->fetchAssoc($this->result))
			{
				echo '<tr align="center" class="tbl-row tbl-row-' . (($i % 2) ? 'odd' : 'even'); // Switch up the bgcolors on each row

				// Handle row selects
				if ($this->row_select)
					echo ' tbl-row-highlight" onclick="' . $this->parseVariables($row, $this->row_select);

				echo '">';

				$line = ($this->page == 1)
							? $i + 1
							: $i + 1 + (($this->page - 1) * $this->results_per_page);

				$last = $line; // Last line
				if ($first == 0)
					$first = $line; // First line

				if ($this->show_row_number)
					echo '<td align="center" class="tbl-row-num">' . $line . '</td>';

				if ($this->show_checkboxes)
					echo '<td align="center"><input type="checkbox" class="tbl-checkbox" id="checkbox" name="tbl-checkbox" value="' . $row[$this->primary] . '"></td>';

				foreach ($row as $key => $value)
				{
					// Skip if column is hidden
					if (in_array($key, $this->hidden))
						continue;

					// Apply a column type to the value
					if (array_key_exists($key, $this->type))
					{
						list($type, $criteria, $criteria_2) = $this->type[$key];

						switch ($type)
						{
							case self::TYPE_ONCLICK:
								if ($value)
									$value = '<a href="javascript:;" onclick="' . $this->parseVariables($row, $criteria) . '">' . $value . '</a>';
								break;

							case self::TYPE_HREF:
								if ($value)
									$value = '<a href="' . $this->parseVariables($row, $criteria) . '">' . $value . '</a>';
								break;

							case self::TYPE_DATE:
								if ($criteria_2 == true)
									$value = date($criteria, strtotime($value));
								else
									$value = date($criteria, $value);
								break;

							case self::TYPE_IMAGE:
								$value = '<img src="' . $this->parseVariables($row, $criteria) . '" id="' . $key . '-' . $i . '">';
								break;

							case self::TYPE_ARRAY:
								$value = $criteria[$value];
								break;

							case self::TYPE_CHECK:
								if ($value == '1' or $value == 'yes' or $value == 'true' or ($criteria != '' and $value == $criteria))
									$value = '<img src="' . $this->image_path . 'check.gif">';
								break;

							case self::TYPE_PERCENT:
								if ($criteria == true)
									$value *= 100; // Value is in decimal format

								$value = round($value); // Round to the nearest decimal

								$value .= '%';

								// Apply a bar if an array is supplied via criteria_2
								if (is_array($criteria_2))
									$value = '<div style="background: ' . $criteria_2['Back'] . '; width: ' . $value . '; color: ' . $criteria_2['Fore'] . ';">' . $value . '</div>';
								break;

							case self::TYPE_DOLLAR:
								$value = '$' . number_format($value, 2);
								break;

							case self::TYPE_NUMBER:
								$value = number_format($value, 0);
								break;

							case self::TYPE_CUSTOM:
								$value = $this->parseVariables($row, $criteria);
								break;

							case self::TYPE_FUNCTION:
								if (is_array($criteria_2))
									$value = call_user_func_array($criteria, $this->parseVariables($row, $criteria_2));
								else
									$value = call_user_func($criteria, $this->parseVariables($row, $criteria_2));
								break;

							default:
								// Invalid column type
								break;
							}
					}

					if ($type == self::TYPE_NUMBER){
					   echo '<td class="tbl-cell" align="center">' . $value . '</td>';
					} else {
                        echo '<td class="tbl-cell" align="center">' . $value . '</td>';
                    }
				}

				$this->buildControls($row);

				echo '</tr>';

				$i++;
			}
		}

		echo '</tbody>';

		$this->buildFooter($i, $first, $last);

		echo '</table></form>';
	}

	public function printTable2($Pwhere = "")
	{
		// Set the limit
		$this->setLimit(($this->page - 1) * $this->results_per_page, $this->results_per_page);

		// FILTER
        //if($Pwhere!=''){$this->select_where = $Pwhere;}
        //$this->select_where = $Pwhere;
//		echo "Pwhere: " . $Pwhere ."<br>";
        $filter_query = $Pwhere;
        if($Pwhere==''){ 
            $filter_query = '';
//            echo "Asi se setea Where 2: " . $this->select_where . "<br>";
    		if ($this->select_where){
    			//echo "Asi llega la printTable: " . $this->select_where . "<br>";
    			$filter_query .= "(" . $this->select_where . ")";}
    
    		if ($this->allow_filters and $this->filter)
    		{
    			if (!strstr($this->filter['Value'], '%'))
    				$filter_value = '%' . $this->filter['Value'] . '%';
    			else
    				$filter_value = $this->filter['Value'];
    
    			if ($this->select_where)
    				$filter_query = $filter_query . " AND ";
    
    			if (!strstr($this->filter['Column'], 'select')){/*AGREGADO POR EDU*/
                    $filter_query .= "(`" . $this->filter['Column'] . "` LIKE '" . $filter_value . "')";
                } else {
                    $filter_query .= "(" . $this->filter['Column'] . " LIKE '" . $filter_value . "')";
                }
    		}
    	}	
		if ($filter_query)
			{$filter = 'WHERE ' . $filter_query;
//            echo "Asi se setea filter: " . $filter . "<br>";
            }
        
		// ORDER
		if ($this->order)
			$order = "ORDER BY `" . $this->order['Column'] . "` " . $this->order['Order'];
		else
			$order = '';

		// LIMIT
		if ($this->limit)
			$limit = "LIMIT " . $this->limit['Low'] . ", " . $this->limit['High'];
		else
			$limit = '';

		$query = 'SELECT ' . $this->select_fields . ' FROM ' . $this->select_table . ' ' . $filter;
//        echo "Asi se arma el query: " . $query ."<br>";
		// Inform the user of any errors. Commonly caused when a column is specified in the filter or order clause that does not exist
		$this->result = $this->_db->query($query . ' ' . $order . ' ' . $limit, false);
		if (!$this->result)
		{
			echo '<div style="color: red; font-weight: bold; border: 2px solid red; padding: 10px;">Oops! We ran into a problem while trying to output the table. <a href="javascript:;" onclick="tblReset()">Click here</a> to reset the table or <a href="javascript:;" onclick="alert(\'' . ereg_replace('[\'"]', '', $this->_db->error()) . '\')">here</a> to review the error.</div>';
			return;
		}

		// Count the number of rows without the limit clause
		$this->row_count = (int) $this->_db->selectOneValue('COUNT(*)', $this->select_table, $filter_query); // Old code which does not support large data sets: $this->_db->countRows($query);

		if (!$this->isAjaxUsed())
		{
			// Print out required javascript functions
			$this->printJavascript();
			echo '<script type="text/javascript">function updateTable() { window.location = "?" + params; }</script>';
		}

		echo '<form action="#" name="dg" id="dg">';

		// Output the create button
		if ($this->create_button)
			echo '<span class="tbl-create"><a ' . $this->create_button['Action'] . ' title="' . $this->create_button['Text'] . '"><img src="' . $this->image_path . $this->img_create . '" class="tbl-create-image">' . $this->create_button['Text'] . '</a></span>';

		// Output the reset button
		if ($this->reset_button)
			echo '<span class="tbl-reset"><a href="javascript:;" onclick="tblReset()" title="' . $this->reset_button .'"><img src="' . $this->image_path . $this->img_reset . '" class="tbl-reset-image">' . $this->reset_button .'</a></span>';

		echo '<table class="tbl" cellpadding="10" cellspacing="10" border="1">';

		$this->buildHeader();

		echo '<tbody>';

		if ($this->row_count == 0)
			echo '<tr><td align="center" colspan="' . $this->column_count . '" class="tbl-noresults">' . self::TXT_NORESULTS . '</td></tr>';
		else {
			$i = 0; $first = 0; $last = 0;

			while ($row = $this->_db->fetchAssoc($this->result))
			{
				echo '<tr align="center" class="tbl-row tbl-row-' . (($i % 2) ? 'odd' : 'even'); // Switch up the bgcolors on each row

				// Handle row selects
				if ($this->row_select)
					echo ' tbl-row-highlight" onclick="' . $this->parseVariables($row, $this->row_select);

				echo '">';

				$line = ($this->page == 1)
							? $i + 1
							: $i + 1 + (($this->page - 1) * $this->results_per_page);

				$last = $line; // Last line
				if ($first == 0)
					$first = $line; // First line

				if ($this->show_row_number)
					echo '<td align="center" class="tbl-row-num">' . $line . '</td>';

				if ($this->show_checkboxes)
					echo '<td align="center"><input type="checkbox" class="tbl-checkbox" id="checkbox" name="tbl-checkbox" value="' . $row[$this->primary] . '"></td>';

				foreach ($row as $key => $value)
				{
					// Skip if column is hidden
					if (in_array($key, $this->hidden))
						continue;

					// Apply a column type to the value
					if (array_key_exists($key, $this->type))
					{
						list($type, $criteria, $criteria_2) = $this->type[$key];

						switch ($type)
						{
							case self::TYPE_ONCLICK:
								if ($value)
									$value = '<a href="javascript:;" onclick="' . $this->parseVariables($row, $criteria) . '">' . $value . '</a>';
								break;

							case self::TYPE_HREF:
								if ($value)
									$value = '<a href="' . $this->parseVariables($row, $criteria) . '">' . $value . '</a>';
								break;

							case self::TYPE_DATE:
								if ($criteria_2 == true)
									$value = date($criteria, strtotime($value));
								else
									$value = date($criteria, $value);
								break;

							case self::TYPE_IMAGE:
								$value = '<img src="' . $this->parseVariables($row, $criteria) . '" id="' . $key . '-' . $i . '">';
								break;

							case self::TYPE_ARRAY:
								$value = $criteria[$value];
								break;

							case self::TYPE_CHECK:
								if ($value == '1' or $value == 'yes' or $value == 'true' or ($criteria != '' and $value == $criteria))
									$value = '<img src="' . $this->image_path . 'check.gif">';
								break;

							case self::TYPE_PERCENT:
								if ($criteria == true)
									$value *= 100; // Value is in decimal format

								$value = round($value); // Round to the nearest decimal

								$value .= '%';

								// Apply a bar if an array is supplied via criteria_2
								if (is_array($criteria_2))
									$value = '<div style="background: ' . $criteria_2['Back'] . '; width: ' . $value . '; color: ' . $criteria_2['Fore'] . ';">' . $value . '</div>';
								break;

							case self::TYPE_DOLLAR:
								$value = '$' . number_format($value, 2);
								break;

							case self::TYPE_NUMBER:
								$value = number_format($value, 0);
								break;

							case self::TYPE_CUSTOM:
								$value = $this->parseVariables($row, $criteria);
								break;

							case self::TYPE_FUNCTION:
								if (is_array($criteria_2))
									$value = call_user_func_array($criteria, $this->parseVariables($row, $criteria_2));
								else
									$value = call_user_func($criteria, $this->parseVariables($row, $criteria_2));
								break;

							default:
								// Invalid column type
								break;
							}
					}

					if ($type == self::TYPE_NUMBER){
					   echo '<td class="tbl-cell" align="center">' . $value . '</td>';
					} else {
                        echo '<td class="tbl-cell" align="center">' . $value . '</td>';
                    }
				}

				$this->buildControls($row);

				echo '</tr>';

				$i++;
			}
		}

		echo '</tbody>';

		$this->buildFooter($i, $first, $last);

		echo '</table></form>';
	}

	/**
	 * Prints out script to handle Ajax data grids
	 *
	 * @param string $responce Responce script
	 */
	public static function useAjaxTable($responce = '')
	{
        self::printJavascript();

		// If no responce script is set, use the current script
		if (empty($responce))
			$responce = $_SERVER['PHP_SELF'];
        
		echo "<script type=\"text/javascript\">\n";
		echo "var xmlHttp\n";
		echo "function SetXmlHttpObject() {\n";
		echo "xmlHttp = null;\n";
		echo "try { xmlHttp = new XMLHttpRequest(); }\n";
		echo "catch (e) {\n";
		echo "try { xmlHttp = new ActiveXObject('Msxml2.XMLHTTP'); }\n";
		echo "catch (e) { xmlHttp = new ActiveXObject('Microsoft.XMLHTTP'); } }\n";
		echo "if (xmlHttp == null) {alert('Your web browser does not support Ajax'); }\n";
		echo "return xmlHttp; }\n";
		echo "function stateChanged() { if (xmlHttp.readyState == 4) { document.getElementById('eyedatagrid').innerHTML = xmlHttp.responseText; } }\n";
		echo "function updateTable() { xmlHttp = SetXmlHttpObject(); xmlHttp.onreadystatechange = stateChanged; xmlHttp.open('GET', '" . $responce . "?useajax=true' + params, true); xmlHttp.send(null); }\n";
		echo "</script>\n";
		echo "<div id=\"eyedatagrid\"></div>\n";
		echo "<script type=\"text/javascript\">updateTable();</script>\n";
	}

	/**
	* Prints the required JS functions
	*
	*/
	public function printJavascript()
	{
		if ($this)
		{
			$page = $this->page;
			$order = (($this->order) ? implode(':', $this->order) : '');
			$filter = (($this->filter) ? implode(':', $this->filter) : '');
		}

		echo "<script type=\"text/javascript\">\n";
		echo "var params = ''; var tblpage = '" . $page . "'; var tblorder = '" . $order . "'; var tblfilter = '" . $filter . "';\n";
		echo "function tblSetPage(page) { tblpage = page; params = '&page=' + page + '&order=' + tblorder + '&filter=' + tblfilter; updateTable(); }\n";
		echo "function tblSetOrder(column, order) { tblorder = column + ':' + order; params = '&page=' + tblpage + '&order=' + tblorder + '&filter=' + tblfilter; updateTable(); }\n";
		echo "function tblSetFilter2(column) { val = document.getElementById('filter-value-' + column).value; alert('Valor: ' + 'filter-value-' + column); tblfilter = column + ':' + val; tblpage = 1; params = '&page=1&order=' + tblorder + '&filter=' + tblfilter; alert ('FILTER:' + tblfilter); updateTable(); }\n";
        echo "function tblSetFilter(column) {tblfilter='';";
        $count = count($_SESSION["FILTROS"]);
        for ($i = 0; $i < $count; $i++) {
        	$filtro = $_SESSION["FILTROS"][$i];
        	echo "val = document.getElementById('filter-value-$filtro').value; 
                if (val!=''){
        			tblfilter = tblfilter + '$filtro' + ':' + val + ';' ;
        		}";
        }
        echo "tblpage = 1; 
        params = '&page=1&order=' + tblorder + '&filter=' + tblfilter; 
        updateTable();}";
//        alert ('FILTER:' + tblfilter);

		echo "function tblClearFilter() { tblfilter = ''; params = '&page=1&order=' + tblorder + '&filter='; updateTable(); }\n";
		echo "function tblToggleCheckAll() { for (i = 0; i < document.dg.checkbox.length; i++) { document.dg.checkbox[i].checked = !document.dg.checkbox[i].checked; } }\n";
		echo "function tblShowHideFilter(column) { var o = document.getElementById('filter-' + column); if (o.style.display == 'block') { tblClearFilter(); } else {	o.style.display = 'block'; } }\n";
		echo "function tblReset() { params = '&page=1'; tblClearFilter(); updateTable(); }\n";
		echo "function Navegar_prox_item() {//alert ( 'ho1');
                        if (window.event.keyCode == 9){//alert ( 'tab')
                        } ;
                    }\n";
		echo "document.onkeypress=function(e){
                        var esIE=(document.all);
                        var esNS=(document.layers);
                        tecla=(esIE) ? event.keyCode : e.which;
                        if(tecla==13){
                            tblSetFilter();return false;
                        }
                    }\n";
		echo "</script>\n";

	}
}