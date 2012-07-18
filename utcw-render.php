<?php

class UTCW_Render {

	private $data;

	public function __construct( UTCW_Data $data )
	{
		$this->data = $data;
	}

	public function render()
	{
		echo $this->get_cloud();
	}

	public function get_cloud() {

	}
}