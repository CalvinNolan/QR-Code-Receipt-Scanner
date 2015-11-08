<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Calvin Nolan & Tomas Barry */

class Home extends CI_Controller {
	public function index()
	{
		$this->homepage();
	}

	public function homepage() {
		$this->load->model('AIB_model');
		$all_data = $this->AIB_model->get_data();
		$pie_slices = [];
		$location_slices = [];
		$data['total'] = 0;
		$data_by_month = [];

		foreach($all_data as $piece) {
			if(isset($pie_slices[$piece['item_type']])) {
				$pie_slices[$piece['item_type']]['value'] += $piece['value'];
				$data['total'] += $piece['value'];
			} else {
				$pie_slices[$piece['item_type']]['value'] = $piece['value'];
				$pie_slices[$piece['item_type']]['type'] = $piece['item_type'];
				$data['total'] += $piece['value'];
			}

			if(isset($location_slices[$piece['location_bought']])) {
				$location_slices[$piece['location_bought']]['value'] += $piece['value'];
			} else {
				$location_slices[$piece['location_bought']]['value'] = $piece['value'];
				$location_slices[$piece['location_bought']]['location_bought'] = $piece['location_bought'];
			}

			if(isset($data_by_month[date('m/Y', $piece['time'])])) {
				$length = count($data_by_month[date('m/Y', $piece['time'])]);
				$data_by_month[date('m/Y', $piece['time'])][$length] = $piece;
				$data_by_month[date('m/Y', $piece['time'])]['total'] += $piece['value'];
			} else {
				$data_by_month[date('m/Y', $piece['time'])][0] = $piece;
				$data_by_month[date('m/Y', $piece['time'])]['total'] = $piece['value'];
				$data_by_month[date('m/Y', $piece['time'])]['month'] = date('m/Y', $piece['time']);

			}
		}

		$largestTypeValue = 0;
		$largestType = "";
		foreach($pie_slices as $slice) {
			if($slice['value'] > $largestTypeValue) {
				$largestTypeValue = $slice['value'];
				$largestType = $slice['type'];
			}
		}

		$largestLocationValue = 0;
		$largestLocation = "";
		foreach($location_slices as $slice) {
			if($slice['value'] > $largestLocationValue) {
				$largestLocationValue = $slice['value'];
				$largestLocation = $slice['location_bought'];
			}
		}

		$largestMonthValue = 0;
		$largestMonth = "";
		foreach($data_by_month as $month) {
			if($month['total'] > $largestMonthValue) {
				$largestMonthValue = $month['total'];
				$largestMonth = $month['month'];
			}
		}

		$data['largestMonth'] = $largestMonth;
		$data['largestMonthValue'] = $largestMonthValue;
		$data['monthly'] = $data_by_month;
		$data['largestLocation'] = $largestLocation;
		$data['largestType'] = $largestType;
		$data['pie'] = $pie_slices;
		$data['transactions'] = $all_data;
		$this->load->view('home', $data);
	}

	public function test() {
		$this->load->view('welcome_message');
	}

	public function update() {
		$this->load->model('AIB_model');
		$segments = $this->uri->segment_array();
		$data['head'] = "Test page for updating";

		if(count($segments) > 3) {
			$time = explode("=", $segments[3]);
			$time = $time[1];

			$location = explode("=", $segments[4]);
			$location = $location[1];

			$currency = explode("=", $segments[5]);
			$currency = $currency[1];

			$items = array_slice($segments, 5);
			$i = 0;
			foreach($items as $item) {
				$item_data = explode("=", $item);
				$item_type = $item_data[0];
				$item_value = $item_data[1];

				$this->AIB_model->add_item((int) $time, $location, $currency, $item_type, (float) $item_value);

				$i++;
			}
		}
		
		redirect('/home');
	}
}
?>
