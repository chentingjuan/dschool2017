<template lang="pug">
  .power_table
    div(v-if="conf.show_search")
      .form-group-inline
        label Search: 
        input(v-model="search_keyword")
        .btn.btn-primary.pull-right(@click="export_csv") 匯出csv
        
    table.table.table-hover
      thead
        th(v-for = "row_key in (row_keys || default_row_keys)",
           @click = "set_sort_key(row_key)",
           v-if = "row_name_alias(row_key)!='__hide'")
          | {{ row_name_alias(row_key) }}
          span(v-if="row_key==sort_key && sort_direction") ▼
          span(v-if="row_key==sort_key && !sort_direction") ▲
          span(v-if="row_key!=sort_key ") 　
      tbody
        tr(v-for="(row,rid) in sliced_data", :key="rid")
          td(v-for = "row_key in (row_keys || default_row_keys)",
             v-if = "row_name_alias(row_key)!='__hide'")
            | {{ row[row_key] }}
          td
            .btn.btn-default(@click="edit(row)",
                             v-if="edit") {{edit_btn_text?edit_btn_text:'編輯'}}
            .btn-group
              .btn.grey.outline(
                v-for="btn in btns", 
                @click="btn.action(row)",
                :class="{active: func_exec(btn.class,row)}",
                v-if="get_show_status(btn,row)") {{btn.label}}
            //.btn.btn-danger 刪除
    .page_nav
      .btn-group
        .btn.grey.outline(v-if="pages.length>1",
                        v-for="p in pages",
                        :class="{active: page==p}",
                        @click="page=p") {{p}}
</template>

