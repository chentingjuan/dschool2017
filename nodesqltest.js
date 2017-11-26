var json = require('json-file')
var file = 'gw_u_m_events.json'
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
      title: obj.title,
      content: obj.content,
      cover: obj.img,
      cata: obj.index_in,
      date: obj.date,
      link: obj.link,
      show: obj.release_in,
      description: obj.list_content,
      created_at: obj.created_time,
      updated_at: obj.updated_time,

    }))
    .forEach(d=>{
      connection.query('INSERT INTO `posts` SET ?', d, function(error){
          if(error){
              console.log('寫入資料失敗！');
              throw error;
          }
      });
  })
  connection.end();

});