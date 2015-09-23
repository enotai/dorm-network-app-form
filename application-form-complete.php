<?php
/**
 * Created by PhpStorm.
 * User: enotai / 12-211 Taishi Enokiya
 * Date: 2015/09/19
 * Time: 23:02
 * Description: 学寮ネットワーク申請完了 / ファイル書き込み
 * Comment: scandir関数によりファイルの一覧を取得可能→できました
 */
if(!($_SERVER['HTTP_REFERER'] == 'http://localhost/10.12.1.2.ver2/application-form-confirm')) header("Location: http://10.12.1.2:8080/");//前のページが確認フォームか

session_start();//セッション開始

function s($string) {//入力された文字列を安全なものに変換
  $string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');

  if(get_magic_quotes_gpc()) $string = stripslashes($string);

  return $string;
}

date_default_timezone_set('Asia/Tokyo');//タイムゾーン設定
$now_time = date('ymd-His');//現在の日付 / ファイル名用



/*===SESSION内容取得===*/
//扱いやすいように名前を変える

$gender = s($_SESSION['gender']);//性別
$room = s($_SESSION['room']);//部屋番号
$grade = s($_SESSION['grade']);//学年
$dept = s($_SESSION['dept']);//学科
$student_id = s($_SESSION['student_id']);//学籍番号
$last_roma_name = s($_SESSION['last_roma_name']);//姓(roma)
$first_roma_name = s($_SESSION['first_roma_name']);//名(roma)
$last_name = s($_SESSION['last_name']);//姓
$first_name = s($_SESSION['first_name']);//名
$mac_address = s($_SESSION['mac_address']);//MACアドレス


$mac_dir = scandir('./data/' . $gender . '/' . $grade);//Strict Standardsエラー対策
/*===過去ファイル読み出し===*/
if($latest_file_name = end($mac_dir))//最新のファイル読み出し
  $latest_file_contents = file_get_contents('./data/' . $gender . '/' . $grade . '/' . $latest_file_name);//
else $latest_file_contents = '';//ファイルが存在しなければ、空のファイルとする


/*===ファイル書き込み準備===*/
$count = 0;//台数カウント用

$last_roma_name = strtolower($last_roma_name);
$first_roma_name = strtolower($first_roma_name);

$csv_input = $latest_file_contents . $first_roma_name . '_' . $last_roma_name . ',' . $dept . ',' . $student_id . ',' . $mac_address . ',' . $count . "\n";


/*===ファイル書き込み===*/
//php.netより拝借
$filename = './data/' . $gender . '/' . $grade . '/maclist_' . $now_time;//ファイル名

// ファイルが存在しかつ書き込み可能かどうか確認します
touch($filename);//ファイル作成
if(is_writable($filename)) {

  // この例では$filenameを追加モードでオープンします。
  // ファイルポインタはファイルの終端になりますので
  // そこがfwrite()で$somecontentが追加される位置になります。
  if(!$handle = fopen($filename, 'a')) {
    //echo "Cannot open file ($filename)";
    exit;
  }

  // オープンしたファイルに$somecontentを書き込みます
  if(fwrite($handle, $csv_input) === false) {
    //echo "Cannot write to file ($filename)";
    exit;
  }

  //echo "Success, wrote ($csv_input) to file ($filename)";

  fclose($handle);

} else {
  //echo "The file $filename is not writable";
}

include('./template/define.php');
$title .= "ネットワーク申請 完了";
include('./template/top.php');
?>

  <div class="container">

    <?php // セッション判定
    if(isset($_SESSION['mac_address'])): ?>
      <h1>学寮ネットワーク 登録完了</h1>
      <h3>以上で登録は完了となります。ありがとうございました。</h3>
    <?php else: ?>
      <h3 style="color: #b92c28">セッションの有効期限が切れました。<a href="./application-form">元のページに戻り</a>再登録を行ってください。</h3>
    <?php endif; ?>
  </div>

<?php
session_destroy();//セッション破棄 / 行わなくても24分(1440秒)以内に自動的に破棄:php.ini
include('./template/bottom.php'); ?>