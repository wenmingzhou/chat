<?php
namespace app\index\controller;

class Hello
{
    public function index()
    {
    	
    	echo "Hello";
    }
    
  
    
    public function hello($name="world",$city="nanjing")
    {
    	
    	echo "Hello 2 ".$name.",I from ".$city;
    }
}
