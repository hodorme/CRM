<extend name="Public/base"/>
<block name="main">
    <input type=hidden id="czid" checked>
    <div class="form-inline searchbar">
        <div class="pull-right btn-group pdl-10" role="group" aria-label="...">
            <php>if(strpos(getUserCzqx(),"意向删除")>-1){</php>
                <button id="delFun" class="btn btn-danger">Delete</button>
            <php>}</php>
            <button type="button" class="btn btn-info" id="btnRefresh"><i class="fa fa-refresh"></i></button>
        </div>
        <form class="layui-form">
            <input type="hidden" name="showD" value="{$showD}">
            <div class="layui-input-inline" style="width: 150px">
                <input class="layui-input" type="text" placeholder="Company Name" name="company" id="company">
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <input class="layui-input" type="text" placeholder="Country" name="country" id="country">
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <select name="expo" id="expo">
                    <option value=0>Expo</option>
                    <volist name=":ShowList('expo','','id')" id="oi">
                        <option value="{$oi.id}">{$oi.title}</option>
                    </volist>
                </select>
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <select name="probability" id="probability">
                    <option value=0>Close probability</option>
                    <volist name=":ShowList('class','parid=1652','id')" id="oi">
                        <option value="{$oi.id}">{$oi.classname}</option>
                    </volist>
                </select>
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <input  class="layui-input dates" placeholder="Est. start" name="starttime" id="starttime" onclick="layui.laydate({elem: this, festival: true})">
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <input  class="layui-input dates" placeholder="Est. close" name="endtime" id="endtime" onclick="layui.laydate({elem: this, festival: true})">
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <select name="khuser" id="khuser">
                    <option value=0>Acct. Manager</option>
                    <volist name=":ShowList('users','','id')" id="oi">
                        <option value="{$oi.id}">{$oi.username}</option>
                    </volist>
                </select>
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <select name="bumen" id="bumen">
                    <option value=0>Department</option>
                    <volist name=":ShowList('bumen','','id')" id="oi">
                        <option value="{$oi.id}">{$oi.classname}</option>
                    </volist>
                </select>
            </div>
            <div class="layui-input-inline">
                <a class="layui-btn layui-btn-small layui-btn-normal"  id="orderssub" >Search</a>
            </div>
        </form>
    </div>
    <ul class="nav nav-tabs">
        <li <if condition="$showD eq ''">class=active</if>> <a href="?showD=">my leads</a></li>
        <li <if condition="$showD eq 'allleads'">class=active</if>> <a href="?showD=allleads">all leads</a></li>
    </ul>
    <div class="bg-info msgbox">
        Under current searching conditions,
        total exhibiting space proposed:<b style="color:red;"><span id="count"></span></b> ㎡。
    </div>
    <table id="ListTbl" class="table table-striped table-bordered hover">
        <thead>
        <tr class="bg-info">
            <th width="3%" style="line-height:30px">No.</th>
            <th width="2%"><input class=SelectAllId type=checkbox sname="yxid[]" style="margin-bottom:7px;"></th>
            <th width="13%" style="line-height:30px">Company Name</th>
            <th width="6%" style="line-height:30px">Country</th>
            <th width="13%" style="line-height:30px">Expo</th>
            <th width="5%">Close Probability</th>
            <th width="10%" style="line-height:30px">Est. Close Date</th>
            <th width="5%" style="line-height:30px">Size</th>
            <th width="8%">Last Contact Time</th>
            <th width="6%">Acct. Manager</th>
            <th width="6%" style="line-height:30px">Status</th>
            <th width="5%" style="line-height:30px">Operation</th>
            <th width="3%" style="line-height:30px">ID</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script>
        /*基础设置*/
        resetFrom();
        $("#delFun").click(function(){
            _del(table,'yxid[]');
        });
        $("#orderssub").click(function(){
            var param=$("form").serialize();
            table.ajax.url("?show=showDataTbale&"+param).load();
        })
        /*初始化表格*/
        var table = $('#ListTbl').DataTable({
            "processing": true,
            "serverSide": true,
            stateSave: false,          //状态保存，使用了翻页或者改变了每页显示数据数量，会保存在cookie中，下回访问时会显示上一次关闭页面时的内容。
            bLengthChange: true,      //改变每页显示数据数量功能开启
            aLengthMenu: [10],        //设置每页显示数据数量
            "order": [[4, 'desc']],
            columnDefs:[{
                orderable:false,        //禁用排序
                targets:[0,1]             //指定的禁用排序列,多个用逗号隔开[0,1]
            }],
            sDom: '<"top">rt<"bottom"ip><"clear">',
            //改变页面上元素的位置
            //语法结构:*<>表示一个闭合DIV l - 每行显示的记录数 f- 搜索框 t- 表格 i- 表格信息 p- 分页条r- 加载时的进度条*/
            bProcessing:true,
            createdRow: function( row, data, dataIndex ) {
                $(row).children('td').eq(4).attr('style', 'text-align: left;')
            },
            paging:true,              //是否显示分页
            ordering: true,           //是否支持排序功能
            info:true,                //显示表格信息
            searching: true,          //开启刷选功能
            autoWidth: false,
//            ajax:"?show=showDataTbale"
            ajax:{
                //contentType: "application/json",   //这段代码不要加，我时延的是否后台会接受不到数据
                url:"?show=showDataTbale&showD={$showD}",
                dataType:"json",
                "dataSrc": function ( json ) {
                    $('#count').html(json.sum);
                    return json.data;
                }
            },
        });
        var seach = "<div class='searchstyle'><input type='text' id='pagesvalue' style='width: 35px;height: 30px;' /><button class='layui-btn layui-btn-normal search-btn' id='search'>GO</button></div>";
        $('#ListTbl_info').after(seach);
        _customSearch(table);
        /*单击选择 */
        $('#ListTbl').on('click','tbody tr',function () {
            var czid=$(this).find("td:last").text();;
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $('#czid').val('');
            }else{
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                $('#czid').val(czid);
            }
        });
        /*编辑意向单*/
       $(document).on('click','.edityxd',function(){
           var title = "Edit Intent list";
           var czid=$(this).attr('czid');
           var cid=$(this).attr('cid');
           var url ="{:U('Customer/addintention')}?czid="+czid+"&cid="+cid;
           _layerOpen(url, title, '80%', '100%');
       })
        /*转为订单*/
        $(document).on('click','.zdd',function(){
            var title = "Turn to order";
            var czid=$(this).attr('czid');
            var url ="{:U('Orders/zhuandd')}?czid="+czid;
            _layerOpen(url, title, '80%', '100%');
        })
        /*转为挂单*/
        $(document).on('click','.zgd',function(){
            var title = "Move to lost";
            var czid=$(this).attr('czid');
            var url ="{:U('Orders/zhuangd')}?czid="+czid;
            _layerOpen(url, title, '80%', '100%');
        })
        $('#search').click(function(){
            var value=$("#pagesvalue").val()-1;
            table.page(value).draw(false);
        });
        <!--添加联系记录-->
        $(document).on("click","#tjlxr",function(){
            var czid = $(this).attr('czid');
            $.ajax({
                url: "{:U('Home/Customer/ismember')}?czid="+czid,
                dataType: 'json',
                type: "post",
                success: function (res) {
                    if(res.code==1){
                        var title="Add contact record";
                        var url="{:U('Home/Customer/addlianxijilu')}?cid="+czid;
                        _layerOpen(url, title,'80%', '100%');
                    }else if(res.code==2){
                        layer.msg('Please add a contact');
                        var title='Add a Contact';
                        var url = "{:U('Home/Customer/addlianxiren')}?cid="+czid;
                        _layerOpen(url, title, '80%', '100%');
                    }
                }, error: function (error) {
                    layer.msg('Request error', {icon: 2});
                    console.log(error);
                }
            });
        });
    </script>
</block>
