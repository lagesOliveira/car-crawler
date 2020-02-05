<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Symfony\Component\DomCrawler\Crawler;

// URl DE BUSCAS
define('SITE_GET', 'https://seminovos.com.br/');

class Api extends CI_Controller
{
	public function index()
	{
		echo "Nothing here! See https://github.com/lagesOliveira/car-crawler";
	}

	public function getDestaques()
	{

		// Verify the verb
		if (is_get()) {

			// Get the last 10 cars on home page
			$site_url = SITE_GET;

			$micro_data = new \Malenki\Microdata($site_url);

			$this->output
				->set_status_header(200)
				->set_content_type('application/json', 'utf-8')
				->set_output($micro_data)
				->_display();
			exit;
		}
	}

	public function getCars($orderBy = '2', $perPage = '20')
	{
		if (is_get()) {
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

			$this->output
				->set_status_header(200)
				->set_content_type('application/json', 'utf-8')
				->set_output($micro_data)
				->_display();
			exit;
		}
	}


	public function getByCode($productID)
	{
		if (is_get()) {

			$site_url = SITE_GET . $productID;
			$micro_data = new \Malenki\Microdata($site_url);

			/*
		 	 * Get object array of produtct item selected and anothers of similar price
			 * The first item of array is the product selected by productID
			*/

			$car_details  = $micro_data->extract();

			if ($car_details->count < 1) {
				$this->output
					->set_status_header(204)
					->set_content_type('application/json', 'utf-8')
					->_display();
				exit;
			} else {
				$this->output
					->set_status_header(200)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($car_details->items[0]))
					->_display();
				exit;
			}
		}
	}

	public function searchBy()
	{
		if (is_get()) {
			/*
			* Search cars by params given on URI
			*/

			// Get the URI params
			$search_params = $this->uri->segment_array();

			// Prepare url to search
			$site_url = $this->uri_prepare($search_params);

			// Checks for search results
			$have_cars = $this->has_results($this->html_page($site_url));

			if ($have_cars) {
				$micro_data = new \Malenki\Microdata($site_url);
				$this->output
					->set_status_header(200)
					->set_content_type('application/json', 'utf-8')
					->set_output($micro_data)
					->_display();
				exit;
			}
			else {
				$this->output
				->set_status_header(204)
				->set_content_type('application/json', 'utf-8')
				->_display();
			}
		}
	}

	function uri_prepare($search_params)
	{
		// Exclude 'crawler' and 'searchby' from URI
		unset($search_params[1]);
		unset($search_params[2]);

		$link_params = '';

		foreach ($search_params as $param) {
			$link_params =  $link_params . '/' . $param;
		}

		$search_uri = SITE_GET . 'carro' . $link_params;

		return $search_uri;
	}

	function html_page($search_uri)
	{
		$client = new \GuzzleHttp\Client();
		$response = $client->request('GET', $search_uri);
		$html =  $response->getBody();
		return $html;
	}

	function has_results($html)
	{
		$crawler = new Crawler();
		$crawler->addHtmlContent($html);

		// If the search no return results, on the page will has a div with class "nenhum-resultado". Yes, i'm not typing wrong :)

		// If div presents, the text is found "Nenhum veículo encontrado Confira outros veículos na mesma categoria conforme seu critério de busca."
		$result = $crawler->filter('div.nenhum-reseultado')->text(false);

		if ($result) {
			// Div is present, no have results
			return false;
		} else {
			return true;
		}
	}
}
