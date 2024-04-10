<?php
/**
 * Created by PhpStorm.
 * User: Lexy
 * Date: 25/03/2017
 * Time: 12:57 PM
 */


class NumberFormat{

     private $numbers;
     private $arr = array();

	public function __construct($numbers)
	{
		$this->numbers = $numbers;
	}

    private function multiExplode($delimiters)
	{
        $ready = str_replace($delimiters, $delimiters[0], $this->numbers);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }

    private function addCountryCode()
	{
		$exploded = $this->multiExplode(array(",","\n","\s\n",".",", "," ","&nbsp;","\t"));
		for($i = 0; $i < count($exploded); $i++)
		{
			$position = "/^0/";
			$replaceText = 234;
			$removedZero = preg_replace($position, $replaceText, $exploded[$i]);
			// $removedZero = substr($exploded[$i], 1);
			// $addedCountryCode = "234" . $removedZero;
			$addedCountryCode = $removedZero;
			array_push($this->arr, $addedCountryCode);
		}
    }

    public function finalResult()
	{
        $this->addCountryCode();
        $result = implode(",",array_unique($this->arr));
        return $result;
    }
}

