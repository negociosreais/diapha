<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Pagination Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Pagination
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/pagination.html
 */
 
class CI_Pagination {

	var $base_url			= ''; // The page we are linking to
	var $total_rows  		= ''; // Total number of items (database results)
	var $per_page	 		= 20; // Max number of items you want shown per page
	var $num_links			=  7; // Number of "digit" links to show before/after the currently viewed page
	var $cur_page	 		=  0; // The current page being viewed
	var $first_link   		= '&lsaquo; Primeira';
	var $next_link			= '&gt;';
	var $prev_link			= '&lt;';
	var $last_link			= ' Última &rsaquo;';
	var $uri_segment		= 20;
	var $full_tag_open		= '';
	var $full_tag_close		= '';
	var $first_tag_open		= '';
	var $first_tag_close	= '&nbsp;';
	var $last_tag_open		= '&nbsp;';
	var $last_tag_close		= '';
	var $cur_tag_open		= ' &nbsp; <b>';
	var $cur_tag_close		= '</b>';
	var $next_tag_open		= '&nbsp;';
	var $next_tag_close		= '&nbsp;';
	var $prev_tag_open		= '&nbsp;';
	var $prev_tag_close		= '';
	var $num_tag_open		= '&nbsp;';
	var $num_tag_close		= '';
	var $page_query_string	= false;
	var $query_string_segment = 'per_page';
        var $params               = ''; // Parametros extras que serão passados para o link

	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */
	function CI_Pagination($params = array())
	{
		if (count($params) > 0)
		{
			$this->initialize($params);		
		}
		
		log_message('debug', "Pagination Class Initialized");
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	function initialize($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate the pagination links
	 *
	 * @access	public
	 * @return	string
	 */	
		function create_links()
	{

                // If our item count or per-page total is zero there is no need to continue.
		if ($this->total_rows == 0 OR $this->per_page == 0)
		{
		   return '';
		}

	
		if ( $this->total_rows <= $this->per_page )
		{	
		return  " <b  class='textoconteudo'> Total de Registros: <b>{$this->total_rows} </b> </b><br>";		
       }

		// Calculate the total number of pages
		$num_pages = ceil($this->total_rows / $this->per_page);

		// Is there only one page? Hm... nothing more to do here then.
		if ($num_pages == 1)
		{
			return '';
		}

		// Determine the current page number.		
		$CI =& get_instance();
		
		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			if ($CI->input->get($this->query_string_segment) != 0)
			{
				$this->cur_page = $CI->input->get($this->query_string_segment);
				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}
		else
		{
			if ($CI->uri->segment($this->uri_segment) != 0)
			{
				$this->cur_page = $CI->uri->segment($this->uri_segment);
				
				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}
		
		
		 
		$this->num_links = (int)$this->num_links;
	
		
		if ($this->num_links < 1)
		{
			show_error('Your number of links must be a positive number.');
		}
				
		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = 0;
		}
		
		// Is the page number beyond the result range?
		// If so we show the last page
		if ($this->cur_page > $this->total_rows)
		{
			$this->cur_page = ($num_pages - 1) * $this->per_page;
		}
		
		
		$baseTotal = (int) ($this->total_rows /  $this->per_page) ;
		$baseTotal += ($this->total_rows %  $this->per_page) ? 1 : 0;
		
		
		$this->cur_page = (int) ( ( (int) $_REQUEST['per_page'] * (int) $baseTotal )/  $this->total_rows  ) + 1;
		$uri_page_number = $this->cur_page;
		//$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);

		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;

		// Is pagination being used over GET or POST?  If get, add a per_page query
		// string. If post, add a trailing slash to the base URL if needed
		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			$this->base_url = rtrim($this->base_url).'&amp;'.$this->query_string_segment.'=';
		}
		else
		{
			$this->base_url = rtrim($this->base_url, '/') .'/';
		}

  		// And here we go...
		$output = '';

		// Render the "First" link
		if  ($this->cur_page > ($this->num_links + 1))
		{
		$output .= $this->first_tag_open.'<a href="javascript:paginador(0)"> '.$this->first_link .'</a>'.$this->first_tag_close;

		}

		// Render the "previous" link
		if  ($this->cur_page != 1)
		{
			$i = $uri_page_number - $this->per_page;
			if ($i == 0) $i = '';
			$output .= $this->prev_tag_open.'<a href="javascript:paginador('.$i.')"> '.$this->prev_link.'</a>'.$this->prev_tag_close;

		}

		// Write the digit links
		for ($loop = $start -1; $loop <= $end; $loop++)
		{
			$i = ($loop * $this->per_page) - $this->per_page;
					
			if ($i >= 0)
			{
				if ($this->cur_page == $loop)
				{
					$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
				}
				else
				{
					$n = ($i == 0) ? '' : $i;
					$output .= $this->num_tag_open.'<a href="?per_page='. $n . $this->params .'"> '.$loop.'</a>'.$this->num_tag_close;
				}
			}
		}

		// Render the "next" link
                // Modificado dia 30 de maio de 2012 por Rafael Menezes
		if ($this->cur_page < $num_pages)
		{		
			$output .= $this->next_tag_open.'<a href="?per_page='.($this->cur_page * $this->per_page) . $this->params . '"> '.$this->next_link.' </a>' .$this->next_tag_close;
			
		}

		// Render the "Last" link
		if (($this->cur_page + $this->num_links) < $num_pages)
		{
			$i = (($num_pages * $this->per_page) - $this->per_page);

			$output .= $this->last_tag_open.'<a href="?per_page=' . $i  . $this->params .'"> '.$this->last_link.' </a>'.$this->last_tag_close;
		}

		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;
		
		return  "
                 <form name='paginador' action='' method='get'>
                 <div id='div_paginacao' class='textoconteudo'>
		 Total: <b>{$this->total_rows} </b> Mostrando <b>{$this->per_page} </b> por pagina:" .$output . "</div><br>
                 </form>
                 ";
	}
	
	/**
	 * Generate the pagination links
	 *
	 * @access	public
	 * @return	string
	 */	
	function create_links_old()
	{
		// If our item count or per-page total is zero there is no need to continue.
		if ($this->total_rows == 0 OR $this->per_page == 0)
		{
		   return '';
		}

		if ( $this->total_rows <= $this->per_page )
		{	
		return  " <b  class='textoconteudo'> Total de Registros: <b>{$this->total_rows} </b> </b><br>";		
       }

		// Calculate the total number of pages
		$num_pages = ceil($this->total_rows / $this->per_page);

		// Is there only one page? Hm... nothing more to do here then.
		if ($num_pages == 1)
		{
			return '';
		}

		// Determine the current page number.		
		$CI =& get_instance();
		
		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			if ($CI->input->get($this->query_string_segment) != 0)
			{
				$this->cur_page = $CI->input->get($this->query_string_segment);
				
				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}
		else
		{
			if ($CI->uri->segment($this->uri_segment) != 0)
			{
				$this->cur_page = $CI->uri->segment($this->uri_segment);
				
				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}

		$this->num_links = (int)$this->num_links;
		
		if ($this->num_links < 1)
		{
			show_error('Your number of links must be a positive number.');
		}
				
		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = 0;
		}
		
		// Is the page number beyond the result range?
		// If so we show the last page
		if ($this->cur_page > $this->total_rows)
		{
			$this->cur_page = ($num_pages - 1) * $this->per_page;
		}
		
		$uri_page_number = $this->cur_page;
		$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);

		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;

		// Is pagination being used over GET or POST?  If get, add a per_page query
		// string. If post, add a trailing slash to the base URL if needed
		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			$this->base_url = rtrim($this->base_url).'&amp;'.$this->query_string_segment.'=';
		}
		else
		{
			$this->base_url = rtrim($this->base_url, '/') .'/';
		}

