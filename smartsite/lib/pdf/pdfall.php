<?php
class PDFALL extends MBFPDF
{
		var $pdfheader_a;
		var $pdffooter_a;
		var $pdfheaderfootfont;
		
		function PDFALL($font){
			$this->pdfheaderfootfont=$font;
			parent::MBFPDF();
			$this->AddMBFont(GB,'GB');
			$this->AddMBFont(BIG5,'BIG5');
			$this->AddMBFont(GOTHIC ,'SJIS');
		}
		
		function wrpdf01($str,$size=12){
			$this->setFontPdfAll('',$size);
			$str=preg_replace('/\r/','',$str);
			$this->Write(10,$str);
		}
		
		function setFontPdfAll($a="",$size=12){
			$a=$a ? $a : $this->pdfheaderfootfont;
			if($a=="jp"){
				$this->SetFont(GOTHIC,'',$size);
			}elseif($a=="cn2"){
				$this->SetFont(BIG5,'',$size);
			}elseif($a=="cn1"){
				$this->SetFont(GB,'',$size);
			}
		}
		

		function pdfsetheaderfooter($a,$b){
			$this->pdfheader_a=$a;
			$this->pdffooter_a=$b;			
		}
		//Page header
		function Header()
		{
		    //Logo
		    //$this->Image(ROOT.'public/images/logo7.jpg',10,8);
		    //Arial bold 15
		    
		    $this->SetFont('Arial','B',15);
		    $this->Cell(0,10,$this->PageNo(),0,0,'L');
		    
		    $this->setFontPdfAll('',15);
		    //Move to the right
		    $this->Cell(10);
		    //Title
		    $this->Cell(0,10,$this->pdfheader_a ? $this->pdfheader_a:'It\'s your future',0,0,'R');
		    $this->Ln(8);
		    $this->Cell(190,0,'',1,0,'C');
		    //Line break
		    $this->Ln(8);
		}
		
		//Page footer
		function Footer()
		{
		    //Position at 1.5 cm from bottom
		    $this->SetY(-15);
		    //Arial italic 8
		    //$this->SetFont('Arial','I',8);
		    $this->setFontPdfAll('',8);
		    if($this->pdffooter_a){
		    	$this->Cell(0,10,$this->pdffooter_a,0,0,'L');
		    }
		    //Page number
		    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
}

?>