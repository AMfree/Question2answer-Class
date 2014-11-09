<?php
require("Q2AGRAB.php");
$kingofseo=new q2a(["site" => "http://www.question2answer.org/qa", "page" => "1"]);

/**
List the recent questions if you would like to change the order change the recent from the array element.
print_r( $kingofseo->list_questions("recent", true) );
**/

/**
Get the answer(s) from the question
print_r(
$kingofseo->list_answers("http://www.question2answer.org/qa/24331/new-plugin-advanced-tag-descriptions-plugin")
);
**/
