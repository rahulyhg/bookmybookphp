<?php
include ('/opt/lampp/htdocs/bmb/log4php/Logger.php');

Logger::configure('/opt/lampp/htdocs/bmb/configurationlogging.xml');

class Something
{
	private $log;

	public function _construct()
	{
		$this->log = Logger::getLogger(_CLASS_);
	}

	public function run()
	{
		$this->log->info("test logger 1");
	}
}

$ob = new Something();
$ob->run();

?>