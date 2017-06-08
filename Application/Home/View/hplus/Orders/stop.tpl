<extend name="Public/base"/>
<block name="main">
    <input type=hidden id="czid" checked>
    <div class="form-inline searchbar">
        <div class="pull-right btn-group pdl-10" role="group" aria-label="...">
            <php>if(strpos(getUserCzqx(),"挂单删除")>-1){</php>
                <button id="delFun" class="btn btn-danger">Delete</button>
            <php>}</php>
            <button type="button" class="btn btn-info" id="btnRefresh"><i class="fa fa-refresh"></i></button>
        </div>
        <form class="layui-form">
            <div class="layui-form-inline" >
                <div class="layui-input-inline" style="width: 150px">
                    <input type="text" id="ctitle" name="ctitle" placeholder="Company Name" autocomplete="off" class="layui-input" col="6">
                </div>
                <div class="layui-input-inline" style="width: 150px">
                    <select id='etitle' name="etitle">
                        <option value=0>Expo</option>
                        <volist name=":ShowList('expo','','id')" id="vo">
                            <option value="{$vo.title}">{$vo.title}</option>
                        </volist>
                    </select>
                </div>
                <div class="layui-input-inline" style="width: 150px">
                    <select id='reson' lay-filter="searchselect" col="0">
                        <option value=0>Decline reason</option>
                        <volist name=":ShowList('class','parid=1661','id')" id="vo">
                            <option value="{$vo.id}">{$vo.classname}</option>
                        </volist>
                    </select>
                </div>
                <div class="layui-input-inline" style="width: 150px">
                    <select id='customer' lay-filter="searchselect" col="5">
                        <option value=0>Acct. Manager</option>
                        <volist name=":ShowList('users','','id')" id="oi">
                            <option value="{$oi.id}">{$oi.username}</option>
                        </volist>
                    </select>
                </div>
                <div class="layui-input-inline" style="width: 150px">
                    <input  class="layui-input dates" placeholder="Decline from" name="starttime" id="starttime" onclick="layui.laydate({elem: this, festival: true})">
                </div>
                <div class="layui-input-inline" style="width: 150px">
                    <input  class="layui-input dates" placeholder="Decline till" name="endtime" id="endtime" onclick="layui.laydate({elem: this, festival: true})">
                </div>
                <div class="layui-input-inline">
                    <a class="layui-btn layui-btn-small layui-btn-normal" id="orderssub">Search</a>
                </div>
            </div>
        </form>
    </div>
    <div class="bg-info msgbox">
        Updated information: Total space area:<b style="color:red;"><span id="allTotal1"></span> </b></a>㎡
        <!--当前统计:
        展会面积总计<a href="javascript://"><b style="color:red;"> <span id="allTotal2"></span> </b></a> ㎡
        -->
    </div>
    <table id="ListTbl" class="table table-striped table-bordered hover">
        <thead>
        <tr class="bg-info">
            <th width="3%">No.</th>
            <th width="3%"><input class=SelectAllId type=checkbox sname="id[]"></th>
            <th width="14%">Expo</th>
            <th width="12%">Company Name</th>
            <th width="15%">Decline Reason</th>
            <th width="12%">Remarks</th>
            <th width="13%">Decline Date</th>
            <th width="13%">Acct. Manager</th>
            <th width="6%">Operation</th>
            <th width="5%">ID</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <script>
        /*基础设置*/
        resetFrom();
        $("#delFun").click(function(){
            var czid = '';
            $("input[name='id[]']:checked").each(function (i, n) {
                if (i == 0) {
                    douhao = "";
                } else {
                    douhao = ",";
                }
                czid += douhao + $(n).val();
            });
            layer.confirm('Confirm delete?', {
                btn: ['Yes','No'], //按钮
                title:"information"
            }, function() {
                $.ajax({
                    url: "?act=del&czid=" + czid,
                    type: "post",
                    success: function (res) {
                        if (res.code == 1) {
                            resetFrom();
                            layer.msg('Delete success', {icon: res.code});
                            table.ajax.reload(null, false);
                        } else {
                            layer.msg(res.msg, {icon: res.code});
                        }
                    }, error: function (error) {
                        layer.msg('Request error', {icon: 2});
                        console.log(error);
                    }
                });
            });
        });
        /*初始化表格*/
        var table = $('#ListTbl').DataTable({
            "processing": true,
            "serverSide": true,
            stateSave: false,          //状态保存，使用了翻页或者改变了每页显示数据数量，会保存在cookie中，下回访问时会显示上一次关闭页面时的内容。
            bLengthChange: true,      //改变每页显示数据数量功能开启
            aLengthMenu: [10],        //设置每页显示数据数量
            "order": [[5, 'desc']],
            columnDefs:[{
                orderable:false,        //禁用排序
                targets:[0,1]             //指定的禁用排序列,多个用逗号隔开[0,1]
            }],
            sDom: '<"top">rt<"bottom"ip><"clear">',
            //改变页面上元素的位置
            //语法结构:*<>表示一个闭合DIV l - 每行显示的记录数 f- 搜索框 t- 表格 i- 表格信息 p- 分页条r- 加载时的进度条*/
            bProcessing:true,
            createdRow: function( row, data, dataIndex ) {
//                $(row).children('td').eq(1).attr('style', 'text-align: left;')
            },
            paging:true,              //是否显示分页
            ordering: true,           //是否支持排序功能
            info:true,                //显示表格信息
            searching: true,          //开启刷选功能
            autoWidth: false,
            ajax:{
                url:"?show=showDataTbaleToGuaDan",
                data: function ( d ) {
                    d.ctitle = $('#ctitle').val();
                    d.etitle = $('#etitle').val();
                    d.reson = $('#reson').val();
                    d.customer = $('#customer').val();
                    d.starttime = $('#starttime').val();
                    d.end = $('#endtime').val();
                },
                dataType:"json",
                "dataSrc": function ( json ) {
                    $('#allTotal1').html(json.allTotal['1']);
                    return json.data;
                }
            }
        });
        var seach = "<div class='searchstyle'><input type='text' id='pagesvalue' style='width: 35px;height: 30px;' /><button class='layui-btn layui-btn-normal search-btn' id='search'>GO</button></div>";
        $('#ListTbl_info').after(seach);
        _customSearch(table);
        /*单个删除方法*/
        $(document).on('click','.delgd',function(){
            var id=$(this).attr('czid');
                layer.confirm('Confirm delete?', {
                    btn: ['Yes','No'], //按钮
                    title:"information"
                }, function() {
                    $.ajax({
                        url: "?act=del&czid=" + id,
                        type: "post",
                        success: function (res) {
                            if (res.code == 1) {
                                resetFrom();
                                layer.msg('Delete success', {icon: res.code});
                                table.ajax.reload(null, false);
                            } else {
                                layer.msg(res.msg, {icon: res.code});
                            }
                        }, error: function (error) {
                            layer.msg('Request error', {icon: 2});
                            console.log(error);
                        }
                    });
                });
                $('#czid').val('');
        });
        $('#orderssub').click(function(){
            table.draw();
        });
        //监听跳转事件
        $('#search').click(function(){
            var value=$("#pagesvalue").val()-1;
            table.page(value).draw(false);
        });
    </script>
</block>
