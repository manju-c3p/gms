<?php
class ServiceHistory extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ServiceHistory_model');
			$this->load->model('Customer_model');
		$this->load->model('Vehicle_model');
		
    }
	public function index()
	{
		$search = $this->input->get('search');

		$data['customers'] = $this->Customer_model->get_all_customers($search);

		$data['title'] = "Customers";
		$data['main_content'] = 'customer/list_customers_history';
		$this->load->view('includes/template', $data);
	}


    // ✅ Customer Service History
    public function customer($customer_id)
    {
        $data['history'] = $this->ServiceHistory_model
                                ->get_customer_history($customer_id);

								$data['title'] = "Customers Service History";
		$data['main_content'] = 'customer/customer_history';
		$this->load->view('includes/template', $data);

    }

		public function vehiclelist()
	{
		$this->load->model('Vehicle_model');

		$data['rows'] = $this->Vehicle_model->get_all_flat();
		$data['customers'] = $this->Customer_model->get_all_customers($search);


		$data['title'] = "Vehicles";
		$data['main_content'] = 'vehicle/vehicle_service_list';

		$this->load->view('includes/template', $data);
	}

    // ✅ Vehicle Service History
    public function vehicle($vehicle_id)
    {
        $data['history'] = $this->ServiceHistory_model
                                ->get_vehicle_history($vehicle_id);

        $this->load->view('history/vehicle_history', $data);
    }
}
