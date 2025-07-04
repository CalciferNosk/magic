<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

  public function __construct() {
     parent::__construct();
     $this->load->helper('url');
     $this->load->model('Complaint_model', 'complaint');
          $this->load->model('Inquiry_model', 'inquiry');
  }

	public function index()
	{
     $this->load->view('test_view');
   
	}

  public function submit(){

    if(isset($_FILES['image'])){
$file_name = $_FILES['image']['name'];
$file_tmp =$_FILES['image']['tmp_name'];
move_uploaded_file($file_tmp,$_SERVER['DOCUMENT_ROOT']."/marketing-forms/images/".$file_name);
echo "<h3>Image Upload Success</h3>";
echo '<img src="'.base_url().'images/'.$file_name.'" style="width:100%">';

//$cmd = shell_exec('ls 2>&1');
shell_exec('C:\Users\H2\AppData\Local\Programs\Tesseract-OCR\tesseract "images/'.$file_name.'" out');
//$cmd = shell_exec('tesseract -v');
//echo $cmd;
echo $_SERVER['DOCUMENT_ROOT'];
//echo ini_get("disable_functions");
echo 'tesseract "images/'.$file_name.'" out';
echo "<br><h3>OCR after reading</h3><br><pre>"; 

$myfile = fopen("out.txt", "r") or die("Unable to open file!");
echo fread($myfile,filesize("out.txt"));
fclose($myfile);
echo "</pre>";

$search = 'NAME';
$veron = 'REPUBLIC OF THE PHILIPPINES';
$vertw = 'LAND TRANSPORTATION OFFICE';
$lines = file('out.txt');
// Store true when the text is found
$found = false;
$deets = false;
foreach($lines as $line)
{
  if($deets == true){
      echo $line.'<br>';
      $deets = false;
    }
  if(strpos($line, $search) !== false || strpos($line, $veron) !== false || strpos($line, $vertw) !== false )
  {
    $found = true;
    echo $line.'<br>';
    $deets = true;
  }
}
// If the text was not found, show a message
if(!$found)
{
  echo 'No match found';
}
/*
$file = 'out.txt';
$searchfor = 'NAME';



// get the file contents, assuming the file to be readable (and exist)
$contents = file_get_contents($file);
// escape special characters in the query
$pattern = preg_quote($searchfor, '/');
// finalise the regular expression, matching the whole line
$pattern = "/^.*$pattern.*\$/m";
// search, and store all matching occurences in $matches
if(preg_match_all($pattern, $contents, $matches)){
   echo "Found matches:\n";
   echo implode("\n", $matches[0]);
}
else{
   echo "No matches found";
}
*/
}
  }

         

}
