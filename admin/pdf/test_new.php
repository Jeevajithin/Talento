<?php
// Include the TCPDF library
require_once('tcpdf/tcpdf.php');


class MYPDF extends TCPDF {

    //Page header
    

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        
        $this->SetFont('helvetica', 'I', 12);
        // Page number
        $this->Cell(0, 10, 'Srishti Innovative | www.srishtis.com | 04714062181', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Create a new TCPDF instance
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Gate Pass');
$pdf->SetSubject('Gate Pass');
$pdf->SetKeywords('PDF, TCPDF, HTML');

// Set default header data
//$pdf->SetHeaderData('', 0, 'Customized PDF', '');

// Set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


$pdf->setFooterData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));



// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();

// Your provided HTML content

$name="Mr. Jithin James";

$html = '<html>
<head>
<style>
.logo-sec{
background-color: #ccc;
float: right;
}
.logo-sec img{

}
table th{ text-align: center; padding: 15px; line-height: 70px;}
</style>
</head>
<body style="margin: 0;">
    

            <table width="100%">
                <tr>
                    <th>
                        <img style="width: 200px;"src="assets/img/logo.png">
                    </th>
                </tr>
            </table> 



        <br><br><br>
        <div>
            <table width="100%">
                <td>To
                    <br>The Security Officer
                    <br>Technopark</td>
                <td align="right">26th June 2023</td>
            </table>     
        </div>
        <div>
                <p>&nbsp; Sir/ Ma’am</p>
                <p>&nbsp; Please permit our Trainee, <span>'.$name.'</span> to enter Technopark campus till 26
th July 2023.</p>
               
            <img src="assets/img/user.png">
            <p></p>
            <div>
                <img style="width: 100px;"  src="assets/img/signature.png">
                <img style="width: 100px;"  src="assets/img/seal.jpg">
            </div>
           
            <p>
            <br>Sreepriya P
                <br>Contact No: +91-9072442200
                <br>HR Team – Srishti Innovative.
              
            </p> 

            </div>
    
           
    
   
</body>
</html>';

// Convert HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF to a file
$folderPath = '/home/ubuntu/html/Project/srishticampus/admin/pdf/pdfs'; // Change this to the folder where you want to store PDFs
$fileName = rand().'customized_pdf.pdf'; // Change the filename if needed
$pdfFilePath = $folderPath . '/' . $fileName;

if (!is_dir($folderPath)) {
    mkdir($folderPath, 0755, true);
}

$pdf->Output($pdfFilePath, 'F');

// Close the PDF
$pdf->close();



// Redirect to the generated PDF file
$path1="http://campus.sicsglobal.co.in/Project/srishticampus/admin/pdf/pdfs/".$fileName;

header("Location: $path1");
exit();
?>
