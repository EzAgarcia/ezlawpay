<?php 
require('pdf/fpdf.php');

class PDF extends FPDF
{
	// Pie de página
	function Footer()
	{
	    // Posición: a 1,5 cm del final
	    $this->SetY(-20);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Número de página
	    $this->Cell(150,20,'Powered by '.$this->Image(base_url().'assets/img/OriginalOnTransparent.png',100,($this->getY()+5),33),0,0,'C');
	    //$this->Image(base_url().'assets/img/OriginalOnTransparent.png',90,null,33);
	}

}

$pdf = new PDF();
$pdf->AddPage();
$pdf->ln(15);
$pdf->SetFillColor(245,245,245);
$pdf->SetDrawColor(221,221,221);
$pdf->SetFont('Times','',18);
$pdf->SetTextColor(51,122,183);
$lawfirm=$this->M_invoice->lawfirm($this->session->ezlow['lawfirm']);
$pdf->Cell(20,9,$lawfirm[0]->Company);
$pdf->ln(10);
$pdf->SetFont('Times','',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(20,9,"Contract Number");
$pdf->ln(5);
$pdf->Cell(20,9,$general[0]->Contract_N);
$pdf->ln(16);
$pdf->line($pdf->getx(),$pdf->gety(),($pdf->getx()+180),$pdf->gety());
$pdf->SetFont('Times','B',14);
$pdf->ln(5);
$pdf->Cell(90,9,'Customer Information',0,0);
$pdf->Cell(90,9,'Pay to:',0,0,'R');
$pdf->SetFont('Times','',12);
$pdf->ln(7);
$pdf->Cell(90,9,$general[0]->C_Name,0,0);
$pdf->Cell(90,9,'Kostiv & Associates',0,0,'R');
$pdf->ln(5);
$pdf->Cell(90,9,$general[0]->Address,0,0);
$pdf->Cell(90,9,'3450 Wilshire Boulevard',0,0,'R');
$pdf->ln(5);
$pdf->Cell(90,9,'',0,0);
$pdf->Cell(90,9,'Los Angeles, CA 90010',0,0,'R');
$pdf->ln(5);
$pdf->Cell(90,9,'',0,0);
$pdf->Cell(90,9,'Phone: 3108974276',0,0,'R');
$pdf->ln(5);
$pdf->SetFont('Times','B',12);
$pdf->Cell(90,9,'Due Date',0,0);
$pdf->ln(5);
$pdf->SetFont('Times','',12);
$pdf->Cell(90,9,$general[0]->Date,0,0);
$pdf->ln(20);

$pdf->SetFillColor(245,245,245);
$pdf->SetDrawColor(221,221,221);
$pdf->cell(10);
$pdf->cell(160, 9,'    Services', 1,0,'L',true);
$pdf->ln(9);
$pdf->cell(10);
$pdf->cell(5,9,'','L');
$pdf->cell(110,9,'Description','B');
$pdf->cell(40,9,'Amount','B',0,'C');
$pdf->cell(5,20,'','R');
$pdf->SetFont('Times','',10);
$pdf->ln(9);
$pdf->cell(10);

if ($general[0]->Fee_ID<>0){
	$fee=$this->M_invoice->fee_description($general[0]->Fee_ID);
	$pdf->cell(5,9,'','L');
	$pdf->cell(110,9,'Fee Payment - '.$fee[0]->Fee_Type,'B');
	$pdf->cell(40,9,'$'.$general[0]->Pay_Amount.' DLLS','B',0,'C');
	$pdf->cell(5,9,'','R');
}else{
	$pdf->cell(5,50,'','L');
        $pdf->multicell(110,5,$general[0]->Pay_Description, 0, 'L', false);
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->SetXY($x + 125, $y);
	$pdf->cell(40,0,'$'.$general[0]->Pay_Amount.' DLLS','R',0,'C');
	$pdf->cell(5,15,'','R');
}

$pdf->ln(9);
$pdf->cell(10);
$pdf->cell(5,9,'','L');
$pdf->SetFont('Times','B',10);
$pdf->cell(110,9,'Sub Total','B',0,'R',true);
$pdf->SetFont('Times','',10);
$pdf->cell(40,9,'$'.$general[0]->Pay_Amount.' DLLS','B',0,'C',true);
$pdf->cell(5,9,'','R');

$pdf->ln(9);
$pdf->cell(10);
$pdf->cell(5,9,'','L');
$pdf->SetFont('Times','B',10);
$pdf->cell(110,9,'Charge','B',0,'R',true);
$pdf->SetFont('Times','',10);
$pdf->cell(40,9,'$0.00 DLLS','B',0,'C',true);
$pdf->cell(5,9,'','R');

$pdf->ln(9);
$pdf->cell(10);
$pdf->cell(5,9,'','L');
$pdf->SetFont('Times','B',10);
$pdf->cell(110,9,'Total','B',0,'R',true);
$pdf->SetFont('Times','',10);
$pdf->cell(40,9,'$'.$general[0]->Pay_Amount.' DLLS','B',0,'C',true);
$pdf->cell(5,9,'','R');

$pdf->ln(9);
$pdf->cell(10);
$pdf->cell(160,9,'','LBR');

if ($general[0]->Fee_ID<>0){
	$pdf->ln(15);
	$pdf->cell(10);
	$pdf->SetFont('Times','B',10);
	$pdf->cell(80,9,'Transaction Date	','B',0,'C');
	$pdf->cell(80,9,'Total','B',0,'C');
	$pdf->ln(9);
	$pdf->cell(10);
	$pdf->SetFont('Times','',10);
	$pdf->cell(80,9,$general[0]->date_pay,'B',0,'C');
	$pdf->cell(80,9,'$'.$general[0]->Pay_Amount.' DLLS','B',0,'C');
}else{
	$pdf->ln(15);
	$pdf->cell(10);
	$pdf->SetFont('Times','B',10);
	$pdf->cell(53,9,'Transaction Date	','B',0,'C');
	$pdf->cell(53,9,'Frecuency','B',0,'C');
	$pdf->cell(54,9,'Total','B',0,'C');
	$pdf->ln(15);
	$pdf->cell(10);
	$pdf->SetFont('Times','',10);
	$pdf->cell(53,9,$general[0]->date_pay,'B',0,'C');
	$pdf->cell(53,9,$general[0]->Frequency,'B',0,'C');
	$pdf->cell(54,9,'$'.$general[0]->Pay_Amount.' DLLS','B',0,'C');
}

$pdf->Output();
?>