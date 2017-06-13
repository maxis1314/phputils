<?php
/*
* Smarty plugin
* -------------------------------------------------------------
* File:     function.eightball.php
* Type:     function
* Name:     eightball
* Purpose:  ランダムに回答を出力する
* -------------------------------------------------------------
*/
function smarty_function_eightball($params, &$smarty)
{
    $answers = array('Yes',
                     'No',
                     'No way',
                     'Outlook not so good',
                     'Ask again soon',
                     'Maybe in your reality');

    $result = array_rand($answers);
    return $answers[$result];
}
?> 