  		// And here we go...
		$output = '';

		// Render the "First" link
		if  ($this->cur_page > ($this->num_links + 1))
		{
			$output .= $this->first_tag_open.'<a href="'.$this->base_url.'">'.$this->first_link.'ww</a>'.$this->first_tag_close;
		}

		// Render the "previous" link
		if  ($this->cur_page != 1)
		{
			$i = $uri_page_number - $this->per_page;
			if ($i == 0) $i = '';
			$output .= $this->prev_tag_open.'<a href="'.$this->base_url.$i.'">'.$this->prev_link.'rr</a>'.$this->prev_tag_close;
		}

		// Write the digit links
		for ($loop = $start -1; $loop <= $end; $loop++)
		{
			$i = ($loop * $this->per_page) - $this->per_page;
					
			if ($i >= 0)
			{
				if ($this->cur_page == $loop)
				{
					$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
				}
				else
				{
					$n = ($i == 0) ? '' : $i;
					$output .= $this->num_tag_open.'<a href="'.$this->base_url.$n.'">'.$loop.'yy</a>'.$this->num_tag_close;
				}
			}
		}

		// Render the "next" link
		if ($this->cur_page < $num_pages)
		{
			$output .= $this->next_tag_open.'<a href="'.$this->base_url.($this->cur_page * $this->per_page).'">'.$this->next_link.'</a>'.$this->next_tag_close;
		}

