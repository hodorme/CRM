<extend name="Public/base" />
<block name="main">
    <input type="hidden" value="{$czid}" id="qyid">
    <input type="hidden" id="czid" checked>
    <div class="form-inline pull-right">
        <div class="pull-right btn-group pdl-10" role="group" aria-label="管理按钮">
            <button type="button" id="editFun" class="btn btn-success dropdown-toggle" data-toggle="dropdown"> Edit</button>
            <php>if(strpos(getUserCzqx(),"客户删除")>-1){</php>
                <button id="sxdel" class="btn btn-danger">Delete</button>
                <php>}</php>
            <if condition="$view['classid'] neq '1859' ">
                <button type="button" u="Customer/addgongxiang" wsize="60%" hsize="60%" class="btn btn-primary dropdown-toggle ExpoOperations" data-toggle="dropdown">Turn to Share</button>
                <else />
                <button type="button" id="addziji" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Move to My Account</button>
            </if>
            <button id="btnRefresh" class="btn btn-info"><i class="fa fa-refresh"></i></button>
        </div>
    </div>
    <div class="TitleOne showOrHide" where="ExpoView"><i class="fa fa-minus-square"></i>&nbsp;&nbsp;{$view.title}</div>
    <table class="table table-striped table-bordered hover" id="ExpoView">
        <tr>
            <td width="15%" align="right"><strong>Company Name</strong></td>
            <td width="35%">{$view.title}</td>
            <td width="15%" align="right"><strong>Acct. Manager</strong></td>
            <td>{$view.username}</td>
        </tr>
        <tr>
            <td align="right"><strong>Country</strong></td>
            <td>
                {$view.s1name}
                <if condition="$view['s2name']">
                    - {$view.s2name}
                </if>
            </td>
            <td align="right"><strong>Industry</strong></td>
            <td>{$view.industryname}</td>
        </tr>
        <tr>
            <td align="right"><strong>Business Nature</strong></td>
            <td>{$view.businessname}</td>
            <td align="right"><strong>Type</strong></td>
            <td>{$view.typename}</td>
        </tr>
        <tr>
            <td align="right"><strong>Product Groups</strong></td>
            <td>{$view.product}</td>
            <td align="right"><strong>Brand</strong></td>
            <td>{$view.brand}</td>
        </tr>
        <tr>
            <td align="right"><strong>Data Source</strong></td>
            <td>{$view.sourcename}</td>
            <td align="right"><strong>Detailed Source Information</strong></td>
            <td>{$view.sourcedetails}</td>
        </tr>
        <tr>
            <td align="right" valign="top"><strong>Detailed Address</strong></td>
            <td>{$view.address}</td>
            <td align="right"><strong>Last Contact Time</strong></td>
            <td>{$view.updatedtime}</td>
        </tr>
        <tr>
            <td align="right"><strong>Zip Code</strong></td>
            <td>{$view.ame}</td>
            <td align="right"><strong>Web</strong></td>
            <td><a href="http://{$view.website}" target="_black">{$view.website}</a></td>
        </tr>
        <tr>
            <td align="right"><strong>Company Background</strong></td>
            <td colspan="3">{$view.memo}</td>
        </tr>
    </table>
    <div class="tabHeader">
        <div class="pull-right btn-group" role="group">
            <button class="btn btn-sm btn-success ExpoOperations" u="Customer/addlianxiren" title="Add a Contact" where="lianxiren"  wsize="60%" hsize="80%"><i class="fa fa-plus-circle"></i> Add a Contact</button>
            <button class="btn btn-sm btn-danger delFun" where="lianxiren"><i class="fa fa-remove "></i> Delete Contact</button>
        </div><b>Contact information</b>
    </div>
    <table id="ListLianxiren" class="table table-striped table-bordered hover">
        <thead>
        <tr class="bg-info">
            <th>No.</th>
            <th>Primary Contact</th>
            <th>Prefix</th>
            <th>Full Name</th>
            <th>Department</th>
            <th>Position</th>
            <th>Contact Number</th>
            <th>Mobile Phone</th>
            <th>Fax</th>
            <th>Email</th>
            <th>Operation</th>
            <th>ID</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="tabHeader">
        <div class="pull-right btn-group" role="group">
            <button class="btn btn-sm btn-success" id="tjlxr"><i class="fa fa-plus-circle"></i> Add contact record</button>
        </div><b>Contact Record</b>
    </div>
    <table id="ListLianxiJilu" class="table table-striped table-bordered hover">
        <thead>
        <tr class="bg-info">
            <th>No.</th>
            <th>Next Contact Time</th>
            <th width="30%">Notes</th>
            <th>Contacting method</th>
            <th>Position</th>
            <th>Contact Object</th>
            <th>Record Date</th>
            <th>Note-Taker</th>
            <th>ID</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="tabHeader">
        <div class="pull-right btn-group" role="group">
            <button class="btn btn-sm btn-success" id="addintention"><i class="fa fa-plus-circle"></i>Turn to lead</button>
        </div><b>Lead</b>
    </div>
    <table id="ListOrdersYxd" class="table table-striped table-bordered hover">
        <thead>
        <tr class="bg-info">
            <th width="5%">No.</th>
            <th width="2%"><input class=SelectAllId type=checkbox sname="yxid[]"></th>
            <th width="13%">Company Name</th>
            <th width="6%">Country</th>
            <th width="13%">Expo</th>
            <th width="5%">Close Probability</th>
            <th width="10%">Est. Close Date</th>
            <th width="5%">Size</th>
            <th width="8%">Last Contact Time</th>
            <th width="6%">Acct. Manager</th>
            <th width="5%">Status</th>
            <th width="5%">Operation</th>
            <th width="3%">ID</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="tabHeader">
        <div class="pull-right btn-group" role="group">
        </div><b>Order</b>
    </div>
    <table id="ListOrders" class="table table-striped table-bordered hover">
        <thead>
        <tr class="bg-info">
            <th width="5%">No.</th>
            <th width="3%"><input class=SelectAllId type=checkbox sname="id[]"></th>
            <th width="15%">Company Name</th>
            <th width="15%">Expo</th>
            <th width="8%">Country</th>
            <th width="8%">Actual price</th>
            <th width="5%">Size</th>
            <th width="10%">Booth Type</th>
            <th width="8%">Signing Date</th>
            <th width="13%">Acct. Manager</th>
            <th width="5%">Operation</th>
            <th width="4%">ID</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="tabHeader">
        <div class="pull-right btn-group" role="group">
        </div><b>Declined</b>
    </div>
    <table id="ListStop" class="table table-striped table-bordered hover">
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
        <if condition="!$islxr">
            layui.use(['layer'], function(){
                var layer = layui.layer;
                var title='Add a Contact';
                var url = "{:U('Home/Customer/addlianxiren')}?cid={$czid}";
                _layerOpen(url, title, '60%', '80%');
            });
        </if>
        layui.use('form', function() {
            var form = layui.form();
            form.on('select(searchselect)', function(data){
                var value = data.value;
                var col=$(data.elem).attr('col');
                if(value){
                    lianxijilu.column(col).search(value).draw();
                }else{
                    lianxijilu.column(col).search("").draw();
                }
            });
        });
        $(document).on("click",".upmember",function(){
            var czid=$(this).attr('id');
            var url="{:U('Home/Customer/moren')}";
            var data = {
                where:'member',
                czid:czid,
                cid:{$view.id}
            };
            $.post(url,data,function(data){
                // console.log(data);
                if(data = 1){
                    layer.msg('Modify success',{icon: 1});
                    lianxiren.ajax.reload(null, false);
                }else{
                    layer.msg('Modify failed',{icon: 2});
                }
            });
        });
        resetFrom();
        <neq name="showD" value="">
                $("#ExpoView").hide();
        </neq>
            //---------------------------响应订单相关操作---------------------------
        $(document).on("click",".ExpoOperations",function(){
            var title=$(this).attr('title');
            var url=$(this).attr('u');
            if(!url) {
                layer.msg(title+'开发中！',{icon:5});
            }else{
                var czid=$("#czid").val();
                var url = "/CRM/index.php/Home/" + url + "?cid={$czid}"+"&title={$view.title}";
                var wsize = $(this).attr('wsize');
                var hsize = $(this).attr('hsize');
                _layerOpen(url, title, wsize, hsize);
            }
        });
        $("#editFun").click(function(){
            var url = "{:U('Home/Customer/add')}?czid={$view.id}";
            _layerOpen(url, 'Edit enterprise->{$view.title}', '90%', '90%');
        });
        /*重置表单*/
        resetFrom();
        var czid=$("#czid").val();
        /*联系人*/
        var lianxiren = $('#ListLianxiren').DataTable({
            stateSave: false,
            columnDefs:[{
                orderable:false,//禁用排序
                targets:[0,1]   //指定的列
            }],
            "order": [[2, 'asc']],
            "sDom": '<"top">rt<"bottom"ip><"clear">',
            bProcessing:true,
            bLengthChange: true,
            // bInfo:true,
            //bAutoWidth: true,
            paging:false,
            ordering: true,
            info:false,
            searching: false,
            autoWidth: false,
            //scrollY: 350,
            ajax: "?show=showMemberDataTbale&czid={$view.id}",
        });
        _customSearch(lianxiren);
        /*联系记录*/
        var lianxijilu = $('#ListLianxiJilu').DataTable({
            "processing": true,//显示加载进度条
            "sDom": '<"top">rt<"bottom"ip><"clear">',
            "createdRow": function ( row, data, index ) {
                $('td', row).eq(2).css("text-align","left"); //标题单元格居左对齐
            },
            "order": [[4, 'desc']],
            columnDefs:[{
                orderable:false,//禁用排序
                targets:[0]   //指定的列
            }],
            "bServerSide": true,//开启服务器端模式
            ajax: "?show=showLianxiJiluDataTbale&czid={$view.id}",
        });
        _customSearch(lianxijilu);

        var yxorders = $('#ListOrdersYxd').DataTable({
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
                $(row).children('td').eq(1).attr('style', 'text-align: left;')
            },
            paging:true,              //是否显示分页
            ordering: true,           //是否支持排序功能
            info:true,                //显示表格信息
            searching: true,          //开启刷选功能
            ajax: "?show=showOrdersYxdDataTbale&czid={$view.id}"
        });
        _customSearch(yxorders);
        /*初始化表格*/
        var orders = $('#ListOrders').DataTable({
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
            ajax: "?show=showOrdersDataTbale&czid={$view.id}"
        });
        _customSearch(orders);

        /*初始化表格*/
        var stop = $('#ListStop').DataTable({
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
                $(row).children('td').eq(1).attr('style', 'text-align: left;')
            },
            paging:true,              //是否显示分页
            ordering: true,           //是否支持排序功能
            info:true,                //显示表格信息
            searching: true,          //开启刷选功能
            autoWidth: false,
            ajax: "?show=showStopDataTbale&czid={$view.id}"
        });
        _customSearch(stop);
        /*单击选择 */
        $('.table').on('click','tbody tr',function () {
            if($(this).find("td").html()!='No data available in table'){
                var czid=$(this).find("td:last").text();
                if($(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    $('#czid').val(czid);
                }else{
                    $('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    $('#czid').val(czid);
                }
            }
        });
        /*双击调出编辑 */
        $('.tableEdit').on('dblclick','tbody tr',function () {
            if($(this).find("td").html()!='No data available in table'){
                if($(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    $(this).find(":checkbox:first").prop("checked",false);
                }else{
                    $(this).addClass('selected');
                    $(this).find(":checkbox:first").prop("checked",true);
                    var url=$(this).parent().parent().attr("u");
                    var title=$(this).parent().parent().attr("title");
                    var wsize=$(this).parent().parent().attr("wsize");
                    var hsize=$(this).parent().parent().attr("hsize");
                    var czid=$(this).find("td:last").text();
                    if(!url) {
                        layer.msg(title+'开发中！',{icon:5});
                    }else{
                        var url = "/CRM/index.php/Home/" + url + "?cid={$czid}&czid="+czid;
                        if (!wsize) {
                            wsize = '90%';
                        }
                        if (!hsize) {
                            hsize = '90%';
                        }
                        _layerOpen(url, title, wsize, hsize);
                    }
                }
            }
        });
        $(".addFun").click(function(){
            var where=$(this).attr("where");
            var wsize=$(this).attr("wsize");
            var hsize=$(this).attr("hsize");
            if(!wsize){
                var wsize='600px';
            }
            if(!hsize){
                var hsize='300px';
            }
            _layerOpen(where,'',wsize,hsize);
        });
        $(".editFun").click(function(){
            var where=$(this).attr("where");
            var czid=$(this).find("td:last").text();
            _layerOpen(where,czid,'600px','300px');
        });
        $(".delFun").click(function(){
            var czid=$("#czid").val();
            var where=$(this).attr("where");
            if(!czid) {
                layer.msg('Select line', function(){});
                return false;
            }else{
                $.ajax({
                    url: "/CRM/index.php/Home/Customer/add"+where+"?act=del&czid="+czid,
                    type: "post",
                    success: function (res) {
                        if (res.code == 1) {
                            resetFrom();
                            layer.msg(res.msg, {icon: res.code});
                            if(where=='lianxiren'){
                                lianxiren.ajax.reload(null, false);
                            }
                        } else {
                            layer.msg(res.msg, {icon: res.code});
                        }
                    }, error: function (error) {
                        layer.msg('Request error', {icon: 2});
                        console.log(error);
                    }
                });
            }
        });
        <!--添加意向单-->
        $(document).on("click","#addintention",function(){
            $.ajax({
                url: "{:U('Home/Customer/ismember')}?czid={$czid}",
                dataType: 'json',
                type: "post",
                success: function (res) {
                    if(res.code==1){
                        var title="Turn to lead";
                        var url="{:U('Home/Customer/addintention')}?cid={$czid}";
                        _layerOpen(url, title,'75%', '85%');
                    }else if(res.code==2){
                            layer.msg('Please add a contact');
                            var title='Add a Contact';
                            var url = "{:U('Home/Customer/addlianxiren')}?cid={$czid}";
                            _layerOpen(url, title, '60%', '80%');
                    }
                }, error: function (error) {
                    layer.msg('Request error', {icon: 2});
                    console.log(error);
                }
            });
        });
        $("#addziji").click(function(){
            var czid=$('#qyid').val();
            $.ajax({
                url: "{:U('Home/Customer/addziji')}?cid="+czid,
                dataType: 'json',
                type: 'POST',
                success: function (res) {
                    if (res.code == 1) {
                        resetFrom();
                        location.reload();
                        layer.msg('Succeed in!', {icon: 1});
                    } else {
                        layer.msg('Fail in!', {icon: 2});
                    }
                }, error: function (error) {
                    layer.msg('Request error', {icon: 2});
                    console.log(error);
                }
            });
        });
        <!--添加联系记录-->
        $(document).on("click","#tjlxr",function(){
            $.ajax({
                url: "{:U('Home/Customer/ismember')}?czid={$czid}",
                dataType: 'json',
                type: "post",
                success: function (res) {
                    if(res.code==1){
                        var title="Add contact record";
                        var url="{:U('Home/Customer/addlianxijilu')}?cid={$czid}";
                        _layerOpen(url, title,'60%', '70%');
                    }else if(res.code==2){
                        layer.msg('Please add a contact');
                        var title='Adda Contact ';
                        var url = "{:U('Home/Customer/addlianxiren')}?cid={$czid}";
                        _layerOpen(url, title, '60%', '80%');
                    }
                }, error: function (error) {
                    layer.msg('Request error', {icon: 2});
                    console.log(error);
                }
            });
        });
        /*编辑订单*/
        $(document).on('click','.edit',function(){
            var title = "Edit Order";
            var czid=$(this).attr('czid');
            var url ="{:U('Orders/editOrders')}?czid="+czid;
            _layerOpen(url, title, '70%', '75%');
        });
        /*转为订单*/
        $(document).on('click','.zdd',function(){
            var title = "Turn to order";
            var czid=$(this).attr('czid');
            var url ="{:U('Orders/zhuandd')}?czid="+czid;
            _layerOpen(url, title, '70%', '75%');
        });
        /*转为挂单*/
        $(document).on('click','.zgd',function(){
            var title = "转为挂单";
            var czid=$(this).attr('czid');
            var url ="{:U('Orders/zhuangd')}?czid="+czid;
            _layerOpen(url, title, '60%', '70%');
        });
//        订单修改
        $(document).on('click','.editdd',function(){
            var title = "Edit Order";
            var czid=$(this).attr('czid');
            var url ="{:U('Orders/editdd')}?czid="+czid;
            _layerOpen(url, title, '70%', '75%');
        });
//        订单删除
        /*单个删除方法*/
        function del(id){
            console.log(id);
            layer.confirm('Confirm delete？', {
                btn: ['confirm','cancel'] //按钮
            }, function() {
                $.ajax({
                    url: "?act=del&czid=" + id,
                    type: "post",
                    success: function (res) {
                        if (res.code == 1) {
                            resetFrom();
                            layer.msg(res.msg, {icon: res.code});
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
        }
        /*编辑意向单*/
        $(document).on('click','.edityxd',function(){
            var title = "Edit Intent list";
            var czid=$(this).attr('czid');
            var cid=$(this).attr('cid');
            var url ="{:U('Customer/addintention')}?czid="+czid+"&cid="+cid;
            _layerOpen(url, title, '70%', '75%');
        })
//        挂单删除
        $(document).on('click','.delgd',function(){
            var id=$(this).attr('czid');
            layer.confirm('Confirm delete?', {
                btn: ['Yes','No'] //按钮
            }, function() {
                $.ajax({
                    url: "/CRM/index.php/Home/Orders/stop?act=del&czid=" + id,
                    type: "post",
                    success: function (res) {
                        if (res.code == 1) {
                            resetFrom();
                            layer.msg('Delete success', {icon: res.code});
                            stop.ajax.reload(null, false);
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
        /*编辑联系人*/
        $(document).on('click','.lxredit',function(){
            var title = "Edit Contact";
            var czid=$(this).attr('id');
            var url ="{:U('Customer/addlianxiren')}?czid="+czid;
            _layerOpen(url, title, '60%', '80%');
        });
        /*订单删除方法*/
        $(document).on('click','.deldd',function(){
            var id=$(this).attr('czid');
            layer.confirm('Confirm delete?', {
                btn: ['Yes','No'] //按钮
            }, function() {
                $.ajax({
                    url: "/CRM/index.php/Home/Orders?act=del&czid=" + id,
                    type: "post",
                    success: function (res) {
                        if (res.code == 1) {
                            resetFrom();
                            layer.msg('Delete success', {icon: res.code});
                            orders.ajax.reload(null, false);
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
        //删除客户
        $("#sxdel").click(function(){
            layer.confirm('Confirm delete?', {
                btn: ['Yes','No'] //按钮
            }, function() {
                $.ajax({
                    url: "{:U('Home/Customer/piliangdel')}",
                    data:{arr:{$view.id}},
                    type: "post",
                    success: function (res) {
                       window.opener=null;
                        window.open('','_self');
                        window.close();
                    }, error: function (error) {
                        layer.msg('Batch deletion failed', {icon: 2});
                        console.log(error);
                    }
                });
            });
        });
    </script>
</block>