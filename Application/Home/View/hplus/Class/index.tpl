<extend name="Public/base" />
<block name="main">
    <input type=hidden id="czid" checked>
    <input type=hidden id="flid" checked>
    <div class="col-md-3">
        <ul id="layTree"></ul>
    </div>
    <div class="col-md-9">
        <div class="form-inline searchbar">
            <div class="pull-right btn-group pdl-10" role="group" aria-label="...">
                <button id="addFun" class="btn btn-success"><i class="fa fa-plus"></i></button>
                <button id="delFun" class="btn btn-danger"><i class="fa fa-remove"></i></button>
                <button id="btnRefresh" class="btn btn-info" ><i class="fa fa-refresh"></i></button>
            </div>
            <form action="" class="layui-form" >
                <div class="layui-form-inline">
                    <div class="layui-input-inline" style="width: 150px">
                        <input class="layui-input sbtn" type="text" placeholder="请输入功能名称" col="0">
                    </div>
                </div>
            </form>
        </div>
        <table id="ListTbl" class="table table-striped table-bordered hover">
            <thead>
                <tr class="bg-info">
                    <th>排序</th>
                    <th><input class=SelectAllId type=checkbox sname="classid[]"></th>
                    <th>功能名称</th>
                    <th>操作</th>
                    <th>ID</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <script>
        $("#delFun").click(function(){
            _del(table,'classid[]');
        });
        layui.use(['tree'], function(){
            layui.tree({
                elem: '#layTree' //指定元素
                ,target: '_self' //是否新选项卡打开（比如节点返回href才有效）
                ,click: function(item){ //点击节点回调
                    $("#flid").val(item.id);
                    table.ajax.url("?show=showDataTbale&parid="+item.id).load();
                }
                ,nodes: {:getLayTree('Class','classname',0);}
            });
        });
        /*基础设置*/
        resetFrom();
        var table = $('#ListTbl').DataTable({
            "processing": true,//显示加载进度条
            "sDom": '<"top">rt<"bottom"ip><"clear">',
            "createdRow": function ( row, data, index ) {
//                $('td', row).eq(2).css("text-align","left"); //标题单元格居左对齐
            },
            "order": [[0, 'desc']],
            columnDefs:[{
                orderable:false,//禁用排序
                targets:[0,1]   //指定的列
            }],
            "bServerSide": true,//开启服务器端模式
            "ajax": "?show=showDataTbale"
        });
        _customSearch(table);
        /*单击选择 */
        $('#ListTbl').on('click','tbody tr',function () {
            var czid=$(this).find("td:last").text();
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $('#czid').val(czid);
            }else{
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                $('#czid').val(czid);
            }
        });
        $('#ListTbl').on('dblclick','tbody tr',function () {
            var czid=$(this).find("td:last").text();
            $('#czid').val(czid);
            _save("edit");
        });
        $("#addFun").click(function(){
            var flid=$('#flid').val();
            var canshu="flid="+flid;
            var title = "添加类别";
            var url ="{:U('add')}?"+canshu;
            _layerOpen(url, title, '30%', '40%');
        });
        $(document).on('click','.edit',function () {
            var title = "修改类别";
            var czid=$(this).attr('czid');
            var url ="{:U('edit')}?czid="+czid;
            _layerOpen(url, title, '30%', '40%');
        });
    </script>
</block>
