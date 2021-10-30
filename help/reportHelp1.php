<!doctype HTML>
<?php
// View Clinics
// Show clinics and associated facilities
// Nik Rubenstein 12-10-2014
$SECURE = TRUE;
require("../inc/init.php");
?>
<html>
<head>
<title> Report Generation Wizard</title>
<?php
require("{$legos}/head.php");
?>
<style>
#toc{
	text-align:left;
	background-color:#dddddd;
	width:30%;
	float:left;
	border-right: 1px solid #000000;
	padding:10px 0px;

}
#toc ul{
	margin:0;
	list-style-type:none;
	padding:0px 10px;
}
#toc li{
	padding-left:10px;
	list-style:none;
	text-indent:none;
}

#toc li ul li:hover{
	background-color:#333333;
	color:#FFFFFF;
}

#toc h3{
text-align:center;
font-size:1.5em;
margin:0;
}

#content{
float:left;
width:60%;
margin-left:-1px;
border-left: 1px solid #000000;
//background-color:#DDDDFF;
padding:20px;
text-align:left;
}

#content img{
border: 2px solid #000000;
width:100%;
}

#content h1{
text-align:center;
font-size:2em;
margin:0;
text-transform:uppercase;
color:#222222;
}
#content h3{
/*text-align:center;*/
font-size:1.3em;
margin:0;
text-transform:uppercase;
color:#222222;
}
#content h4{
/*text-align:center;*/
font-size:1.1em;
margin:0;
text-transform:uppercase;
color:#222222;
}
#content h5{
/*text-align:center;*/
font-size:1.0em;
margin:0;
text-transform:uppercase;
color:#222222;
}

#content p{
text-indent:40px;
}
.docTitle{
	font-size:2em;
	font-weight:bold;
}
.hideMe{
	display:none;
}

.hovCh:hover{
	background-color:#000000;
	color:#FFFFFF;
}
</style>
</head>
<body onload = 'loadContent("new");'>
<!--
////////////////////////////////////////////////
////////////////////////////////////////////////
//////////////////  Contents  //////////////////
////////////////////////////////////////////////
//////////////////////////////////////////////// 
-->
<div id = 'new' class = 'hideMe'>
	<h1> Creating A New report </h1>
	<p>
	The report creater can summon and match almost any data types within the database, and compile them in to an easily exporatble form. Creating a new report is done using a 5 step wizard outlined below, and described in detail in the following sections of this document.
	</p>
	<h3> Step 1: Selecting a primary table</h3>
	<p>
	During this step the user will be asked to select a primary table from a list of possibilites. 
	</p>
	<h3> Step 2: Including fields from your primary table</h3>
	<p>
	During this step theuser will select which fields from the primary table to include in the report, and what "friendly name" to give to the resulting column name. 
	</p>
	<h3> Step 3: Selecting filter options</h3>
	<p>
	During this step theuser will select fitering options to run against the selected primary table, select which variable filter options will be asked for when the report is run.
	</p>
	<h3> Step 4: Replacing fields with related data</h3>
	<p>
	During this step theuser will choose one or more fields from related data sets not contained in the primary table to "swap" for key pointers in the primary table.
	</p>
	<h3> Step 5: Saving your report</h3>
	<p>
	During this step theuser will name the report and set permissions for others to use it.
	</p>
</div>
<!-- ////////////////////////////////////// -->
<!-- ////////////////////////////////////// -->
<!-- ////////////////////////////////////// -->
<div id = 'new1' class = 'hideMe'>
	<h3> Step 1: Selecting a primary table</h3>
	<img src = '../img/report1-1.png'>
	<p>
	In Step 1 the user will be asked to select a "Primary table" for use in the report being generated. A primary table can be thought of as the "main focus" of the report. Thus if the user is interested in retreiving patient data, they would select "patients" as the primary table.
	</p>
	<p>
	The user is presented with a list of available tables in the database. Upon clicking the button for a given table, information about the selected table is displayed to the right of the tables list. This information is given so that the user may be sure they are selecting the correct primary table to use in the generated report. The information panel is non-interactive, and is for information purposes only. 
	</p>  
	<p>
	To the right of the information area, is a text box labeled "Selected Table" This is the currently selected primary table, and the table that will be chosen when the user clicks the "NEXT" button located beneath text box.
	</p>
	<p>
	Once the primary table has been selected, simply click the "NEXT" button to move on to Step 2: Including fields from your primary table.
	</p>
	<hr>
	
