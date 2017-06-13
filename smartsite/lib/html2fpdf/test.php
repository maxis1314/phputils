<?php
define('FPDF_FONTPATH','font/');
require_once('html2fpdf.php');
ob_start();
?>
<HTML>

<HEAD><TITLE>test</TITLE></HEAD>
<BODY>

   <a href=>est</a>
   	   <table border=1><tr><td>1</td></tr><tr><td>1</td></tr><tr><td>1</td></tr><tr><td>1</td></tr>
   	   </table>

</BODY>
</HTML>

<?php
$html=ob_get_contents();
ob_end_clean();

// PDFの書式設定
$pdf = new HTML2FPDF("l","mm","A4");
$pdf->Open();

$pdf->SetCompression(false);
$pdf->SetDisplayMode("real");
$pdf->UseCSS();
$pdf->UsePRE();
$pdf->setBasePath( "http://google.com" );
$pdf->AddPage();

//ファイル情報
$pdf->SetAuthor("Kazuhiko HiroseKazuhiko HiroseKazuhiko HiroseKazuhiko HiroseKazuhiko HiroseKazuhiko HiroseKazuhiko HiroseKazuhiko Hirose");
$pdf->Bookmark( "BookmarkBookmarkBookmarkBookmarkBookmarkBookmarkBookmarkBookmarkBookmarkBookmarkBookmark" );
$pdf->SetTitle("SetTitleSetTitleSetTitleSetTitleSetTitleSetTitleSetTitleSetTitleSetTitleSetTitleSetTitleSetTitle");
$pdf->SetCreator( "SetCreatorSetCreatorSetCreatorSetCreatorSetCreatorSetCreatorSetCreatorSetCreatorSetCreatorSetCreator" );

// 本文
$pdf->SetMargins( 10, 10 );
$pdf->DisplayPreferences('HideWindowUI');
//$pdf->SetFont( HideWindowUI,"",8);
$pdf->WriteHTML($html);

// 出力
$pdf->Output('doc.pdf','D');
?>