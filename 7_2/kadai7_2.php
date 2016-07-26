<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>● 課題7_2, 投稿フォームを追加しBBSファイルに反映</title>
<script type="text/javascript">
<!--
function wupBtn()
{
  //投稿ないようを変数に格納
  var contents = document.send.contents.value;

  //投稿内容の空チェック判定
  if (contents == "")
  {
    //投稿内容が空であれば、ボタンを押せなくする
    document.send.write.disabled=true;
  }
  else
  {
    //投稿内容が書き込まれていたら、ボタンを押せるようにする
    document.send.write.disabled=false;
  }
}
// -->
</script>
</head>
<body>
<h1>● 課題7_2, 投稿フォームを追加しBBSファイルに反映</h1>
<br>
<?php
$fp = fopen("lesson.bbs", "r"); //lesson.bbs読み込み
$number = 0;		//数字初期化
flock($fp,LOCK_EX); // 排他ロック(読み書き禁止)
//fseek($fp, 100);
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
<br><br>
<!-- bbs投稿 -->
<form method="post" name="send" action="kadai7_2_write.php">
名前: <input type="text" name="name" ><br>
内容: <br><textarea name="contents" cols="30" rows="2" onchange="wupBtn()"></textarea><br>
<br>
<input type="submit" name="write" value="投稿"  disabled>
</form>
<!-- bbs投稿 -->
</body>
</html>