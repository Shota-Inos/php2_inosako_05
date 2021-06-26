<?php
//1.  DB接続します xxxにDB名を入れます
//new pdo DBにアクセスするための塊を作る
try {
$pdo = new PDO('mysql:dbname=a_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//２．データ登録SQL作成
//作ったテーブル名を書く場所  xxxにテーブル名を入れます
//stmt アローン演算子に接続する
//execute 実行
$stmt = $pdo->prepare("SELECT * FROM a_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  //Selectデータの数だけ自動でループしてくれる $resultの中に「カラム名」が入ってくるのでそれを表示させる例
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= "<p>";
    $view .= $result["indate"]."<br>".$result["name"];
    $view .= "</p>";
  }
}

//4.本日の日付を取得
$today = date("Y-m-d");

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/style.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:30px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="header" href="index.php">日記を作成する</a><br>
    </div>
  </nav>
</header>
<!-- Head[End] -->


<!-- Main[Start] $view-->
<div class="date">
    <div class="date_today">本日の日付<br><?=$today?></div> 
    <div class="date_goal">目標の日付<br><?=$today?></div> 
</div>

<div class="container">

    <div class=diary>
        <div class="diary_title">日記<br></div>
        <div class="diary_content"><?=$view?></div>
    </div>

    <div class="graph">
        <div class="graph_line">
            <a class="graph_title" href="chart_line.php">モチベーショングラフ</a>
            <p class="graph_1"><img src="img/graph_line.png" height="400px"></p>
        </div>

        <div class="title">
            <a class="graph_title" href="chart_radar.php">モチベーション集計</a><br>
            <p class="graph_1"><img src="img/graph_radara.png" height="400px"></p>
        </div>
    </div>

    <div class="news">
    <div class="news_title">ニュース<br></div>

    </div>

</div>
<!-- Main[End] -->


</body>
</html>