</div>
<!-- ////////////////////////////////////// -->
<!-- ////////////////////////////////////// -->
<!-- ////////////////////////////////////// -->
<div id = 'new2' class = 'hideMe'>
	<h3> Step 2:  Including fields from your primary table</h3>
	<img src = '../img/report1-2.png'>
	<p>
	In Step 1 the user was asked to select a "Primary table" for use in the report being generated. In Step 2, the user will be asked which fields from the primary table to include in the report, and what "friendly name" they would like to give to those fields in the report output.
	</p>
	<p>
	A friendly name is a more "human readable" name of a field in the table. For example the database may contain a field called "addr_zip", and the user may wish to have that appear in the report as "Zip Code". Where possible, friendly names have been auto-generated and placed in the Friendly Name column of the "Include These Fields" table shown on the left of the screen in Step 2. To select a different friendly name, simply type the new name in the corresponding frienly name text box <b><i>before</b></i> clicking the "ADD" button. 
	</p>
	<p>
	In many cases, not all data from a given table is needed for a report, as such, the user may elect to include some, or all of the fields from the primary table during this step. To include a field in the report, assign a friendly name to the field (or keep the default friendly name) and click the "ADD" button. Once clicked, a verbal readout of the request will be displayed to the right of the "Include These Fields" table, and the "ADD" button will be replaced by a "REMOVE" button. If you do not wish to include a field in the report, simply do not click the "ADD" button next to the field. You May remove a field that you have already added by clicking the "REMOVE" button corresponding to the field name in the "Include These Fields" table.
	</p>
	
</div>

<div id = 'new3' class = 'hideMe'>
	<h3> Step 3: Selecting filter options</h3>
	<img src = '../img/report1-3.png'>
	<p>
	In steps 1 and 2, the user was asked to select a primary table, and to name and include fields from that table for use in the report being generated. In Step 3, the user is asked to select filter options. Creating a working filter can be complex, and understanding how database filtering works can be crucial.
	</p>
	<h4> What is a filter? </h4>
	<p>
	
	 A filter is a set of rules applied to the retreival of data. For example, if the user wishes only to see patients from the patients table who belong to clinic "A", a filter could be created to select only those patients. The database uses what is called a "WHERE" statement to filter for specific data. In the above example the WHERE statement would be "WHERE clinic IS EQUAL TO A".  
	</p>
	<h4> Chaining multile filter options </h4>
	<p>
	It is possible to chain multiple filter options together to create complex and precise filters using AND and OR statements. <br>
	an AND statement ties two options together so that <i><b>both criteria must be met</b></i>. An OR statement ties two options togther so that <b><i>either option must be met</i></b>. For example -- name_f IS EUQUAL TO 'John' OR name_f IS EQUAL TO 'Beth' -- would match data for <b><i> either </i></b> Beth or John, and as such would include <b><i> both </i></b> people (if they exist) in the report. -- name_l IS EQUAL TO 'Johnson' AND dob IS EQUAL TO '08/25/1974' -- would only include people whose last name is Johnson whose birthday is August 25th 1974.
	</p>
	<h4> Nesting filter options using Parantheses </h4>
	<p>
	AND and OR operators tie <b><i>two and only two</i></b> options together by tieing the next option to the previous one. Options can be grouped in to a single phrase using parenthesis Note the following two examples: <br><br>
	1) (language IS EUQAL TO 'French' AND  name_l IS EQUAL TO 'Johnson' ) OR dob IS EQUAL TO '08/25/1974' <br><br>
	2) language IS EUQAL TO 'French' AND (name_l IS EQUAL TO 'Johnson' OR dob IS EQUAL TO '08/25/1974')
	<br><br>
	In example 1, we are getting all the people named Johnson who speak french as well as everybody who's birthday is August 25th 1974, regardless of their name or what language they speak.
	<br><br>
	In example 2, we are getting French speaking people whose names are Johnson, or French speaking people who's birth day is August 25th 1974.
	</p>
	<h4> The six Operators </h4>
	<p>
	There are six operators, any one of which can be selected to create a filter statement. The six operators are  EQUAL TO, NOT EQUAL TO, LIKE, NOT LIKE, GREATER THAN, and LESS THAN. <br>
	<ul>
	<li>
	The EQUAL TO operator: Matches an <b><i> exact </i></b> value. EQUAL TO is <b><i> case sensitive and terminating </i></b> such that EQUAL TO "Johnson" would match "Johnson" but would <b><i> not </i></b> match "johnson" or "Johnsonville".
	</li>
	<li>
	The LIKE operator is similar to the EQUAL TO operator, but is case <b><i> insensitive </i></b> and non-terminating. LIKE "John" would match "John" as well as "Johnson", "johnsonville", "My name is John", and "johnny's got his gun".
	</li>
	<li>
	The NOT EQUAL TO operator works the same way as the EQUAL TO operator but in reverse. NOT EQUAL TO "Johnson" would match anybody who's name is <b><i> not </i></b> Johnson. In this case it <b><i> would match </i></b> "johnson" or "Johnsonville"
	</li>
	<li>
	The NOT LIKE operator works the same way as the LIKE operator but in reverse. NOT LIKE "Johnson" would exclude any data with "Johnson","johnson" and "johnsonville" in it. 
	</li>
	<li>
	The GREATER THAN operator is used to select data whose value is <b><i> larger </i></b> than the set value. Particularily handy for date searches. GREATER THAN 20 would select any data that has a value of 21.00000001 or higher.
	</li>
	<li>
	The LESS THAN operator is used to select data whose value is <b><i> smaller </i></b> than the set value. LESS THAN 20 would select any data that has a value of 19.99999999 or lower.
	</li>
	</ul>
	</p>
	<h4>Using the filter construction tool </h4>
	<p>
	Step 3 of the report generation wizard consists of a black bar containing several options as well as a terminal for viewing your current filter, and buttons labeled "CLEAR", "PREVIEW" and "DONE".  These options are used to create filter statements, and to view the effects of the current filter.
	</p>
	<h5> The filter constuction console </h5>
	<p>
	The filter contruction console is a black area which consists of several interactive elements used to construct the report filter. Each element is detailed below.
	<ul>
	<li>
	 The <b>Field</b> option is used to select which field is to be filtered.
	</li>
	<li>
	The <b> Operator </b> option is used to select whitch of the six operators is to be used in the filter statement
	</li>
	<li>
	The <b> Value </b> option is used to input what value in the field is to be filtered for by the operator.
	</li>
	<li>
	The <b> Add </b> option is used to add the filter constructed in the first three fields to the report filter. 
	</li>
	<li>
	The <b> ( </b> and <b> ) </b> options are used to add an opening or closing parenthesis for nesting.
	</li>
	<li>
	The <b> AND </b> option is used to add an AND statement to the report filter.
	</li>
	<li>
	The <b> OR </b> option is used to add an OR statement to the report filter.
	</li>
	</ul>
	</p>
	<h5> The filter terminal </h5>
	<p>
	The filter terminal is a gray area located under the filter construction console. This area is used to view the current filter as it is being constructed. The filter terminal is non-interactive and is used only for display purposes. 
	</p>
	<h5> The [CLEAR], [PREVIEW] and [DONE] buttons </h5>
	<p>
	<uL>
	<li>
	The CLEAR button is used to clear the filter and start over.
	</li>
	<li>
	The PREVIEW button can be pressed at any time to view the result of the current report filter. It can also be used to check the syntax of the current report filter. 
	</li>
	<li>
	The DONE button is pressed when the user has completed the filter and verified that it works using the PREVIEW button. Once pressed, the "NEXT" button will appear on the bottom of the page.
	</li>
	</ul>
	</p>
	
	
