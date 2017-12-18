{{$name}} 您好：<br><br>

{{$bringout?("此次借用為攜出學院使用，須繳納押金總額為 ".$ensure_money."元 整，"):""}}
請於{{$start_datetime}}至創新設計學院R409室繳納押金並領取設備，<br>
若未準時領取將取消當次借用申請，累計2次將列入黑名單，此後不予借用設備。<br>
若無法於上述時間前來領取設備，或需要取消申請，請來信通知，<br>
信件主旨請以「【設備借用】」開頭（包含【】此符號）。<br>
您申請借用之設備借用審核結果如下：<br>
<br>
<table>
  <thead style="border-bottom: solid 2px black;">
    <th>審核結果</th>
    <th>設備名稱</th>
    <th>型號</th>
    <th>數量</th>
  </thead>
  @foreach( $equip_rent_record as $eqip_rr)
  <tr>
    <td style="padding: 5px 10px">{{ $eqip_rr["status"]=="yes"?"通過":"不通過" }} </td>
    <td style="padding: 5px 10px">{{ $eqip_rr["equipment"]["name"] }} </td>
    <td style="padding: 5px 10px">{{ $eqip_rr["equipment"]["model"] }} </td>
    <td style="padding: 5px 10px">{{ $eqip_rr["count"] }} </td>
  </tr>
  @endforeach
</table>

<br>

借用時間至{{ $end_datetime }}止，請準時歸還設備。<br>
<br>

<br>
敬祝順心<br>
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
02-3366-1869 分機9
<br>
▍信箱 Email:
ntudschool@ntu.edu.tw
</p>
<br>
<br>








【創新設計學院】設備借用審核結果