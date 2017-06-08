<extend name="Public/base" />
<block name="main">
    <input type="hidden" value="{$czid}" id="czid">
    <input type="hidden" id="czid" checked>
    <input type="hidden" id="expoid" checked value="{$view.expoid}">
    <input type="hidden" id="cid" checked value="{$view.cid}">
    <div class="pull-right btn-group pdl-10" role="group" aria-label="管理按钮">
        <if condition="$view['orderstatus'] eq '有效意向单'">
            <div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Operation <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="javascript:;" class="zdd"><i class="fa fa-plus-circle"></i>Turn to order</a></li>
                    <li><a href="javascript:;" class="zgd"><i class="fa fa-plus-circle"></i>Move to lost</a></li>
                </ul>
            </div>
            <elseif condition="$view['orderstatus'] eq '有效订单'"/>
            <php>if(strpos(getUserCzqx(),"订单删除")>-1){</php>
                <button type="button" id="delFun" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"> Delete</button>
            <php>}</php>
            <php>if(strpos(getUserCzqx(),"订单编辑")>-1){</php>
                <button type="button" id="editFun" class="btn btn-success dropdown-toggle" data-toggle="dropdown"> Edit</button>
            <php>}</php>
            <elseif condition="$view['orderstatus'] eq '已挂单'"/>
            <php>if(strpos(getUserCzqx(),"挂单删除")>-1){</php>
                <button type="button" id="delgd" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"> Delete</button>
            <php>}</php>
        </if>
        <button class="btn btn-info refreshBtn"><i class="fa fa-refresh"></i> </button>
    </div>
    <div class="TitleOne showOrHide" where="ExpoView"><i class="fa fa-minus-square"></i>{$view.opclassidname}Sale({$view.zhuangtai})</div>
    <table class="table table-striped table-bordered hover" id="ExpoView">
        <tr>
            <td width="15%" align="right"><strong>Order ID</strong></td>
            <td width="35%">{$view.id}</td>
            <td width="15%" align="right"><strong>Acct. Manager</strong></td>
            <td width="35%">{$view.username}</td>
        </tr>
        <tr>
            <td align="right"><strong>Company Name</strong></td>
            <td><a href="/CRM/index.php/Home/Customer/view?czid={$view.cid}" target="_blank">{$view.cname}</a></td>
            <td align="right"><strong>Related Exhibition</strong></td>
            <td><a href="/CRM/index.php/Home/Expo/view?czid={$view.expoid}" target="_blank">{$view.ename}</a></td>
        </tr>
        <tr>
            <td align="right"><strong>Size</strong></td>
            <td><if condition="$view['acreage']">{$view.acreage}㎡</if></td>
            <td align="right"><strong>Unit Price</strong></td>
            <td><if condition="$view['actprice']">${$view.price}</if></td>
        </tr>
        <tr>
            <td align="right"><strong>Actual Price</strong></td>
            <td>${$view.actprice}</td>
            <td align="right"><strong>Booth Type</strong></td>
            <td>{$view.boothtype}</td>
        </tr>
        <tr>
            <td align="right"><strong>Est. Close Date</strong></td>
            <td>{$view.estclose}</td>
            <td align="right"><strong>Probability</strong></td>
            <td>{$view.probability}</td>
        </tr>
        <tr>
            <td align="right"><strong>Signing Time</strong></td>
            <td>{$view.qydate}</td>
            <td align="right"><strong>Status</strong></td>
            <td><if condition="$view['orderstatus'] eq '有效订单'">
                    Close-won
                    <elseif condition="$view['orderstatus'] eq '有效意向单'"/>
                    Open
                    <else/>
                    Close-lost
                    </if>
            </td>
        </tr>
        <tr>
            <td align="right"><strong>Remarks</strong></td>
            <td colspan="3">{$view.memo}</td>
        </tr>
    </table>
    <if condition="$view['orderstatus'] eq '已挂单'">
        <div class="tabHeader">
            <b>Decline Information</b>
        </div>
        <table class="table table-striped table-bordered hover" id="ExpoView">
            <tr border="1">
                <td style="border-color: #0d8ddb" align="center" width="10%"><strong>Decline Reason</strong></td>
                <td style="border-color: #0d8ddb" width="20%">{$res.whya}</td>
                <td style="border-color: #0d8ddb" align="center" width="10%"><strong>Remarks</strong></td>
                <td style="border-color: #0d8ddb" width="20%">{$res.memo}</td>
            </tr>
        </table>
    </if>
    <div class="tabHeader">
        <div class="pull-right btn-group" role="group">
            <button class="btn btn-sm btn-success ExpoOperations" u="Customer/addlianxijilu" where="lianxijilu"  wsize="60%" hsize="70%"><i class="fa fa-plus-circle"></i> Add contact record</button>
        </div><b>Contact record</b>
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
    <script>
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
            ajax: "?show=showLianxiJiluDataTbale&cid={$view.cid}&czid={$czid}",
        });
        _customSearch(lianxijilu);
        $(document).on("click",".ExpoOperations",function(){
            var title=$(this).attr('title');
            var url=$(this).attr('u');
            if(!url) {
                layer.msg(title+'开发中！',{icon:5});
            }else{
                var czid=$("#czid").val();
                var url = "/CRM/index.php/Home/" + url + "?cid={$view.cid}";
                var wsize = $(this).attr('wsize');
                var hsize = $(this).attr('hsize');
                _layerOpen(url, title, wsize, hsize);
            }
        });
        /*转为订单*/
        $(document).on('click','.zdd',function(){
            var title = "Turn to order";
            var czid=$("#czid").val();
            var url ="{:U('Orders/zhuandd')}?czid="+czid;
            _layerOpen(url, title, '75%', '80%');
        })
        /*转为挂单*/
        $(document).on('click','.zgd',function(){
            var title = "转为挂单";

            var url ="{:U('Orders/zhuangd')}?czid="+czid;
            _layerOpen(url, title, '60%', '70%');
        })
//        修改订单
        $("#editFun").click(function(){
            var title = "Modify order";
            var czid=$("#czid").val();
            var url ="{:U('Orders/editdd')}?czid="+czid;
            _layerOpen(url, title, '75%', '70%');
        });
//        删除订单
        /*单个删除方法*/
        $("#delFun").click(function(){
            var id=$("#czid").val();
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
                            window.close();
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
        $("#delgd").click(function(){
            layer.confirm('Confirm delete?', {
                btn: ['Yes','No'] //按钮
            }, function() {
                $.ajax({
                    url: "/CRM/index.php/Home/Orders/stop?act=del&czid={$czid}" ,
                    type: "post",
                    success: function (res) {
                        if (res.code == 1) {
                            resetFrom();
                            layer.msg('Delete success', {icon: res.code});
                            window.close();
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