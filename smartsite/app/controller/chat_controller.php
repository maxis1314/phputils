<?php
class chat_controller extends application {

	function filter($method) {
		$this->user_login();
		$this->sv('blog', $this->model('mvc_blog')->peeks(array (
			"delete_flag is null or delete_flag <> ?" => 1
		), 'id desc', 10));
		$this->sv('comment', $this->model('mvc_comment')->peeks(null, 'id desc', 10));

	}
	
	function index(){
	
	}
	
	function get_chat(){
		$type=p("type");

		$filename = ROOT.'/data/chart.data';

		if (file_exists($filename)) {
		} else {
		    $handle = fopen($filename, 'w');
		    fwrite($handle, "\n"); 
		    fclose($handle);
		}
		
		if($type == 1){
			$name=p("n");
			$subject=p("s");
			echo $name;
			echo $subject;
			if($name && $subject){
				if (is_writable($filename)) {
				   if (!$handle = fopen($filename, 'a')) {
				         echo "Cannot open file ($filename)";
				   }
				   fwrite($handle, $name." say:  ".$subject."\n"); 
				   fclose($handle);
				   echo "w";
				}else{
					echo "no";
				}
			}
		
		}
		if($type == 2){
			$a=file($filename);
			$num=p("num");
			$num_lines = count($a);
			if($num){
				if($num>=$num_lines){
					echo $num_lines;
				}else{
					echo $num_lines;
					$j=1;
					foreach($a as $b){
						if($j>$num){
							$b=chop($b);
							echo "\n",$b;
						}
						$j++;
					}
				}
			}else{
				if(15>$num_lines){
					echo $num_lines;
					foreach($a as $b){
						if($j>$num){
							$b=chop($b);
							echo "\n",$b;
						}
						$j++;
					}
					
				}else{
					echo $num_lines;
					$j=1;
					foreach($a as $b){
						if($j>$num_lines-15){
							$b=chop($b);
							echo "\n",$b;
						}
						$j++;
					}
				}
			}
		}
		exit;
	}
}
?>