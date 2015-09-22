<?php
/**
 * Created by PhpStorm.
 * User: enotai / 12-211 Taishi Enokiya
 * Date: 2015/09/19
 * Time: 23:02
 */


function s($string){
  // タグを無効にする
  $string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');

  // magic_quotes_gpcがONの場合はエスケープを解除する
  if (get_magic_quotes_gpc()) {
    $string = stripslashes($string);
  }

  // SQLコマンド用の文字列にエスケープする
  //$string = mysql_real_escape_string($string);
  //非推奨らしい

  return $string;
}


/*===POST内容取得===*/

$gender=s($_POST['gender']);//性別
$room=s($_POST['room']);//性別
$grade=s($_POST['grade']);//学年
$dept=s($_POST['dept']);//学科
$student_id=s($_POST['student-id']);//学籍番号
$last_roma_name=s($_POST['last-name-roma']);//姓(roma)
$first_roma_name=s($_POST['first-name-roma']);//名(roma)
$last_name=s($_POST['last-name']);//姓
$first_name=s($_POST['first-name']);//名
$mac_address=s($_POST['mac-address']);//MACアドレス
$agreement=s($_POST['agreement']);//規約書に同意したか


echo $student_id;
$csv_input = '';

include('./template/define.php');
$title.="ネットワーク申請 完了";
include('./template/top.php');
?>

<div class="container">
  <h1>学寮ネットワーク 登録完了</h1>
  <h3>以上で登録は完了となります。ありがとうございました。</h3>
</div>

<?php include('./template/bottom.php'); ?>