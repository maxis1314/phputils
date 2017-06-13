<?php
class View{
	private static $v;
	var $smarty; 
	static function getObj(){
		if(self::$v){
			return self::$v;
		}else{
			$obj=__CLASS__;
			self::$v = new $obj;
			return self::$v;
		}
		
	}
	
	function set_smarty($smarty){
		$this->smarty=$smarty;
	}
	
	function fetch_html($params,$file){
	    if($params){
		   foreach($params as $key=>$value){
		   	   $this->smarty->assign($key,$value);
		   }
		}
	    return $this->smarty->fetch($file);
	}
	
	function View(){
		include(ROOT.'smarty/Smarty.class.php');
		$this->smarty = new Smarty();
		$this->smarty->template_dir = ROOT.'app/view/';
		$this->smarty->compile_dir = ROOT.'smarty/templates_c/';
		$this->smarty->cache_dir = ROOT.'smarty/cache/';
		$this->smarty->config_dir = ROOT.'smarty/configs/';
	}
	
	static function download($fname,$file){
		header("Content-Type: application/force-download");
		header("Content-Disposition: attachment; filename=".e($fname));
		header("Content-Description: File Transfer");
		@readfile(ROOT."$file");
	}
	
	static function download_str($fname,$str){
		header("Content-Type: application/force-download");
		header("Content-Disposition: attachment; filename=\"".e($fname)."\"");
		header("Content-Description: File Transfer");
		echo $str;
	}
	
	static function output_pdf($head,$foot,$data,$encode="cn2",$length=10000){
		include(ROOT.'lib/pdf/fpdf.php');
		include(ROOT.'lib/pdf/mbttfdef.php');
		include(ROOT.'lib/pdf/mbfpdf.php');
		include(ROOT.'lib/pdf/helveticab.php');
		include(ROOT.'lib/pdf/pdfall.php');
		
		$pdf=new PDFALL($encode);
		$pdf->pdfsetheaderfooter(self::pdf_change_encode(limit_length($head,100),$encode),self::pdf_change_encode(limit_length($foot,100),$encode));
		$pdf->AliasNbPages();
        $pdf->Open();
        $pdf->AddPage();
		$str=self::pdf_change_encode(limit_length($data,$length),$encode);
        $pdf->wrpdf01($str,12);
		$pdf->Output("yourfile.pdf","D");
	}
	static function html2pdf($html,$encode="SJIS"){
		//echo 1;exit;
		//$html=self::pdf_change_encode($html,$encode);
		
		define('FPDF_FONTPATH',ROOT.'lib/html2fpdf/font/');
		include(ROOT.'lib/html2fpdf/jphtml2fpdf.php');		
		
		$pdf = new HTML2FPDF("l","mm","A4");
		$pdf->Open();
		
		$pdf->SetCompression(false);
		$pdf->SetDisplayMode("real");
		$pdf->UseCSS();
		$pdf->UsePRE();
		$pdf->AddSJISFont();
		$pdf->setBasePath( "" );
		$pdf->AddPage();
		
		//ファイル情報
		$pdf->SetAuthor("HPX");
		$pdf->Bookmark( "HPX" );
		$pdf->SetTitle("HPX");
		$pdf->SetCreator( "HPX" );
		
		// 本文
		$pdf->SetMargins( 10, 10 );
		$pdf->DisplayPreferences('HideWindowUI');
		//$pdf->SetFont( HideWindowUI,"",8);
		$pdf->WriteHTML($html);
		
		// 出力
		$pdf->Output('doc.pdf','D');
		exit;
	}
	
	static function pdf_change_encode($str,$encode="cn1"){
		if($encode=="cn1"){
			$str=mb_convert_encoding($str, "GB2312", "UTF-8");
		}elseif($encode=="cn2"){
			$str = mb_convert_encoding($str, "BIG5", "UTF-8");
		}elseif($encode=="jp"){
			$str = mb_convert_encoding($str, "EUC", "UTF-8");
		}else{
			$str = mb_convert_encoding($str, $encode, "UTF-8");
		}
		return $str;
	}
}

?>