</div>

<div class = 'hideMe'>

</div>






<?php
require("{$legos}/banner.php");
require("{$legos}/messages.php");
require("{$legos}/nav.php");
?>

<div class = 'siteWrap'>
<div class = 'reportDisplay'>
		<div class = 'formTitle'>
		Report Help. 
		</div>
		<hr>
		
<?php
echo "<div id = 'toc'>";
echo "<h3>Contents</h3>";
echo "<ul>";
	echo "<li onclick = 'loadContent(\"new\");' class = 'hovCh'><b>Creating a new report</b></li>";
	echo "<li>";
		echo "<ul>";
			echo "<li onclick = 'loadContent(\"new1\");'> Step 1: Selecting a primary table </li>";
			echo "<li onclick = 'loadContent(\"new2\");'> Step 2: Including fields from your primary table </li>";
			echo "<li onclick = 'loadContent(\"new3\");'> Step 3: Selecting filter options </li>";
			echo "<li onclick = 'loadContent(\"new4\");'> Step 4: Replacing fields with related data </li>";
			echo "<li onclick = 'loadContent(\"new5\");'> Step 5: Saving your report </li>";
		echo "</uL>";
	echo "</li>";
	echo "<li class = 'hovCh'><b>Editing an existing report</b></li>";
	echo "<li>";
		echo "<ul>";
			echo "<li> a </li>";
			echo "<li> b </li>";
			echo "<li> c </li>";
			echo "<li> d </li>";
		echo "</ul>";
	echo "</li>";
	
echo "</ul>";

echo "</div>";

echo "<div id = 'content'>";

echo "</div>";

clearfix();
?>

</div>
</div>
<script>
function loadContent($str){
	var $content = document.getElementById($str).innerHTML;
	document.getElementById("content").innerHTML=$content;
	//alert($content);
}
</script>

</body>
</html>

