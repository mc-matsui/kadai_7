<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>● 課題7_1, テキストファイルでBBSを作成する</title>
</head>
<body>
<h1>● 課題7_1, テキストファイルでBBSを作成する</h1>
<br>
<?php
$fp = fopen("lesson.bbs", "r"); //lesson.bbs読み込み
$number = 0;		//数字初期化
flock($fp,LOCK_EX); // 排他ロック(読み書き禁止)

//$lineでファイルの内容取得
while ($line = fgets($fp))
{
	if (preg_match("/\*\*\*>>/",$line))	//正規表現（***>>）
	{
		$number++;
		$line = str_replace("***>>", "$number,&nbsp", $line);	//確実に***>>のみ変換
		print $line;
	}
	elseif (preg_match("/date>>/",$line))	//正規表現（date>>）
	{
		$line = str_replace("date>>", "(投稿日時：&nbsp", $line);	//確実にdate>>のみ変換
		print $line . ")<br>";
	}
	elseif (preg_match("/cont>>/",$line))	//正規表現（cont>>）
	{
		print "&nbsp&nbsp";
	}
	elseif (preg_match("/contend>>/",$line))	//正規表現（contend>>）
	{
		print "<br>-------------------------------------------<br>";
	}
	else
	{
		print  $line."<br>";
	}

}

flock($fp,LOCK_UN); // ロック開放
fclose($fp);

?>
</body>
</html>
