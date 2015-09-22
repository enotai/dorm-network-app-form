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



/*===MACアドレス取得(シェルスクリプト実行)===*/
$ip_addr = $_SERVER["REMOTE_ADDR"];
$agent = $_SERVER['HTTP_USER_AGENT'];
$mac_addr = `/usr/sbin/arp -an | /bin/grep $ip_addr | /usr/bin/cut -d' ' -f 4`;
$mac_addr = substr($mac_addr, 0, -1);
$mac_addr = strtoupper($mac_addr);


/*===POST内容取得===*/
$gender = $grade = $dept = $student_id = $last_roma_name = $first_roma_name = $last_name = $first_name = $mac_address = $agreement = "";

$gender=s($_POST['gender']);//性別
$room=s($_POST['room']);//部屋番号
$grade=s($_POST['grade']);//学年
$dept=s($_POST['dept']);//学科
$student_id=s($_POST['student-id']);//学籍番号
$last_roma_name=s($_POST['last-name-roma']);//姓(roma)
$first_roma_name=s($_POST['first-name-roma']);//名(roma)
$last_name=s($_POST['last-name']);//姓
$first_name=s($_POST['first-name']);//名
$mac_address=s($_POST['mac-address']);//MACアドレス
$agreement=s($_POST['agreement']);//規約書に同意したか


/*===POST内容確認===*/
if(!$gender == ('male' | 'female')) $gender_error=1;
if(!preg_match('/^[0-9]{3}$/', $room)) $room_error=1;
if(!preg_match('/^[1-5]$/', $grade)) $grade_error=1;
if(!preg_match('/^[M|E|D|J|C]$/', $dept)) $dept_error=1;
if(!preg_match('/^[0-9]{2}-([1-5]|9)[0-5][0-9]$/', $student_id)) $student_id_error=1;
if(!preg_match('/^[a-zA-Z]+$/', $last_roma_name)) $last_roma_name_error=1;
if(!preg_match('/^[a-zA-Z]+$/', $first_roma_name)) $first_roma_name_error=1;


if(!preg_match('/^([0-9a-fA-F]{2}:){5}[0-9a-fA-F]{2}$/', $mac_address)) $mac_address_error=1;
if(!$agreement) $agreement_error=1;


/*===確認ページへ移動===*/
if(!($gender_error | $room_error | $grade_error | $dept_error | $student_id_error | $last_roma_name_error | $first_roma_name_error | $mac_address_error | $agreement_error)){

  $query = 'gender='. $gender . '&grade=' . $grade . '&dept=' . $dept . '&room=' . $room . '&student-id=' . $student_id . '&last-name-roma=' . $last_roma_name . '&first-name-roma=' . $first_roma_name . '&last-name=' . $last_name . '&first-name=' . $first_name . '&mac-address=' . $mac_address . '&agreement=' . $agreement;//confirmに送る文字列

  header("Location: ./application-form-confirm?" . $query);//confirmに移動
}






