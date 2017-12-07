var json = require('json-file')
var file = 'gw_u_m_about_team.json'
// jsonfile.readFile(file, function (err, obj) {
//   console.dir(err)
// })

// Likewise, this... 
var fs = require("fs")
var data = fs.readFile(file, "utf8",function(err,data){
  // console.log(data)
  var jsondata = JSON.parse(data)
  console.log(jsondata)
  //載入MySQL模組
  var mysql = require('mysql');
  //建立連線
  var connection = mysql.createConnection({
      host: '127.0.0.1',
      user: 'root',
      password: '@##434frt))',
      database: 'dschool2017'
  });
  //開始連接
  connection.connect();
  jsondata
    .map(obj=>({
        order_id: obj.order_id,
        show: obj.show,
        company: obj.Company,
        name: obj.name,
        cover: "http://dschool.ntu.edu.tw" + obj.cover,
        position: obj.position,
        cata: obj.cata,
        phone: obj.phone,
        email: obj.email,
        content: obj.content,
    }))
    .forEach(d=>{
      connection.query('INSERT INTO `teammembers` SET ?', d, function(error){
          if(error){
              console.log('寫入資料失敗！');
              throw error;
          }
      });
  })
  connection.end();

});