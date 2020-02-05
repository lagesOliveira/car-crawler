<?php

defined('BASEPATH') or exit('No direct script access allowed');

// URl DE BUSCAS
define('SITE_GET', 'https://seminovos.com.br/');

class Api extends CI_Controller
{

	public function getDestaques()
	{
		// Get the last 10 cars on home page
		$site_url = SITE_GET;

		$micro_data = new \Malenki\Microdata($site_url);
		echo $micro_data;
	}

	public function getCars($orderBy = '2', $perPage = '20')
	{
		/*
		* Order results by:
		*	2 - Maior Relevância
		*	3 - Maior Preço
		*	4 - Menor Preço
		*	5 - Mais Novo
		*	6 - Mais Antigo
		*
		* Default is 2.
		*
		* Items per page 20, 30, 40 or 50.
		* Default is 20.
		*/

		if ($perPage > 50)
			$perPage = 50;

		$site_url = SITE_GET . 'carro?ordenarPor=' . $orderBy . '&registrosPagina=' . $perPage;

		$micro_data = new \Malenki\Microdata($site_url);
		echo $micro_data;
	}


	public function getByCode($productID)
	{

		$site_url = SITE_GET . $productID;
		$micro_data = new \Malenki\Microdata($site_url);

		/*
		  Get object array of produtct item selected and anothers of similar price
		  The first item of array is the product selected by productID
		*/

		$carDetails  = $micro_data->extract()->items;

		// Show details only of selected product
		echo json_encode($carDetails[0]);
	}

	public function searchBy()
	{
		/*
		* Search cars by params given on URI
		*/

		// Get the URI params
		$search_params = $this->uri->segment_array();

		// Exclude 'crawler' and 'searchby' from URI
		unset($search_params[1]);
		unset($search_params[2]);

		$link_params = '';

		foreach ($search_params as $param) {
			$link_params =  $link_params . '/' . $param;
		}

		$site_url = SITE_GET . 'carro' . $link_params;

		$micro_data = new \Malenki\Microdata($site_url);

		echo $micro_data;
	}
}
