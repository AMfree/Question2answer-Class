<?php
/**
@author (Developed by) : Ugurkan (Kingofseo)
@date     : 09.11.2014
@updated  : 21.11.2014 Friday
List questions with the answers powered by Question2answer should work with all with no much at all big changes on the theme.
**/

Class q2a 
{
protected $_config=null;
public $_uri_routes=
[
"recent"      => "/questions",
"popular"     => "/hot",
"unanswered"  => "/unanswered"
];
protected $_page=null;
protected $_answer_page=null;

const _CODER="Ugurkan";
const _DATE="21112014";

/**
Build the __construct()
**/

public function __construct(array $_config)
{
$this->_config=$_config;
//$this->_config=array_map("trim", array_values($this->_config) );//
foreach($this->_config as $key => $value)
{
if(empty($this->_config[$key]) || is_null($this->_config[$key]) )
{
throw new Exception("Please make sure that all variables not null or empty.");
}
}
$this->_page=$this->_config["page"]*20-20;
if(self::_CODER!="Ugurkan") throw new Exception("Just respect my kind of work.");
}

/**
List all questions
**/

public function list_questions($order, $clean_html=false)
{
$get_questions=file_get_contents($this->_config["site"]."/".$this->_uri_routes[$order]."?start=".$this->_page);
if(false==$get_questions)
{
return false;
}
if(!in_array($order, array_keys($this->_uri_routes) ) )
{
return false;	
}
preg_match_all('@<div class="qa-q-item-title">(.*?)</div>@si',$get_questions, $question_item);
$contents_array=array();
if($question_item[0] && count($question_item[0]) > 0)
{
for($i=0; $i<count($question_item[0]); $i++)
{
preg_match_all('@<a href="(.*?)"><span title="(.*?)">(.*?)</span></a>@si',$question_item[0][$i], $a_details);
$a_details[1][0]=str_replace("./", $this->_config["site"]."/", $a_details[1][0]);
$get_question_data=file_get_contents($a_details[1][0]);
preg_match_all('@<div class="entry-content">(.*?)</div>@si',$get_question_data, $get_content);
$get_content[1][0]=trim($get_content[1][0]);
$get_content[1][0]=preg_replace("/\s+/"," ", $get_content[1][0]);
if($clean_html) $get_content[1][0]=strip_tags($get_content[1][0]);

$contents_array["ugurkan"][]=array(
"url"      => $a_details[1][0],
"title"    => $a_details[3][0],
"question" => $get_content[1][0]
);
}
$contents_array["ugurkan"]["count"]=count($question_item[0]);
}else
{
return false;	
}
return (array) $contents_array;
}

/**
Get the answer(s) from the question and return as array.
**/

public function list_answers($url, $page=1)
{
$this->_answer_page=$page*12-12;
if(empty($url) || $page<=0 )
{
return false;
}
$qa_params=$page!=1 ? "?start={$this->_answer_page}" : null;
if($qa_content=file_get_contents($url.$qa_params) )
{
preg_match_all('@<div class="qa-a-item-content">(.*?)</div>@si',$qa_content, $list_items);
$ugurkan_array=array();
if($list_items[0] && count($list_items[0]) > 0)
{
for($u=0; $u<count($list_items[0]); $u++)
{
preg_match_all('@<div class="entry-content">(.*?)</div>@si', $list_items[0][$u], $answer_content);
$answer_content[1][0]=strip_tags($answer_content[1][0]);
$ugurkan_array["data"][]=
[
"answers" => $answer_content[1][0]
];
}
}else
{
return false;	
}

}else
{
return false;	
}
return (array) $ugurkan_array["data"];
}

}
