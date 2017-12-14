管理者您好，以下是設備借用申請資訊：<br><br>
申請者姓名：{{$name}} <br>
電話：{{$phone}} <br>
原因：{{$reason}} <br>
借用開始時間：{{$start_datetime}} <br>
借用結束時間：{{$end_datetime}} <br>
填寫申請時間：{{ $created_at }} <br>
原因：{{$reason}} <br>
是否帶出學院：{{$bringout?"是":"否"}} <br>
<br>
列表：
<ol>
  @foreach( $equip_rent_record as $eqip_rr)
  <li> {{ $eqip_rr["equipment"]["name"] }} x {{ $eqip_rr["equipment"]["count"] }} </li>
  @endforeach
</ol>
<br>
<br>
請前往 <a href="http://2017.dschool.edu.tw/service/equipment">管理介面</a> 進行確認
<br><br>
<hr>
<br>
<p>
<img src="http://dschool.ntu.edu.tw/assets/images/logo.jpg" style="max-width: 250px">
<br>
<br>
▍地址 Address:
10087 台北市中正區思源街18號卓越研究大樓四樓
<br>
▍電話 Tel:
02-3366-1869
<br>
▍信箱 Email:
ntudschool@ntu.edu.tw
</p>
<br>
<br>