<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 */
class Auth_model extends MY_Model
{


	function __construct()
	{
		$this->table = 'users';
		$this->primary_key = 'user_id';
	}

	//users
	public function addUser($data)
	{
		$this->table = 'users';
		return $this->store($data);
	}
	public function getUserData($param = null, $many = FALSE)
	{
		$this->table = 'users';
		if ($param != null && $many == FALSE) {
			return $this->get_one($param);
			//return $this->db->last_query();
		} elseif ($param != null && $many == TRUE) {
			return $this->get_many($param, $order_by = 'user_id', $order = 'DESC', FALSE);
		} else {
			return $this->get_many();
		}
	}


	public function updateUser($data, $param)
	{
		$this->table = 'users';
		return $this->modify($data, $param);
	}
	public function delUser($param)
	{
		$this->table = 'users';
		return $this->remove($param);
	}

	public function getAllCategory()
	{
		//return $this->db->get('category')->result_array();

		$this->db->from('category');
		//$this->db->where('status','1');
		$this->db->order_by("category_name", "asc");
		$query = $this->db->get(); 
		return $query->result_array();
	}

	public function getCategoryData($param = null, $many = FALSE)
	{
		$this->table = 'category';
		if ($param != null && $many == FALSE) {
			return $this->get_one($param);
			//echo $this->db->last_query();
		} elseif ($param != null && $many == TRUE) {
			return $this->get_many($param, $order_by = 'category_name', $order = 'ASC', FALSE);
		} else {
			return $this->get_many();
		}
	}

	public function addCategory($data)
	{
		$this->table = 'category';
		return $this->store($data);
	}

	public function updateCategory($data, $param)
	{
		$this->table = 'category';
		return $this->modify($data, $param);
	}

	public function deleteCategory($param)
	{
		$this->table = 'category';
		return $this->remove($param);
	}

	public function search_category($param = null, $param_like = null, $many = FALSE, $order = 'ASC', $order_by = 'category_name')
	{

		$this->db->select('*');

		if ($param != null) {
			$this->db->where($param);
		}

		if ($param_like != null) {
			$this->db->where("category_name LIKE '%" . $param_like."%'");
		}

		$this->db->order_by($order_by, $order);

		$query = $this->db->get('category');
		 //echo $this->db->last_query();die;

		if ($many != TRUE) {
			return $query->row();
		} else {
			return $query->result();
		}
	}


	public function getAllDisease()
	{
		return $this->db->get('disease')->result_array();
	}

	public function getDiseaseData($param = null, $many = FALSE)
	{
		$this->table = 'disease';
		if ($param != null && $many == FALSE) {
			return $this->get_one($param);
		} elseif ($param != null && $many == TRUE) {
			return $this->get_many($param, $order_by = 'id', $order = 'DESC', FALSE);
		} else {
			return $this->get_many();
		}
	}

	public function addDisease($data)
	{
		$this->table = 'disease';
		return $this->store($data);
	}

	public function updateDisease($data, $param)
	{
		$this->table = 'disease';
		return $this->modify($data, $param);
	}

	public function deleteDisease($param)
	{
		$this->table = 'disease';
		return $this->remove($param);
	}

	public function search_disease($param = null, $param_like = null, $many = FALSE, $order = 'DESC', $order_by = 'id')
	{

		$this->db->select('*');

		if ($param != null) {
			$this->db->where($param);
		}


		if ($param_like != null) {
			$this->db->where("disease_name LIKE '%" . $param_like."%'");
		}

		$this->db->order_by($order_by, $order);

		$query = $this->db->get('disease');
		 //echo $this->db->last_query();die;

		if ($many != TRUE) {
			return $query->row();
		} else {
			return $query->result();
		}
	}

	public function getAllDiseaseSols()
	{
		return $this->db->get('disease_solutions')->result_array();
	}

	public function addDiseaseSol($data)
	{
		$this->table = 'disease_solutions';
		return $this->store($data);
	}

	public function getDiseaseSolData($param = null, $many = FALSE)
	{
		$this->table = 'disease_solutions';
		if ($param != null && $many == FALSE) {
			return $this->get_one($param);
		} elseif ($param != null && $many == TRUE) {
			return $this->get_many($param, $order_by = 'id', $order = 'DESC', FALSE);
		} else {
			return $this->get_many();
		}
	}

	public function updateDiseaseSol($data, $param)
	{
		$this->table = 'disease_solutions';
		return $this->modify($data, $param);
	}


	public function deleteDiseaseSol($param)
	{
		$this->table = 'disease_solutions';
		return $this->remove($param);
	}