include('./template/define.php');
$title .= "ネットワーク申請フォーム";
include('./template/top.php');
?>
  <div class="container">
    <div id="main" class="col-md-10">
      <h1>学寮ネットワーク 申請フォーム</h1>


      <form id="application" class="form-horizontal" role="form" action="application-form.php" method="post">

        <div class="form-group">
          <label for="selectPlace" class="col-sm-2 col-sm-offset-1 control-label">性別</label>

          <div class="col-sm-7">
            <div class="row">
              <div class="col-md-3">
                <label class="radio-inline">
                  <input type="radio" name="gender" id="dorm-male" value="male"> 男子
                </label>
              </div>
              <div class="col-md-3">
                <label class="radio-inline">
                  <input type="radio" name="gender" id="dorm-female" value="female"> 女子
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="proj" class="col-md-2 col-md-offset-1 control-label">部屋番号</label>

          <div class="col-md-4">
            <input type="text" class="form-control" name="room" id="room" placeholder="107" value="<?php echo $room ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="class" class="col-md-2 col-md-offset-1 control-label">学年 / 学科</label>

          <div class="col-md-7">
            <div class="row">
              <div class="col-md-6">
                <select class="form-control" name="grade">
                  <option value="1">1年</option>
                  <option value="2">2年</option>
                  <option value="3">3年</option>
                  <option value="4" selected>4年</option>
                  <option value="5">5年</option>
                  <option value="6">専攻科</option>
                </select>
              </div>

              <div class="col-md-6">
                <select class="form-control" name="dept">
                  <option value="M">機械工学科</option>
                  <option value="E" selected>電気電子工学科</option>
                  <option value="D">電子制御工学科</option>
                  <option value="J">情報工学科</option>
                  <option value="C">環境都市工学科</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="proj" class="col-md-2 col-md-offset-1 control-label">学籍番号</label>

          <div class="col-md-4">
            <input type="text" class="form-control" name="student-id" id="student-id" placeholder="12-227" value="<?php echo $student_id ?>">
          </div>
        </div>


        <div class="form-group">
          <label for="name" class="col-md-2 col-md-offset-1 control-label">名前(ローマ字)</label>

          <div class="col-md-7">
            <div class="row">
              <div class="col-md-6">
                <input type="text" class="form-control" name="last-name-roma" placeholder="sei" value="<?php echo $last_roma_name ?>">
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" name="first-name-roma" placeholder="mei" value="<?php echo $first_roma_name ?>">
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="name" class="col-md-2 col-md-offset-1 control-label">名前</label>

          <div class="col-md-7">
            <div class="row">
              <div class="col-md-6">
                <input type="text" class="form-control" name="last-name" placeholder="姓" value="<?php echo $last_name ?>">
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" name="first-name" placeholder="名" value="<?php echo $first_name ?>">
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="proj" class="col-md-2 col-md-offset-1 control-label">MACアドレス</label>

          <div class="col-md-4">
            <input type="text" class="form-control" name="mac-address" id="mac-address" placeholder="" value="<?php echo $mac_address ?>">
            <p class="text-primary">上記には現在使用しているパソコンの<br>MACアドレスが表示されています</p>
          </div>
        </div>

        <div class="col-md-offset-2" style="margin-top: 60px">
          <h3>学寮ネットワークを使うにあたっての規定</h3>
          <textarea cols="100" rows="15" readonly>・ 勉学・学術研究のために利用します．
            ・ 著作権の侵害をいたしません．
            ・ 著作物を容易にアップロード・ダウンロードできるソフトウェア（Winny，Share等）は使用いたしません．
            ・ VPN、VPS及び学術目的内においてもサーバを圧迫するような行為をいたしません。
            ・ 物品の売買における着払いの利用、及びオークションは使用しません。．
            ・ ネチケットに反する行為をいたしません．
            電子掲示板，メーリングリスト，チャット等での誹謗中傷をいたしません．
            個人情報公開の乱用をいたしません．
            公序良俗に反する利用をいたしません．
            ・ 割り当てられるIPアドレスを不正に利用しません．
            ・ コンピュータウィルス対策ソフトを導入いたします．
            ・ 大きなサイズのファイルをダウンロードいたしません．
            ・ 常時電源投入いたしません．
            ・ バグを発見した際にも、サーバーへの不正アクセス、不正登録などせず、ネットワーク委員長に報告します。
          </textarea>


          <div class="form-group">
            <div class="row">
              <div class="col-md-6 col-md-offset-2">
                <label class="checkbox-inline">
                  <input type="checkbox" name="agreement" id="agreemet" value="true"> <strong>上記の規約に同意します。</strong>
                </label>
              </div>
            </div>
          </div>

        </div>
        <div class="form-group"><!-- 登録ボタン -->
          <div class="col-md-offset-3 col-md-7 text-center">
            <div class="row">
              <div class="col-md-6">
                <button type="submit" class="btn btn-lg btn-block btn-primary" id="register">登録
                </button>
              </div>
              <div class="col-md-6">
                <button type="reset" class="btn btn-lg btn-block btn-default" onclick="location.reload();"><span
                    class="glyphicon glyphicon-remove"></span> リセット
                </button>
              </div>
            </div>
          </div>
        </div>


      </form>
    </div>
  </div>



<?php include('./template/bottom.php'); ?>