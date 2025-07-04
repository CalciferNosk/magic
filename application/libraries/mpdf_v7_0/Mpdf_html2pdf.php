<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * HTML2PDF By mpdf
 *
 * @access	public
 * @author	Tj Thouhid
 * @var 1.0.1
 * @author url : https://www.tjthouhid.com
 * 
 */	

class Mpdf_html2pdf {

	var $html;
	var $path;
	var $filename;
	var $paper_size;
	var $orientation;
	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */	
	function __construct($params = array())
	{
	    $this->CI =& get_instance();
	    
	    if (count($params) > 0)
	    {
	        $this->initialize($params);
	    }
		
	    log_message('debug', 'PDF Class Initialized');
	
	}

		/**
		 * Initialize Preferences
		 *
		 * @access	public
		 * @param	array	initialization parameters
		 * @return	void
		 */	
	    function initialize($params)
		{
	        $this->clear();
			if (count($params) > 0)
	        {
	            foreach ($params as $key => $value)
	            {
	                if (isset($this->$key))
	                {
	                    $this->$key = $value;
	                }
	            }
	        }
		}
		// --------------------------------------------------------------------

	/**
	 * Set html
	 *
	 * @access	public
	 * @return	void
	 */	
	function html($html = NULL)
	{
        $this->html = $html;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set path
	 *
	 * @access	public
	 * @return	void
	 */	
	function folder($path)
	{
        $this->path = $path;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set path
	 *
	 * @access	public
	 * @return	void
	 */	
	function filename($filename)
	{
        $this->filename = $filename;
	}
	
	// --------------------------------------------------------------------


	/**
	 * Set paper
	 *
	 * @access	public
	 * @return	void
	 */	
	function paper($paper_size = NULL, $orientation = NULL)
	{
        $this->paper_size = $paper_size;
        $this->orientation = $orientation;
	}
	
	// --------------------------------------------------------------------

		/**
		 * Create PDF
		 *
		 * @access	public
		 * @return	void
		 */	
		function create($mode = 'download') 
		{
		    
	   		if (is_null($this->html)) {
				show_error("HTML is not set");
			}
		    
	   		if (is_null($this->path)) {
				show_error("Path is not set");
			}
		    
	   		if (is_null($this->paper_size)) {
				show_error("Paper size not set");
			}
			
			if (is_null($this->orientation)) {
				show_error("Orientation not set");
			}

			require_once __DIR__ . '/mpdf/autoload.php';

			$mpdf = new \Mpdf\Mpdf();
			//$mpdf->AddPage($this->orientation);
			$mpdf->AddPageByArray([
				'orientation'=>$this->orientation,
				'sheet-size'=>$this->paper_size
			]);
			$mpdf->WriteHTML($this->html);

			if($mode == 'save') {
	    	    
				try{
				    $mpdf->Output($this->path.$this->filename, 'F');
				    return TRUE;
				} catch(Exception $ex){
				    show_error("PDF could not be written to the path");
				}
				return file_exists($this->path.$this->filename);
			} elseif($mode == 'view'){
				if($mpdf->Output()) {
					return TRUE;
				} else {
					show_error("PDF could not be streamed");
				}
			}else {
				
				if($mpdf->Output($this->filename,"D")) {
					return TRUE;
				} else {
					show_error("PDF could not be streamed");
				}
		    }
		}
	

}