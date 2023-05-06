<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {
  
    /**
     * CONSTRUCTOR | LOAD DB
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }

    /**
     * SHOW | GET method.
     *
     * @return Response
    */
	public function show($id = 0)
	{
        if(!empty($id)){
            $query = $this->db->get_where("products", ['id' => $id])->row_array();
        }else{
            $query = $this->db->get("products")->result();
        }
        return $query;
	}

    public function showItem($id = 0, $idItem = 0)
	{
        $this->db->select('a.name as nameChecklist, b.id as itemId, b.name');
        $this->db->from('products a');
        $this->db->join('product_items b', 'a.id = b.id_product');
        $this->db->where('b.id =', $idItem);
        $query = $this->db->get()->result();
        return $query;
	}
      
    /**
     * INSERT | POST method.
     *
     * @return Response
    */
    public function insert($data)
    {
        $this->db->insert('products',$data);
        return $this->db->insert_id(); 
    } 
     
    /**
     * UPDATE | PUT method.
     *
     * @return Response
    */
    public function update($data, $id)
    {
        $data = $this->db->update('products', $data, array('id'=>$id));
        //echo $this->db->last_query();
		return $this->db->affected_rows();
    }
     
    /**
     * DELETE method.
     *
     * @return Response
    */
    public function delete($id)
    {
        $this->db->delete('products', array('id'=>$id));
        return $this->db->affected_rows();
    }
}
