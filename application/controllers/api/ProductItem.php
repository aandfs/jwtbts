<?php

//Dipake untuk checklist
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;
     
class ProductItem extends REST_Controller {
    
	  /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->library('Authorization_Token');	
       $this->load->model('Product_model');
    }
       
    /**
     * SHOW | GET method.
     *
     * @return Response
    */
	public function index_get($id = 0, $idItem = 0)
	{
        $headers = $this->input->request_headers(); 
        if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status'])
            {
                
                // ------- Main Logic part -------
                if(empty($id) || empty($idItem)){
                    $this->response(['Butuh Id Checklist dan Id Item'], REST_Controller::HTTP_OK);
                } else {
                    $data = $this->Product_model->showItem($id, $idItem);

                    if(!$data){
                        $this->response(['data tidak ditemukan'], REST_Controller::HTTP_OK);
                    }
                }
                $this->response($data, REST_Controller::HTTP_OK);
                // ------------- End -------------
            } 
            else {
                $this->response($decodedToken);
            }
        } else {
            $this->response(['Authentication failed'], REST_Controller::HTTP_OK);
        }
	}
      
    /**
     * INSERT | POST method.
     *
     * @return Response
    */
    public function index_post()
    {
        $headers = $this->input->request_headers(); 
		if (isset($headers['Authorization'])) {
			$decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status'])
            {
                // ------- Main Logic part -------
                $input = $this->input->post();
                $data = $this->Product_model->insert($input);
        
                $this->response(['Checklist created successfully.'], REST_Controller::HTTP_OK);
                // ------------- End -------------
            }
            else {
                $this->response($decodedToken);
            }
		}
		else {
			$this->response(['Authentication failed'], REST_Controller::HTTP_OK);
		}
    } 
     
    /**
     * UPDATE | PUT method.
     *
     * @return Response
    */
    public function index_put($id)
    {
        $headers = $this->input->request_headers(); 
		if (isset($headers['Authorization'])) {
			$decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status'])
            {
                // ------- Main Logic part -------
                // $input = $this->put();
                $headers = $this->input->request_headers(); 
                $data['name'] = $headers['name'];
                $data['price'] = $headers['price'];
                $response = $this->Product_model->update($data, $id);

                $response>0?$this->response(['Product updated successfully.'], REST_Controller::HTTP_OK):$this->response(['Not updated'], REST_Controller::HTTP_OK);
                // ------------- End -------------
            }
            else {
                $this->response($decodedToken);
            }
		}
		else {
			$this->response(['Authentication failed'], REST_Controller::HTTP_OK);
		}
    }
     
    /**
     * DELETE method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        
        $headers = $this->input->request_headers(); 
		if (isset($headers['Authorization'])) {
			$decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status'])
            {
                // ------- Main Logic part -------
                $response = $this->Product_model->delete($id);

                $response>0?$this->response(['Checklist deleted successfully.'], REST_Controller::HTTP_OK):$this->response(['Not deleted'], REST_Controller::HTTP_OK);
                // ------------- End -------------
            }
            else {
                $this->response($decodedToken);
            }
		}
		else {
			$this->response(['Authentication failed'], REST_Controller::HTTP_OK);
		}
    }
    	
}