<script>
import Vue from 'vue'
// sorted -> sliced
export default {
  name: 'vue_lazy_table',
  props: ["table_data","row_keys","rows","configs","edit","dataTitle","edit_btn_text","btns"],
  data () {
    return {
      sort_key: null,
      sort_direction: true,
      conf: {
        show_id: true,
        show_search: true
      },
      search_keyword: "",
      page_split_num: 10,
      page: 1
    }
  },
  watch:{
  },
  mounted(){
    this.conf = Object.assign(this.conf,this.configs)
    console.log(this.configs)
  },
  computed: {
    default_row_keys(){
      //使用reduce 過濾初步重複欄位名稱（預設抓資料）
      let row_keys = Array.from(this.table_data).concat({}).reduce(
        (keys,data_row)=>keys.concat(Object.keys(data_row)),[]
      ).filter(
        (d,i,arr)=>arr.indexOf(d)==i
      )

      if (this.conf.show_id && row_keys.indexOf("id")==-1 ){
        row_keys.unshift("id")
      }

      return row_keys
    },
    sorted_data(){
      let data_clone = JSON.parse(JSON.stringify(this.table_data))

      let handlers = this.default_row_keys.map(key=>({key,handler: this.get_key_handler(key)}) )
      console.log(handlers)
      //if handler of key exist , compute handled value
      data_clone.forEach( (obj)=>{
        this.default_row_keys.forEach( (key)=>{
          let computed_handler= handlers.find(o=>o.key==key).handler
          if (computed_handler){
            obj[key]=computed_handler(obj[key])
          }
        })
      })

      if (data_clone){
        // add id col
        if (this.conf.show_id){data_clone.forEach( (o,id)=> {
            if (!o.id) { o.id = id}
          }
        )}

      
        //依照sortkey 排序
        let raw_sort = this.sort_key?data_clone.sort(
          (a,b)=>{
            var [var_a,var_b]= [a[this.sort_key],b[this.sort_key]]
            if (!isNaN(var_a))
              return parseFloat(var_a)< parseFloat(var_b)?1:-1
            else
              return var_a<var_b?1:-1
          }
        ):data_clone
        //search by content
        raw_sort=this.search_keyword==""?raw_sort:raw_sort.filter((o)=>Object.values(o).reduce((a,b)=>(a||(b+"").indexOf(this.search_keyword)!=-1),false)
        )

        return raw_sort
      }else{
        return []
      }
      
    },
    sliced_data(){
      let raw_sort = this.sorted_data.slice()
      let slice_pre = (this.sort_direction?raw_sort:raw_sort.reverse());
      let slice_post = slice_pre.slice( (this.page-1)*this.page_split_num,(this.page)*this.page_split_num )
      return slice_post
    },
    pages(){
      return Array.from( {length: Math.ceil(1.0*this.sorted_data.length / this.page_split_num) } , (d,i)=>i+1)
    },
    parse_items_list(){
      let list = this.rows?Array.from(this.rows):[];
      //可以用string "name | as" 也可以 {name: "name..",as: "as.."}
      let parse_items_list = 
        list.slice().map(o=>{
          if (typeof o == "string"){
            return {
              name: o.split(" -> ")[0],
              as: o.split(" -> ")[1].split(' | ')[0],
              arg: (o.split(" -> ")[1].split(' | ')[1]||"").split(",")
            }
          }else if  (typeof o == "object"){
            return Object.assign({
              as: null,
              arg: []
            },o)
          }
        })
      return parse_items_list
    }
  },
  methods: { 

    func_exec(func,para){
      return func(para)
    },
    //取得表格欄位的暱稱
    row_name_alias(row_name){
      let parse_items_list = this.parse_items_list
      //尋找每一行的別名
      var find_row = parse_items_list.find(o=>o.name==row_name)
      // console.log(list,find_row)
      if (find_row){
        return find_row.arg.find(o=>o.indexOf("hide")!=-1)?"__hide":(find_row.as || row_name)
      }
      return row_name
    },
    set_sort_key(key){
      if (this.sort_key!=key){
      }else{
        this.sort_direction=!this.sort_direction
        
      }
      this.sort_key=key
    },
    get_key_handler(key){
      let key_obj = this.parse_items_list.find(o=>o.name==key)
      return key_obj?key_obj.handler:null
    },
    export_csv(){
      
      let convertToCSV = function convertToCSV(objArray) {
          var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
          var str = '';

          for (var i = 0; i < array.length; i++) {
              var line = '';
              for (var index in array[i]) {
                  if (line != '') line += ','
                  let hasNL = (""+array[i][index]).indexOf("\n")>-1
                  if (hasNL) line+='"'
                  line += array[i][index];
                  if (hasNL) line+='"'
              }

              str += line + '\r\n';
          }

          return str;
      }

      let exportCSVFile = function exportCSVFile(headers, items, fileTitle) {
          if (headers) {
              items.unshift(headers);
          }

          // Convert Object to JSON
          var jsonObject = JSON.stringify(items);

          var universalBOM = "\uFEFF";
          var csv = convertToCSV(jsonObject);

          var exportedFilenmae = fileTitle + '.csv' || 'export.csv';

          var blob = new Blob(["\ufeff",csv], { type: 'text/csv;charset=utf-8;' });
          if (navigator.msSaveBlob) { // IE 10+
              navigator.msSaveBlob(blob, exportedFilenmae);
          } else {
              var link = document.createElement("a");
              if (link.download !== undefined) { // feature detection
                  // Browsers that support HTML5 download attribute
                  var url = URL.createObjectURL(blob);
                  link.setAttribute("href", url);
                  link.setAttribute("download", exportedFilenmae);
                  link.style.visibility = 'hidden';
                  document.body.appendChild(link);
                  link.click();
                  document.body.removeChild(link);
              }
          }
      }

      let rkey = this.row_keys || this.default_row_keys;
      let headers = {};
      rkey.forEach(o=>headers[o]=o)

      var fileTitle = this.dataTitle || "資料匯出"; // or 'my-unique-title'
      let dateString = ( new Date().toLocaleDateString()).replace(/[\/\s\:]/g,"");
      exportCSVFile(headers, this.sorted_data, fileTitle + dateString); 

    },
    get_show_status(btn,row){
      if (typeof btn.show == "undefined"){
        return true
      }
      if (typeof btn.show == "boolean"){
        return btn.show
      }

      if (typeof btn.show == "function"){
        return btn.show(row)
      }
      return false
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="sass?indentedSyntax">
  *
    // border: solid 1px black
  th
    cursor: pointer
    user-select: none
    padding: 10px

  .fade-enter-active, .fade-leave-active 
    transition: opacity .5s

  .fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ 
    opacity: 0

</style>
