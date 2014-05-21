<?php
$fp = @fopen("D:\\yimutest\\3\\MyPlan\\log.txt", "a+");
fwrite($fp, date("Y-m-d H:i:s")."PHP代码自动运行！\n");
fclose($fp);
?>