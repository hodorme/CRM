<extend name="Public/base"/>
<block name="main">
    <input type=hidden id="czid" checked>
    <div class="form-inline searchbar">
        <div class="pull-right btn-group pdl-10" role="group" aria-label="...">
            <php>if(strpos(getUserCzqx(),"客户删除")>-1){</php>
                <button id="sxdel" class="btn btn-danger">Delete</button>
            <php>}</php>
            <button type="button" class="btn btn-info" id="btnRefresh"><i class="fa fa-refresh"></i></button>
        </div>
        <div class="pull-right btn-group pdl-10" role="group" aria-label="...">
            <button id="addFun" class="btn btn-success">Add</button>
        </div>
        <form class="layui-form">
            <input type="hidden" name="showD" value="{$showD}">
            <div class="layui-input-inline" style="width: 150px">
                <input class="layui-input" type="text" placeholder="Company name" name="company" id="company">
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <input class="layui-input" type="text" placeholder="Country" name="country" id="country">
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <select name="classid" id="classid">
                    <option value=0>Customer Status</option>
                        <option value='Close-Won'>Close-Won</option>
                        <option value='Open'>Open</option>
                        <option value='Close-Lost'>Close-Lost</option>
                        <option value='None'>None</option>
                </select>
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <select name="type" id="type">
                    <option value=0>Type</option>
                    <volist name=":ShowList('class','parid=1642','id')" id="vo">
                        <option value='{$vo.id}'>-{$vo.classname}</option>
                    </volist>
                </select>
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <select name="industry" id="industry">
                    <option value=0>Industry</option>
                    <volist name=":ShowList('class','parid=1626','id')" id="vo">
                        <option value='{$vo.id}'>-{$vo.classname}</option>
                    </volist>
                </select>
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <input class="layui-input" type="text" placeholder="Contacts" name="fullname" id="fullname">
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <input class="layui-input" type="text" placeholder="Mobile Phone" name="mobile" id="mobile">
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <input  class="layui-input dates" placeholder="Searching date from" name="posttime" id="posttime" onclick="layui.laydate({elem: this, festival: true})">
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <input  class="layui-input dates" placeholder="Searching date to" name="posttime1" id="posttime1" onclick="layui.laydate({elem: this, festival: true})">
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <select name="userid" id="userid">
                    <option value=0>Account Manager</option>
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
            <div class="layui-input-inline" style="width: 150px">
                <input class="layui-input" type="text" placeholder="Website name" name="website" id="company">
            </div>
            <div class="layui-input-inline" style="width: 150px">
                <input class="layui-input" type="text" placeholder="Email" name="email" id="company">
            </div>
            <div class="layui-input-inline">
                <a class="layui-btn layui-btn-small layui-btn-normal"  id="orderssub" >Search</a>
            </div>
        </form>
    </div>
    <ul class="nav nav-tabs">
        <li <if condition="$showD eq ''">class=active</if>> <a href="?showD=">My Accounts</a></li>
        <li <if condition="$showD eq 'bmkh'">class=active</if>> <a href="?showD=bmkh">Protected Accounts</a></li>
        <li <if condition="$showD eq 'gxkh'">class=active</if>> <a href="?showD=gxkh">Open Database</a></li>
        <li <if condition="$showD eq 'jxlkh'">class=active</if>> <a href="?showD=jxlkh">Follow Up Today</a></li>
        <li <if condition="$showD eq 'wajlkh'">class=active</if>> <a href="?showD=wajlkh">Follow Up Due</a></li>
        <li <if condition="$showD eq 'c15wlxkh'">class=active</if>> <a href="?showD=c15wlxkh">No Contact Over 15 Days</a></li>
    </ul>
    <div class="tab-content">
        <div class="bg-info msgbox">
            Under current searching conditions:
            there are <b style="color:red;"> <span id="allTotal1"></span> </b> account(s) found,
            &nbsp;&nbsp;&nbsp;<b style="color:red;"><span id="checkboxlen"></span></b>
        </div>
      <div class="tab-pane active">
        <table id="ListTbl" class="table table-striped table-bordered hover">
                <thead>
                <tr class="bg-info">
                    <th>No.</th>
                    <th><input class=SelectAllId type=checkbox sname="id[]"></th>
                    <th>Company Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Country</th>
                    <th>Primary Contact</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Web</th>
                    <th>Acct. Manager</th>
                    <th>Next Contact Time</th>
                    <th>Last Contact Time</th>
                    <th>Add Time</th>
                    <th>Operation</th>
                    <th>ID</th>
                </tr>
                </thead>
                <tbody align="center">
                </tbody>
            </table>
        </div>
        <div class="form-inline">
            <div class="input-group">
                <if condition="$showD eq ''">
                    <button class="layui-btn-normal layui-btn layui-btn-small" id="plzy">Move to share</button>
                </if>
                <if condition="$showD eq 'gxkh'">
                    <button class="layui-btn-normal layui-btn layui-btn-small" id="plziji">Move to my account</button>
                </if>
                <if condition="$showD neq 'gxkh'">
                    <php>if(strpos(getUserCzqx(),"客户分配")>-1){</php>
                    <div class="input-group">
                        <span class="input-group-addon">Account Manager</span>
                        <select id='search_tp' class='form-control'>
                            <option value=''>Account Manager</option>
                            <volist name=":ShowList('bumen','','id')" id="vo">
                                <option disabled="">{$vo.classname}</option>
                                <volist name=":ShowList('users','bmid='.$vo['id'],'id')" id="va">
                                    <option value='{$va.id}'>-{$va.username}</option>
                                </volist>
                            </volist>
                        </select>
                    </div>
                    <button class="layui-btn-normal layui-btn layui-btn-small" id="jltp">Modify Account Manager</button>
                    <php>}</php>
                </if>
            </div>
        </div>
    </div>
    <script>
            /*重置表单*/
            resetFrom();
            <eq name="FullSearch" value=""> $("#FullSearch").hide();</eq>
            $("#addForm").hide();
            /*基础设置*/
            $("#addFun").click(function(){
                _save("create");
            });
            $("#delFun").click(function(){
                _del(table);
            });
            $("#orderssub").click(function(){
                var param=$("form").serialize();
                table.ajax.url("?show=showDataTbale&showD={$showD}&"+param).load();
            });
            /*初始化表格*/
            var table = $('#ListTbl').DataTable({
                "processing": true,
                "serverSide": true,
                stateSave: false,
                columnDefs:[{
                    orderable:false,//禁用排序
                    targets:[0,1,6,7,8,13]   //指定的列
                }],
                "order": [[12, 'desc']],
                "sDom": '<"top">rt<"bottom"ip><"clear">',
                bProcessing:true,
                aLengthMenu: [100],        //设置每页显示数据数量
                bLengthChange: true,
                // bInfo:true,
                //bAutoWidth: true,
                paging:true,
                createdRow: function( row, data, dataIndex ) {
                    $(row).children('td').eq(2).attr('style', 'text-align: left;')
                },
                ordering: true,
                info:true,
                searching: true,
                autoWidth: false,
                ajax:{
                    url:"?show=showDataTbale&showD={$showD}&posttime={$BeginDate}&posttime1={$BeginDate1}",
                    dataType:"json",
                    "dataSrc": function ( json ) {
                        $('#allTotal1').html(json.allTotal['1']);
                        return json.data;
                    }
                }
            });
            var seach = "<div class='searchstyle'><input type='text' id='pagesvalue' style='width: 35px;height: 30px;' /><button class='layui-btn layui-btn-normal search-btn' id='search'>GO</button></div>";
            $('#ListTbl_info').after(seach);
            /*调用自定义 */
            _customSearch(table);
            /*单击选择 */
            $('#ListTbl').on('click','tbody tr',function () {
                if($(this).find("td").html()!='No data available in table') {
                    var czid = $(this).find("td:last").text();
                    if ($(this).hasClass('selected')) {
                        $(this).removeClass('selected');
                        $('#czid').val('');
                    } else {
                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                        $('#czid').val(czid);
                    }
                }
            });
            /*双击调出编辑*/
            $('#ListTbl').on('dblclick','tbody tr',function () {
                if($(this).find("td").html()!='No data available in table') {
                    var czid = $(this).find("td:last").text();
                    $(this).addClass('selected');
                    $('#czid').val(czid);
                    _save("edit");
                }
            });
            /*响应添加 修改*/
            function _save(act) {
                var title='Add customer';
                layer.open({
                    skin: 'layui-layer-lan', //默认皮肤
                    type:2,
                    title:title, //标题
                    area: ['70%', '100%'], //宽高
                    shade: 0.8,//遮罩
                    zIndex:1,
                    content: '{:U('/Home/Customer/add')}?table=table'
                });
            }
            $(document).on("click",".editFun",function(){
                var czid = $(this).attr('czid');
                var title='Edit Customer';
                var canshu="czid="+czid+"";
                layer.open({
                    skin: 'layui-layer-lan', //默认皮肤
                    type:2,
                    title:title, //标题
                    area: ['70%', '100%'], //宽高
                    shade: 0.8,//遮罩
                    zIndex:1,
                    content: '{:U('/Home/Customer/add')}?table=table&'+canshu
                });
            });
            $("#plzy").click(function(){
                var arr='';
                $('input[name="id[]"]:checked').each(function(i){
                    if(i>0)
                    {
                        arr += ",";
                    }
                    arr += $(this).val();
                });
                if(!arr){
                    layer.msg('No customer selected', {icon: 3});
                    console.log(error);
                }
                $.ajax({
                    url: "{:U('Home/Customer/piliangzy')}",
                    data:{arr:arr},
                    type: "post",
                    success: function (res) {
                        resetFrom();
                        layer.msg('Batch transfer success', {icon: 1});
                        table.ajax.reload(null,false);
                    }, error: function (error) {
                        layer.msg('Batch transfer failure', {icon: 2});
                        console.log(error);
                    }
                });
            });
            $("#sxdel").click(function(){
                var arr='';
                $('input[name="id[]"]:checked').each(function(i){
                    if(i>0)
                    {
                        arr += ",";
                    }
                    arr += $(this).val();
                });
                if(!arr){
                    layer.msg('No customer selected', {icon: 3});
                    console.log(error);
                }
                $.ajax({
                    url: "{:U('Home/Customer/piliangdel')}",
                    data:{arr:arr},
                    type: "post",
                    success: function (res) {
                        resetFrom();
                        layer.msg('Deleted!', {icon: 1});
                        table.ajax.reload(null,false);
                    }, error: function (error) {
                        layer.msg('Batch deletion failed', {icon: 2});
                        console.log(error);
                    }
                });
            });
            $("#jltp").click(function(){
                var arr='';
                $('input[name="id[]"]:checked').each(function(i){
                    if(i>0)
                    {
                        arr += ",";
                    }
                    arr += $(this).val();
                });
                if(!arr){
                    layer.msg('No customer selected', {icon: 3});
                    console.log(error);
                }
                var uid=$("#search_tp option:selected").val();
                if(!uid){
                    layer.msg('No account manager', {icon: 3});
                    console.log(error);
                }
                $.ajax({
                    url: "{:U('Home/Customer/piliangtp')}",
                    data:{arr:arr,uid:uid},
                    type: "post",
                    success: function (res) {
                        resetFrom();
                        layer.msg('Transfer success!', {icon: 1});
                        table.ajax.reload(null,false);
                    }, error: function (error) {
                        layer.msg('Deployment failure', {icon: 2});
                        console.log(error);
                    }
                });
            });
            $("#plziji").click(function(){
                var arr='';
                $('input[name="id[]"]:checked').each(function(i){
                    if(i>0)
                    {
                        arr += ",";
                    }
                    arr += $(this).val();
                });
                if(!arr){
                    layer.msg('No customer selected', {icon: 3});
                    console.log(error);
                }
                $.ajax({
                    url: "{:U('Home/Customer/plziji')}",
                    data:{arr:arr},
                    type: "post",
                    success: function (res) {
                        resetFrom();
                        layer.msg('Batch transfer success', {icon: 1});
                        table.ajax.reload(null,false);
                    }, error: function (error) {
                        layer.msg('Batch transfer failure', {icon: 2});
                        console.log(error);
                    }
                });
            });
            $(document).on("click",".zrziji",function(){
                    var arr = $(this).attr('czid');
                $.ajax({
                    url: "{:U('Home/Customer/plziji')}",
                    data:{arr:arr},
                    type: "post",
                    success: function (res) {
                        resetFrom();
                        layer.msg('transfer success', {icon: 1});
                        table.ajax.reload(null,false);
                    }, error: function (error) {
                        layer.msg('transfer failure', {icon: 2});
                        console.log(error);
                    }
                });
            });
            <!--添加意向单-->
            $(document).on("click",".addintention",function(){
                var czid = $(this).attr('czid');
                $.ajax({
                    url: "{:U('Home/Customer/ismember')}?czid="+czid,
                    dataType: 'json',
                    type: "post",
                    success: function (res) {
                        if(res.code==1){
                            var title="Turn to lead";
                            var url="{:U('Home/Customer/addintention')}?cid="+czid;
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
            <!--添加联系记录-->
            $(document).on("click",".tjlxr",function(){
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
            <!--添加联系人-->
            $(document).on("click",".tjlxjl",function(){
                var czid = $(this).attr('czid');
                var title='Add a Contact';
                var url = "{:U('Home/Customer/addlianxiren')}?cid="+czid;
                _layerOpen(url, title, '80%', '100%');
            });
            //经理调配
            $("#jltp").click(function(){
                var arr='';
                $('input[name="id[]"]:checked').each(function(i){
                    if(i>0)
                    {
                        arr += ",";
                    }
                    arr += $(this).val();
                });
                if(!arr){
                    layer.msg('No customer selected', {icon: 3});
                    console.log(error);
                }
                var uid=$("#search_tp option:selected").val();
                if(!uid){
                    layer.msg('No account manager', {icon: 3});
                    console.log(error);
                }
                $.ajax({
                    url: "{:U('Home/Customer/piliangtp')}",
                    data:{arr:arr,uid:uid},
                    type: "post",
                    success: function (res) {
                        resetFrom();
                        layer.msg('Transfer success!', {icon: 1});
                        table.ajax.reload(null,false);
                    }, error: function (error) {
                        layer.msg('Deployment failure', {icon: 2});
                        console.log(error);
                    }
                });
            });
            $('#search').click(function(){
                var value=$("#pagesvalue").val()-1;
                table.page(value).draw(false);
            });
    </script>
</block>
