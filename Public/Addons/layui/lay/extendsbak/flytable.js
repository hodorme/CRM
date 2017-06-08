/**
 * table扩展表格模块
 */
layui.define(function(exports){
   var tableConf = {
       getTable: function(e){
           var th =[];
           for(var i = 0,len = e.cloumnNm.length; i < len;++i){
               th.push("<th id="+e.cloumnNm[i].id+">"+e.cloumnNm[i].name+"</th>");
           }
           th = th.join("");
           var tb =[];
           for(var i = 0,len = e.tbNm.length; i< len;++i){
               tb.push("<td>"+e.tbNm[i].name+"</td>");
           }
           tb = tb.join("");
           var tf =[];
           for(var i = 0,len = e.tfNm.length; i< len;++i){
               tf.push("<td>"+e.tfNm[i].name+"</td>");
           }
           tf = tf.join("");
           var tabletpl = "<table class='layui-table' lay-even>" +
               "<thead>" +
               "<tr>" +
               th +
               "</tr>" +
               "</thead>" +
               "<tbody id='"+ e.id.tbvid[0] +"'>" +
               "</tbody>" +
               "<script id='"+ e.id.tbid[0] +"' type='text/html'>" +
               "{{# for(var i = 0, len = d.values.length; i < len; i++){ }}" +
               "<tr>" +
               tb +
               "</tr>" +
               "{{# } }}" +
               "{{# if(d.values.length === 0){ }}" +
               "<div style='text-align: center;font-size: 14px'>没有查询到任何有用的数据</div>" +
               "{{# } }}" +
               "</script>" +
               "<tfoot id='"+ e.id.tfvid[0] +"'>" +
               "</tfoot>" +
               "<script id='"+ e.id.tfid[0] +"' type='text/html'>" +
               "<tr>" +
               tf +
               "</tr>" +
               "</script>" +
               "</table>";
           $(e.table[0]).append(tabletpl);
       }
   };

    //输出tableConf接口
    exports('flytable',tableConf);
});