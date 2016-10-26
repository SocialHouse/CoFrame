<?php if ( ! defined("BASEPATH")) exit("");

class Transaction_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = 'transactions';
	}

	//get brands which is created by user
	public function get_last_transaction($user_id)
    {
        $this->db->select('card_id,current_period_end');
        $this->db->order_by('id','DESC');
        $query = $this->db->get_where($this->table,array('user_id'=>$user_id));
        if($query->num_rows() > 0)
        {
            return $query->row();
        }
        return FALSE;
    }
	
}