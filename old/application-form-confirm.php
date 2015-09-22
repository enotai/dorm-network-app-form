<?php
/**
 * Created by PhpStorm.
 * User: enotai / 12-211 Taishi Enokiya
 * Date: 2015/09/19
 * Time: 23:01
 */


/*===文字列を安全なものへ置換===*/
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
$gender = $grade = $dept = $student_id = $last_roma_name = $first_roma_name = $last_name = $first_name = $mac_address = $agreement = "";

$gender=s($_GET['gender']);//性別
$room=s($_GET['room']);//部屋番号
$grade=s($_GET['grade']);//学年
$dept=s($_GET['dept']);//学科
$student_id=s($_GET['student-id']);//学籍番号
$last_roma_name=s($_GET['last-name-roma']);//姓(roma)
$first_roma_name=s($_GET['first-name-roma']);//名(roma)
$last_name=s($_GET['last-name']);//姓
$first_name=s($_GET['first-name']);//名
$mac_address=s($_GET['mac-address']);//MACアドレス
$agreement=s($_GET['agreement']);//規約書に同意したか

$query_str = s($_GET['query_str']);


//http://localhost/10.12.1.2/application-form.php

if(!($_SERVER['HTTP_REFERER'] == 'http://localhost/10.12.1.2/application-form.php')) header("Location: http://10.12.1.2/");//変なことをしたら飛ばす

$dept_arr = [];//連想配列で学科名を変える?



include('./template/define.php');
$title .= "ネットワーク申請 入力確認";
include('./template/top.php');
?>
  <div class="container">
    <div id="main" class="col-md-10">
      <h1>学寮ネットワーク 入力確認</h1>

      <h4 style="padding-bottom: 40px">以下の内容で間違いがないか確認してください。<br>間違いがある場合ばブラウザの「戻る」で訂正を行ってください。</h4>


      <form id="application" class="form-horizontal" role="form" action="application-form-complete.php" method="post">

        <div class="form-group">
          <label for="selectPlace" class="col-sm-2 col-sm-offset-1 control-label">性別</label>

          <div class="col-md-4">
            <input type="text" class="form-control" name="room" id="room" value="<?php if($gender == 'male') echo '男子'; elseif($gender == 'female') echo '女子' ?>" disabled>
          </div>
        </div>

        <div class="form-group">
          <label for="proj" class="col-md-2 col-md-offset-1 control-label">部屋番号</label>

          <div class="col-md-4">
            <input type="text" class="form-control" name="room" id="room" value="<?php echo $room ?>" disabled>
          </div>
        </div>

        <div class="form-group">
          <label for="class" class="col-md-2 col-md-offset-1 control-label">学年 / 学科</label>
          <div class="col-md-4">
            <input type="text" class="form-control" name="room" id="room" value="<?php echo $grade .'年 '. $dept .'科'?>" disabled>
          </div>
        </div>

        <div class="form-group">
          <label for="proj" class="col-md-2 col-md-offset-1 control-label">学籍番号</label>

          <div class="col-md-4">
            <input type="text" class="form-control" name="student-id" id="student-id" value="<?php echo $student_id ?>" disabled>
          </div>
        </div>


        <div class="form-group">
          <label for="name" class="col-md-2 col-md-offset-1 control-label">名前(ローマ字)</label>

          <div class="col-md-7">
            <div class="row">
              <div class="col-md-6">
                <input type="text" class="form-control" name="last-name-roma" value="<?php echo $last_roma_name ?>" disabled>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" name="first-name-roma" value="<?php echo $first_roma_name ?>" disabled>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="name" class="col-md-2 col-md-offset-1 control-label">名前</label>

          <div class="col-md-7">
            <div class="row">
              <div class="col-md-6">
                <input type="text" class="form-control" name="last-name" value="<?php echo $last_name ?>" disabled>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" name="first-name" value="<?php echo $first_name ?>" disabled>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="proj" class="col-md-2 col-md-offset-1 control-label">MACアドレス</label>

          <div class="col-md-4">
            <input type="text" class="form-control" name="mac-address" id="mac-address" value="<?php echo $mac_address ?>" disabled>
            <input type="hidden" name="query_str" value="<?php echo 'gender='. $gender . '&grade=' . $grade . '&dept=' . $dept . '&room=' . $room . '&student-id=' . $student_id . '&last-name-roma=' . $last_roma_name . '&first-name-roma=' . $first_roma_name . '&last-name=' . $last_name . '&first-name=' . $first_name . '&mac-address=' . $mac_address . '&agreement=' . $agreement; ?>"/>
            <p class="text-primary">上記には現在使用しているパソコンの<br>MACアドレスが表示されています</p>
          </div>
        </div>


        
        <div class="form-group"><!-- 登録ボタン -->
          <div class="col-md-offset-3 col-md-7 text-center">
            <div class="row">
              <div class="col-md-6 col-sm-offset-3">
                <button type="submit" class="btn btn-lg btn-block btn-primary" id="register">登録
                </button>
              </div>
            </div>
          </div>
        </div>


      </form>
    </div>
  </div>

<?php include('./template/bottom.php'); ?>