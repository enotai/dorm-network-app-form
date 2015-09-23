<?php
/**
 * Created by PhpStorm.
 * User: enotai / 12-211 Taishi Enokiya
 * Date: 2015/09/19
 * Time: 23:01
 * Description: 学寮ネットワーク申請フォーム / 書式変更 / 入力内容確認
 */

if(!($_SERVER['HTTP_REFERER'] == 'http://localhost/10.12.1.2.ver2/application-form')) header("Location: http://10.12.1.2:8080/");//前のページが申請フォームか

session_start();

/*===書式変更===*/
$_SESSION['last_roma_name'] = strtolower($_SESSION['last_roma_name']);//小文字変換
$_SESSION['first_roma_name'] = strtolower($_SESSION['first_roma_name']);

$_SESSION['mac_address'] = strtoupper($_SESSION['mac_address']);//大文字変換


$dept_arr = ['M' => '機械工学科', 'E' => '電気電子工学科', 'D' => '電子制御工学科', 'J' => '情報工学科', 'C' => '環境都市工学科'];//連想配列で学科名を置換

foreach($dept_arr as $key => $value){
  if($_SESSION['dept'] == $key) $dept = $value;//学科名変換
}

include('./template/define.php');
$title .= "ネットワーク申請 入力確認";
include('./template/top.php');
?>
  <div class="container">
    <div id="main" class="col-md-10">
      <h1>学寮ネットワーク 入力確認</h1>

      <?php // セッション判定
      if(!isset($_SESSION['mac_address'])): ?>
        <h3 style="color: #b92c28" class="col-md-offset-2">セッションの有効期限が切れました。<a href="./application-form">元のページに戻り</a>再登録を行ってください。</h3>
      <?php endif; ?>

      <h4 style="padding-bottom: 40px">以下の内容で間違いがないか確認してください。<br>間違いがある場合<a href="./application-form">元のページに戻り</a>訂正を行ってください。
      </h4>


      <form id="application" class="form-horizontal" role="form" action="application-form-complete" method="post">

        <div class="form-group">
          <label for="selectPlace" class="col-sm-2 col-sm-offset-1 control-label">性別</label>

          <div class="col-md-4">
            <input type="text" class="form-control" name="room" id="room"
                   value="<?php if($_SESSION['gender'] == 'male') echo '男子'; elseif($_SESSION['gender'] == 'female') echo '女子' ?>"
                   disabled>
          </div>
        </div>

        <div class="form-group">
          <label for="proj" class="col-md-2 col-md-offset-1 control-label">部屋番号</label>

          <div class="col-md-4">
            <input type="text" class="form-control" name="room" id="room" value="<?php echo $_SESSION['room'] ?>"
                   disabled>
          </div>
        </div>

        <div class="form-group">
          <label for="class" class="col-md-2 col-md-offset-1 control-label">学科 / 学年</label>
          <div class="col-md-4">
            <input type="text" class="form-control" name="room" id="room" value="<?php echo $dept . ' ' . $_SESSION['grade'] . '年 ' ?>" disabled>
          </div>
        </div>

        <div class="form-group">
          <label for="proj" class="col-md-2 col-md-offset-1 control-label">学籍番号</label>

          <div class="col-md-4">
            <input type="text" class="form-control" name="student-id" id="student-id"
                   value="<?php echo $_SESSION['student_id'] ?>" disabled>
          </div>
        </div>


        <div class="form-group">
          <label for="name" class="col-md-2 col-md-offset-1 control-label">名前(ローマ字)</label>

          <div class="col-md-7">
            <div class="row">
              <div class="col-md-6">
                <input type="text" class="form-control" name="last-name-roma"
                       value="<?php echo $_SESSION['last_roma_name'] ?>" disabled>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" name="first-name-roma"
                       value="<?php echo $_SESSION['first_roma_name'] ?>" disabled>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="name" class="col-md-2 col-md-offset-1 control-label">名前</label>

          <div class="col-md-7">
            <div class="row">
              <div class="col-md-6">
                <input type="text" class="form-control" name="last-name" value="<?php echo $_SESSION['last_name'] ?>"
                       disabled>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" name="first-name" value="<?php echo $_SESSION['first_name'] ?>"
                       disabled>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="proj" class="col-md-2 col-md-offset-1 control-label">MACアドレス</label>

          <div class="col-md-4">
            <input type="text" class="form-control" name="mac-address" id="mac-address"
                   value="<?php echo $_SESSION['mac_address'] ?>" disabled>
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