	public function search_disease_sol($param = null, $param_like = null, $many = FALSE, $order = 'DESC', $order_by = 'id')
	{

		$this->db->select('*');

		if ($param != null) {
			$this->db->where($param);
		}


		if ($param_like != null) {
			$this->db->where("solutions LIKE '%" . $param_like."%'");
		}

		$this->db->order_by($order_by, $order);

		$query = $this->db->get('disease_solutions');
		 //echo $this->db->last_query();die;

		if ($many != TRUE) {
			return $query->row();
		} else {
			return $query->result();
		}
	}

	public function getAllChart()
	{
		return $this->db->get('chart')->result_array();
	}

	public function getChartData($param = null, $many = FALSE)
	{
		$this->table = 'chart';
		if ($param != null && $many == FALSE) {
			return $this->get_one($param);
		} elseif ($param != null && $many == TRUE) {
			return $this->get_many($param, $order_by = 'chart', $order = 'ASC', FALSE);
		} else {
			return $this->get_many();
		}
	}

	public function addChart($data)
	{
		$this->table = 'chart';
		return $this->store($data);
	}

	public function updateChart($data, $param)
	{
		$this->table = 'chart';
		return $this->modify($data, $param);
	}

	public function deleteChart($param)
	{
		$this->table = 'chart';
		return $this->remove($param);
	}

	public function addChartProtocol($data)
	{
		$this->table = 'chart_details';
		return $this->store($data);
	}

	/*public function updateChart($data, $param)
	{
		$this->table = 'chart';
		return $this->modify($data, $param);
	}*/

	public function getChartProtocoldetails($param = null, $many = FALSE)
	{
		$this->table = 'chart_details';
		if ($param != null && $many == FALSE) {
			return $this->get_one($param);
		} elseif ($param != null && $many == TRUE) {
			return $this->get_many($param, $order_by = 'id', $order = 'DESC', FALSE);
		} else {
			return $this->get_many();
		}
	}

	public function deleteChartProtocol($param)
	{
		$this->table = 'chart_details';
		return $this->remove($param);
	}

	public function search_chart($param = null, $param_like = null, $many = FALSE, $order = 'ASC', $order_by = 'chart')
	{

		$this->db->select('*');

		if ($param != null) {
			$this->db->where($param);
		}

		if ($param_like != null) {
			$this->db->where("chart LIKE '%" . $param_like."%'");
		}

		$this->db->order_by($order_by, $order);

		$query = $this->db->get('chart');
		 //echo $this->db->last_query();die;

		if ($many != TRUE) {
			return $query->row();
		} else {
			return $query->result();
		}
	}

	public function getChartProtocolData($param = null, $many = FALSE)
	{
		$this->table = 'chart_details';
		if ($param != null && $many == FALSE) {
			return $this->get_one($param);
		} elseif ($param != null && $many == TRUE) {
			return $this->get_many($param, $order_by = 'id', $order = 'DESC', FALSE);
		} else {
			return $this->get_many();
		}
	}

	public function search_chart_protocol($param = null, $param_like = null, $many = FALSE, $order = 'DESC', $order_by = 'id')
	{
		$this->db->select('*');

		if ($param != null) {
			$this->db->where($param);
		}

		if ($param_like != null) {
			$this->db->where("protocol_name LIKE '%" . $param_like."%'");
		}

		$this->db->order_by($order_by, $order);

		$query = $this->db->get('chart_details');
		 //echo $this->db->last_query();die;

		if ($many != TRUE) {
			return $query->row();
		} else {
			return $query->result();
		}
	}



	public function getAllSubCategory()
	{
		//return $this->db->get('category')->result_array();

		$this->db->from('sub_category');
		$this->db->where('status','1');
		$this->db->order_by("sub_category", "asc");
		$query = $this->db->get(); 
		return $query->result_array();
	}

	public function getSubCategoryData($param = null, $many = FALSE)
	{
		$this->table = 'sub_category';
		if ($param != null && $many == FALSE) {
			return $this->get_one($param);
			//echo $this->db->last_query();
		} elseif ($param != null && $many == TRUE) {
			return $this->get_many($param, $order_by = 'id', $order = 'DESC', FALSE);
		} else {
			return $this->get_many();
		}
	}

	public function addSubCategory($data)
	{
		$this->table = 'sub_category';
		return $this->store($data);
	}

	public function updateSubCategory($data, $param)
	{
		$this->table = 'sub_category';
		return $this->modify($data, $param);
	}

	public function deleteSubCategory($param)
	{
		$this->table = 'sub_category';
		return $this->remove($param);
	}

	public function search_sub_category($param = null, $param_like = null, $many = FALSE, $order = 'DESC', $order_by = 'id')
	{

		$this->db->select('*');

		if ($param != null) {
			$this->db->where($param);
		}

		if ($param_like != null) {
			$this->db->where("sub_category LIKE '%" . $param_like."%'");
		}

		$this->db->order_by($order_by, $order);

		$query = $this->db->get('sub_category');
		 //echo $this->db->last_query();die;

		if ($many != TRUE) {
			return $query->row();
		} else {
			return $query->result();
		}
	}
}
