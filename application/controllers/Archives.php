<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH .'third_party/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

class Archives extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */	

	public function __construct()
	{
		parent::__construct();
        is_user_logged();
        $this->load->model('brand_model');
        $this->load->model('post_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
	}

	function index()
	{
		$this->data = array();		
		$slug = $this->uri->segment(2);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);
		if(!empty($brand))
		{
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['brand'] = $brand[0];

			$this->data['view'] = 'archives/archives';
			$this->data['layout'] = 'layouts/new_user_layout';

			$this->data['css_files'] = array(css_url().'fullcalendar.css');
			$this->data['js_files'] = array(js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0');

	        _render_view($this->data);
	    }
	}

	public function export_post($slug)
	{

		$post_data = $this->input->post();
		if(isset($post_data) && !empty($post_data))
		{
			$brand_id = $post_data['brand_id'];
			$type = strtoupper($post_data['exportType']);
			$daterange =[];			
			switch ($post_data['exportDate']) {
				case '7days':
					$daterange['start_date']= date('Y-m-d', strtotime('-7 days'));
					$daterange['end_date']= date('Y-m-d');
					break;
				case '30days':
					$daterange['start_date']= date('Y-m-d', strtotime('today - 30 days'));
					$daterange['end_date']= date('Y-m-d');
					break;
				case 'month':
					$daterange['start_date']= date('Y-m-d', strtotime('first day of last month'));
					$daterange['end_date']= date('Y-m-d', strtotime('last day of last month'));
					break;
				case '3months':
					$months = date('m-Y', strtotime('-4 month'));
					$daterange['months'] = $months;
					$daterange['start_date']= date('Y-m-d', strtotime('1-'.$months));
					$daterange['end_date']= date('Y-m-d', strtotime('last day of last month'));
					break;
				case 'year':
					$year = date("Y",strtotime("-1 year"));
					$daterange['start_date']= date('Y-m-d', strtotime('1-1-'.$year));
					$daterange['end_date']= date('Y-m-d', strtotime('31-12-'.$year));
					break;
				default:
					// daterange
					$daterange['start_date']= date('Y-m-d', strtotime($post_data['start-date']));
					$daterange['end_date']= date('Y-m-d', strtotime($post_data['end-date']));
					break;
			}
			$posts = $this->post_model->export_post($brand_id,$daterange['start_date'],$daterange['end_date'],$type);

			if($type == 'PDF')
			{
				if(!empty($posts))
				{
					$this->data['brand_id'] = $brand_id;
					$this->data['post_details'] = $posts;
					// $this->load->view('archives/pdf_export', $this->data);
					$html = $this->load->view('archives/pdf_export', $this->data, true);
					$this->pdf_create( $html,$brand_id.'.pdf');
				}
				
			}
			else if($type == 'CSV')
			{
				if(!empty($daterange['start_date']) && !empty($daterange['end_date']))
				{
					$posts = $this->object_to_array($posts);
					$this->outputCSV($posts);
				}
			}
		}
		else
		{
			redirect(base_url().'archives/'.$slug);
		}
		
	}

	function object_to_array($data)
	{
	    if (is_array($data) || is_object($data))
	    {
	        $result = array();
	        foreach ($data as $key => $value)
	        {
	            $result[$key] = $this->object_to_array($value);
	        }
	        return $result;
	    }
	    return $data;
	}

	 function outputCSV($data,$file_name = 'file.csv') {
       # output headers so that the file is downloaded rather than displayed
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=$file_name");
        # Disable caching - HTTP 1.1
        header("Cache-Control: no-cache, no-store, must-revalidate");
        # Disable caching - HTTP 1.0
        header("Pragma: no-cache");
        # Disable caching - Proxies
        header("Expires: 0");
    
        # Start the ouput
        $output = fopen("php://output", "w");
        fputcsv($output, array('ID', 'CONTENT', 'BRAND' ,'SLATE_DATE_TIME','STATUS','USER','OUTLETS','CREATED_AT','MEDIA','TAGS')); //The column heading row of the csv file
        
         # Then loop through the rows
        foreach ($data as $row) {
            # Add the rows to the body
            fputcsv($output, $row); // here you can change delimiter/enclosure
        }
        # Close the stream off
        fclose($output);
    }

    function pdf_create( $html, $filename, $output_type = 'stream' )
    {
    	
    	// Remove all previously created headers if streaming output
    	if( $output_type == 'stream' )
    	{
    		header_remove();
    	}
    	// Load dompdf and create object
    	
    	$options = new Options();
    	$options->set('isRemoteEnabled', TRUE);
    	$options->set('debugKeepTemp', TRUE);
	    $options->set('isHtml5ParserEnabled', true);
	    $options->set('DEBUGCSS', true);
	    $options->set('DEBUG_LAYOUT', true);
	    $options->set('DEBUGKEEPTEMP', false);
	    $options->set('DOMPDF_TEMP_DIR', 'tmp' );
	    $options->setIsRemoteEnabled(true);
	    $dompdf = new Dompdf($options);

	    // Loads an HTML string
	    $dompdf->loadHtml( $html );

	    // Create the PDF
	    $dompdf->render();

	   // $dompdf->set_base_path( css_url().'/style.css');

	    // If destination is the browser
	    if( $output_type == 'stream' )
	    {
	    	// $dompdf->stream($filename);
	    	// 0 = open in tab, 1 = download pdf file
	    	$dompdf->stream($filename, array('Attachment'=>0));
	    }
	    // Return PDF as a string (useful for email attachments)
	    else if( $output_type == 'string' )
	    {
	    	return $dompdf->output(1);
	    }
	    // If saving to the server
	    else 
	    {
	        // Save the file
	    	write_file( $filename, $dompdf->output() );
	    }
	}

}