		// Render the "Last" link
		if (($this->cur_page + $this->num_links) < $num_pages)
		{
			$i = (($num_pages * $this->per_page) - $this->per_page);
			$output .= $this->last_tag_open.'<a href="'.$this->base_url.$i.'">'.$this->last_link.'lll</a>'.$this->last_tag_close;
		}

		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;
		
		return  " <div id='div_paginacao'  class='textoconteudo'>
		 Total: <b>{$this->total_rows} </b> Mostrando <b>{$this->per_page} </b> por pagina:" .$output . "</div><br>";		
	}
	
	
	function prepara_paginacao($strSQL,$intInicio = 0,$intFinal = 0){
	
		$intFinal 	= ($_REQUEST['per_page']) ? ( (int)$_REQUEST['per_page'] + (int) $this->per_page) : $this->per_page;
		$intInicio 	=  (int) $_REQUEST['per_page'];
		  
		if($intFinal)
			  return "SELECT * FROM (  SELECT   ROWNUM PAGING_RN ,PAGING.* FROM " .  
						 " (" . $strSQL . ") PAGING 
						 WHERE ( ROWNUM <= " . $intFinal . ")  )" .  
						 " WHERE (PAGING_RN > " . $intInicio . ")";  
		else
			return $strSQL;
	}	
	
	function montaQueryString($dados_form) {
		global $_GET, $_POST;
		
		$dados_form['skip_vars'] = 'per_page , ci_session';
		
		$partes = explode('&',$_SERVER['QUERY_STRING']);
		$ret .= "$partes[0]&$partes[1]&";	
		
		/*$partesControle = parse_str($_SERVER['QUERY_STRING'], $output);
		foreach( $output as $key=>$val){
			if(!stristr($dados_form['skip_vars'], "$key" )
			&&  !stristr($ret, "$key" ) 
			){
					$ret .= "$sep$key=$val";
					$sep = '&';
			}
		}
		*/
		
		foreach($_GET as $key=>$val){
			if(!stristr($dados_form['skip_vars'], "$key" ) 
				&&  !stristr($ret, "&$key=" ) 
				){
				$ret .= "$sep$key=$val";
				$sep = '&';
			}
			
		}
		
		foreach( $_REQUEST as $key=>$val){
			if(!stristr($dados_form['skip_vars'], "$key" )
			&&  !stristr($ret, "&$key=" ) 
			){
					$ret .= "$sep$key=$val";
					$sep = '&';
			}
		}
		return $ret;
	}
}
// END Pagination Class

/* End of file Pagination.php */
/* Location: ./system/libraries/Pagination.php */