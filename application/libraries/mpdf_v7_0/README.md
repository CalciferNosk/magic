HTML2PDF By mpdf Library for CodeIgniter
========================================
This Library is for generate html 2 pdf using mpdf and codeigniter 3.0+.
Tested with php ^5.6 || ~7.0.0 || ~7.1.0 || ~7.2.0
and mPDF 7.0.

## Easy Installation

Copy the mpdf folder to Library folder of codeigniter and also Mpdf_html2pdf.php to library folder also.

## Quick Start


```php
$this->load->library('mpdf_html2pdf');

$str="<h1>Your HTMl File"; //Load Your Html file here

//Loading html via view of codeigniter
//$str=$this->load->view("view", $data, true);

//Set folder to save PDF to
$this->mpdf_html2pdf->folder('./uploads/');

//Set the filename to save/download as
$this->mpdf_html2pdf->filename('test.pdf');

//Set the paper defaults
$this->mpdf_html2pdf->paper('a4', 'portrait');


$this->mpdf_html2pdf->html($str);

// Here pass the value download/view/save 

if($this->mpdf_html2pdf->create('download')) {
	//PDF was successfully saved or downloaded
	echo 'PDF saved';
}else{
	show_error("sorry Somthing went wrong");
}
```