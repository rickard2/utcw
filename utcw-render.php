<?php

class UTCW_Render {

	private $data;

	public function __construct( UTCW_Config $config, UTCW_Data $data )
	{
		$this->data   = $data;
		$this->config = $config;
	}

	public function render()
	{
		echo $this->get_cloud();
	}

	public function get_cloud()
	{
		return 'Placeholder';
	}
}