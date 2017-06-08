<extend name="Public/base" />
<block name="main">
    <input type=hidden id="czid" checked>
    <div class="form-inline pull-right">
        <div class="pull-right btn-group pdl-10" role="group" aria-label="管理按钮">
            <php>if(strpos(getUserCzqx(),"展会编辑")>-1){</php>
                <button class="btn btn-primary editFun"><i class="fa fa-edit"></i> Edit</button>
            <php>}</php>
            <button class="btn btn-info refreshBtn"><i class="fa fa-refresh"></i> </button>
        </div>
    </div>
    <div class="TitleOne showOrHide" where="ExpoView"><i class="fa fa-minus-square">{$res.title}</i></div>
    <div class="clear"></div>
    <table class="table table-striped table-bordered hover">
        <tr>
            <td align="right"><strong>Expo</strong></td>
            <td colspan="3">{$res.title}</td>
        </tr>
        <tr>
            <td width="15%" align="right"><strong>Industry</strong></td>
            <td width="35%">{$res.hangye}</td>
            <td width="15%" align="right"><strong>Holding Cycle</strong></td>
            <td width="35%">{$res.zhouqi}</td>
        </tr>
        <tr>
            <td align="right"><strong>Location</strong></td>
            <td>{$res.s1}-{$res.s2}</td>
            <td align="right"><strong>Project Website</strong></td>
            <td><a href="{$res.website}" target="_blank"><font color="#00ced1">{$res.website}</font></a></td>
        </tr>
        <tr>
            <td align="right"><strong>Exhibition Time</strong></td>
            <td>{$res.starttime}-{$res.endtime}</td>
            <td align="right"><strong>Target Size</strong></td>
            <td>{$res.mbmianji}</td>
        </tr>
        <tr>
            <td align="right"><strong>Exhibition Name</strong></td>
            <td>{$res.hallname}</td>
            <td align="right"><strong>Exhibition Address</strong></td>
            <td>{$res.halladd}</td>
        </tr>
        <tr>
            <td align="right"><strong>Exhibition Introduction</strong></td>
            <td colspan="3">{$res.profile}</td>
        </tr>
    </table>
    <div class="tabHeader">
        <div class="pull-right btn-group" role="group">
        </div><b>Leads</b>
    </div>
    <table id="ListTbl" class="table table-striped table-bordered hover">
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
    <table id="ListTb2" class="table table-striped table-bordered hover">
        <thead>
        <tr class="bg-info">
            <th width="5%">No.</th>
            <th width="3%"><input class=SelectAllId type=checkbox sname="id[]"></th>
            <th width="15%">Company Name</th>
            <th width="17%">Expo</th>
            <th width="6%">Country</th>
            <th width="8%">Order Amount</th>
            <th width="6%">Size</th>
            <th width="5%">Booth Type</th>
            <th width="8%">Signing Date</th>
            <th width="13%">Acct. Manager</th>
            <th width="7%">Operation</th>
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
    <table id="ListTb3" class="table table-striped table-bordered hover">
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
        resetFrom();
        $(".editFun").click(function(){
            var title = "Edit Exhibition";
            var url ="{:U('Expo/edit',array('czid'=>$czid,'from'=>'view'))}";
            _layerOpen(url, title, '65%', '80%');
        });
        var table = $('#ListTbl').DataTable({
            stateSave: false,
            columnDefs:[{
                orderable:false,//禁用排序
                targets:[0,1]   //指定的列
            }],
            "order": [[2, 'desc']],
            aLengthMenu: [50],
            "sDom": '<"top">rt<"bottom"ip><"clear">',
            bProcessing:false,
            bLengthChange: false,
            // bInfo:true,
            //bAutoWidth: true,
            paging:false,
            ordering: true,
            info:false,
            searching: false,
            autoWidth: false,
            ajax: "?show=showDataTbale&czid={$czid}"
        });
        _customSearch(table);
        var table1 = $('#ListTb2').DataTable({
            stateSave: false,
            columnDefs:[{
                orderable:false,//禁用排序
                targets:[0,1]   //指定的列
            }],
            "order": [[2, 'desc']],
            aLengthMenu: [50],
            "sDom": '<"top">rt<"bottom"ip><"clear">',
            bProcessing:false,
            bLengthChange: false,
            // bInfo:true,
            //bAutoWidth: true,
            paging:false,
            ordering: true,
            info:false,
            searching: false,
            autoWidth: false,
            ajax: "?show=showDataTbale1&czid={$czid}"
        });
        _customSearch(table1);
        var table2 = $('#ListTb3').DataTable({
            stateSave: false,
            columnDefs:[{
                orderable:false,//禁用排序
                targets:[0,1]   //指定的列
            }],
            "order": [[2, 'desc']],
            aLengthMenu: [50],
            "sDom": '<"top">rt<"bottom"ip><"clear">',
            bProcessing:false,
            bLengthChange: false,
            // bInfo:true,
            //bAutoWidth: true,
            paging:false,
            ordering: true,
            info:false,
            searching: false,
            autoWidth: false,
            ajax: "?show=showDataTbale2&czid={$czid}"
        });
        _customSearch(table2);
        /*单击选择 */
        $('#ListTbl').on('click','tbody tr',function () {
            var czid=$(this).find("td:last").text();
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
            _layerOpen(url, title, '70%', '75%');
        })
        /*转为订单*/
        $(document).on('click','.zdd',function(){
            var title = "Turn to order";
            var czid=$(this).attr('czid');
            var url ="{:U('Orders/zhuandd')}?czid="+czid;
            _layerOpen(url, title, '75%', '80%');
        })
        /*转为挂单*/
        $(document).on('click','.zgd',function(){
            var title = "转为挂单";
            var czid=$(this).attr('czid');
            var url ="{:U('Orders/zhuangd')}?czid="+czid;
            _layerOpen(url, title, '60%', '70%');
        })
        /*添加联系记录*/
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
//        订单修改
        $(document).on('click','.editdd',function(){
            var title = "Modify order";
            var czid=$(this).attr('czid');
            var url ="{:U('Orders/editdd')}?czid="+czid;
            _layerOpen(url, title, '75%', '70%');
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
                            table1.ajax.reload(null, false);
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
                            table2.ajax.reload(null, false);
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
    </script>
</block>