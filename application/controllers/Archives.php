<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH .'third_party/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\Frame\FrameTree;
use Dompdf\Css\Stylesheet;
use Dompdf\Autoloader;

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
		$this->plan_data = $this->config->item('plans')[$this->user_data['plan']];
	}

	function index()
	{
		$this->data = array();		
		$slug = $this->uri->segment(2);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);
		if(!empty($brand))
		{
			$this->user_data['timezone'] = $brand[0]->timezone;
			$this->data['user_group'] = get_user_groups($this->user_id,$brand[0]->id);
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['brand'] = $brand[0];

			$this->data['selected_outlets'] = $this->post_model->get_brand_outlets($brand[0]->id);
    		$this->data['selected_tags'] = $this->post_model->get_brand_tags($brand[0]->id);

			$this->data['view'] = 'archives/archives';
			$this->data['layout'] = 'layouts/new_user_layout';

			$this->data['css_files'] = array(css_url().'fullcalendar.css');
			
			$this->data['js_files'] = array(js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0');

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
			$tags ='';
			$outlets = '';
			
			if(!empty($post_data['post-outlet']))
			{
				$outlets =$post_data['post-outlet'];
			
			}
			
			if(!empty($post_data['post-tag']))
			{
				$tags = $post_data['post-tag'];
			}

			//echo '<pre>'; print_r($post_data);echo '</pre>'; die;

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

			/*
			*  function export_post($brand_id,$start_date,$end_date,$type, $tags,$outlets)
			*  parameters 1 brand id, start date, end date,
			*  type (PDF, CSV, PRINT)  
			*  tags ids with comma seperated straing like ( 1,2,3,4,5 ) 
			*  outlets list with comma seperated straing like (facebook,twitter,instagram,linkedin) 
			*/

			$posts = $this->post_model->export_post($brand_id,$daterange['start_date'],$daterange['end_date'],$type,$tags, $outlets);
			//echo '<pre>'; print_r($posts);echo '</pre>'; die;
			if(!empty($posts))
			{
				if($type == 'PDF')
				{
					if(!empty($posts))
					{
						ob_start();
						$this->data['brand_id'] = $brand_id;
						$this->data['post_details'] = $posts;
						$this->data['start_date'] = $daterange['start_date'];
						$this->data['end_date'] = $daterange['end_date'];
						//$this->load->view('archives/pdf_export', $this->data);
						$file_name = $daterange['start_date']."To".$daterange['end_date'].'.pdf';
						$html = $this->load->view('archives/pdf_export', $this->data, true);
						$this->pdf_create( $html,$file_name);
						ob_end_flush();
					}
					
				}
				else if($type == 'CSV')
				{
					if(!empty($daterange['start_date']) && !empty($daterange['end_date']))
					{
						$posts = object_to_array($posts);
						$file_name = $daterange['start_date']."To".$daterange['end_date'].'.csv';
						$this->outputCSV($posts,$file_name);
					}
				}
				
			}
			else
			{
				if($slug != '_no'){
					$this->session->set_flashdata('message', 'No result found.');
					redirect(base_url().'archives/'.$slug);					
				}
			}
		}
		else
		{
			if($slug != '_no'){
				redirect(base_url().'archives/'.$slug);
			}
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
            // fputcsv($output, $row); // here you can change delimiter/enclosure
            $temp['id']	= (!empty($row['id']))? $row['id'] : '';
			$temp['content'] = (!empty($row['content']))? $row['content'] : ''; 	
			$temp['name']	= (!empty($row['name']))? $row['name'] : '';
			$temp['slate_date_time'] = !empty($row['slate_date_time'])? $row['slate_date_time'] : '';
			$temp['status']	= !empty($row['status'])? $row['status'] : '';
			$temp['user'] = !empty($row['user'])? $row['user'] : '';
			$temp['outlet_name'] = !empty($row['outlet_name'])? $row['outlet_name'] : '';
			$temp['created_at']	= !empty($row['created_at'])? $row['created_at'] : '';
			$temp['media'] = !empty($row['media'])? $row['media'] : '';
			$temp['post_tags'] = !empty($row['post_tags'])? $row['post_tags'] : '';
			fputcsv($output, $temp);
    	}
        
        # Close the stream off
        //fclose($output);
    }

    function pdf_create( $html, $filename, $output_type = 'stream' )
    {
    	try {
	    	// Remove all previously created headers if streaming output
	    	if( $output_type == 'stream' )
	    	{
	    		header_remove();
	    	}
	    	// Load dompdf and create object
	    	
	    	$options = new Options();
	    	$options->set('isRemoteEnabled', TRUE);
	    	
	    	$options->set('isJavascriptEnabled', TRUE);
		    $dompdf = new Dompdf($options);
		    
		    // Loads an HTML string

	        $dompdf->loadHtml( $html,'UTF-8' );


		    // Create the PDF
		    $dompdf->render();

		   // $dompdf->set_base_path( css_url().'/style.css');

		    // If destination is the browser
		    if( $output_type == 'stream' )
		    {
		    	// $dompdf->stream($filename);
		    	// 0 = open in tab, 1 = download pdf file
		    	$dompdf->stream($filename, array('Attachment'=>1));
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
	    } catch (Exception $e){
	    	echo $e;
		  // echo '<pre>'; print_r($e);echo '</pre>'; 
		}
	}

}