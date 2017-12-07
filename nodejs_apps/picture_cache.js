var request = require('request');
var http = require('http');
var https = require('https');
var fs = require('fs');

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

request('http://2017.dschool.ntu.edu.tw/api/post', function (error, response, body) {
    if (!error && response.statusCode == 200) {
      var posts = JSON.parse(body)

      function download(url,file,dir){
        if (!fs.existsSync(dir)) {
          fs.mkdirSync(dir);
        }
        var protocol = (url.indexOf("https") > -1 ? https : http)
        request(url, { encoding: 'binary' }, function (error, response, body) {
          fs.writeFile(dir+"/"+file, body, 'binary', function (err) {  });
        });
        // var requestResult = protocol.request(url, function (response) {
        //   response.pipe(file);
        // }).on("error", function (error) {
        //   console.log(error.message);
        // });

      }

      var list = []
      posts.forEach(post => {
        // download(post.cover, `${post.title}.jpg`,"post")
        list.push({
          url: post.cover,
          file: `${post.title}.jpg`,
          dir: "post"
        })
      })

      posts.forEach(post=>{
        let reg = /src=\"(.*?)\"/g
        let postspics = post.content.match(reg)
        console.log(postspics)
        if (!postspics) postspics=[]
        

       

        //download all pictures in content
        postspics.forEach( (pic,index) => {

          var downloadUrl = pic.slice(5, -1)
          if (downloadUrl.indexOf("/assets") == 0 && downloadUrl.indexOf("http") == -1){
            downloadUrl = "http://dschool.ntu.edu.tw/" + downloadUrl
          }
          list.push({
            url: downloadUrl,
            file: `${index}.jpg`,
            dir: "post/" + post.title 
          })
          post.content = post.content.replace(pic.slice(5, -1), `/storage/img/oldpost/${post.title}/${index}.jpg`)
          
        })
        // console.log(post.content)

        connection.query('UPDATE `posts` SET `content` = ? WHERE `id` = ?', [post.content, post.id], function (error) {
          if (error) {
            console.log('寫入資料失敗！');
            throw error;
          }
        });

        // connection.query('UPDATE `posts` SET `cover` = ? WHERE `id` = ?', [ post.cover , post.id], function (error) {
        //   if (error) {
        //     console.log('寫入資料失敗！');
        //     throw error;
        //   }
        // });
        
      })
      list.forEach(o=>{
        console.log("downloading..."+o.url)
        download(o.url, o.file, o.dir)
      })
      // console.log(pic_posts)
      

    }
})

// connection.end();