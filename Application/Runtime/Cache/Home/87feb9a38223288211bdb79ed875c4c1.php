<?php if (!defined('THINK_PATH')) exit(); if(session('?uid')==null){header('Location:/CRM/index.php/Home/index/login');return false;} ?>
<!DOCTYPE html>
<html lang='zh-CN'>
<head>
<meta charset='utf-8'>
<title><?php echo ($modular); ?></title>
<link rel='icon' href='/favicon.ico'>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<link href="/CRM/Public/Addons/layui/css/layui.css" rel="stylesheet">
<link href="/CRM/Public/Addons/Hplus/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
<link href="/CRM/Public/Addons/Hplus/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
<link href="/CRM/Public/Addons/Hplus/css/animate.min.css" rel="stylesheet">
<link href="/CRM/Public/Addons/Hplus/css/style.min862f.css?v=4.1.0" rel="stylesheet">
<link href='/CRM/Application/Home/View/hplus/css/wwhplus.css' rel='stylesheet' type='text/css' />
<script src="/CRM/Public/Addons/layui/layui.js"></script>
<script src="/CRM/Public/Addons/Hplus/js/jquery.min.js"></script>
<!--[if lt IE 9]>
<script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
<script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
<![endif]-->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
	
    <link href='/Public/Addons/AdminLTE/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' />
    <link href='/Public/Addons/AdminLTE/plugins/datatables/jquery.dataTables.css' rel='stylesheet' />
    <script src="/CRM/Public/Addons/Echarts/echarts.common.min.js" charset="UTF-8"></script>
    <script src='/CRM/Public/Addons/layui/layui.js'></script>
    <link href='/CRM/Public/Addons/Bootstrap/css/font-awesome.min.css' rel='stylesheet' type='text/css' />
    <link href='/CRM/Public/Addons/AdminLTE/dist/css/AdminLTE.min.css' rel='stylesheet' />
    <link href="/CRM/Public/Addons/layui/css/layui.css" rel="stylesheet">
    <script src='/CRM/Public/Addons/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js'></script>
    <script src='/CRM/Public/Addons/AdminLTE/plugins/datatables/jquery.dataTables.min.js'></script>
    <script src='/CRM/Public/Addons/Bootstrap/js/bootstrap.min.js'></script>
    <script src='/CRM/Public/Addons/Laydate/laydate.js'></script>
    <script src='/CRM/Public/Addons/tableExport/tableExport.js'></script>
    <style>
.col-md-2,.col-md-3,.col-md-4{
    border-right: 1px solid #1f90d8;
}
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title"> <span class="label label-primary pull-right"><i class="fa fa-clock-o"></i>My Tasks<span id="today"></span></span>
                    <h5>My customer contact data dynamics</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-4">
                            <h2 class="no-margins"><a class="J_menuItem" href="/CRM/index.php/Home/Customer/?showD=jxlkh" target="_blank" data-index="9"><span class="pull-right badge badge-danger"><?php echo ((isset($kehu['tj1']) && ($kehu['tj1'] !== ""))?($kehu['tj1']):'0'); ?> / <?php echo ((isset($kehu['tj2']) && ($kehu['tj2'] !== ""))?($kehu['tj2']):'0'); ?></span></a><span class="text-navy">Contact today</span> / Follow Up Today</h2>
                            <div class="stat-percent"><?php echo (round($kehu['tj1']/$kehu['tj2']*100,2)); ?>%</div>
                            <div class="progress progress-mini">
                                <div style="width: <?php echo (round($kehu['tj1']/$kehu['tj2']*100,2)); ?>%;" class="progress-bar"></div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <h2 class="no-margins"><a class="J_menuItem" href="/CRM/index.php/Home/Customer/?showD=&ThisM=month" target="_blank" data-index="10"><span class="pull-right badge badge-info"><?php echo ((isset($kehu['tj3']) && ($kehu['tj3'] !== ""))?($kehu['tj3']):'0'); ?></span></a>New customer</h2>
                            <div class="font-bold text-navy"></div>
                        </div>
                        <div class="col-md-3">
                            <h2 class="no-margins"><a class="J_menuItem" href="/CRM/index.php/Home/Customer/?showD=wajlkh" target="_blank" data-index="8"><span class="pull-right badge badge-success"><?php echo ((isset($kehu['tj4']) && ($kehu['tj4'] !== ""))?($kehu['tj4']):'0'); ?></span></a>Follow Up Due</h2>
                            <div class="font-bold text-navy"></div>
                        </div>
                        <div class="col-md-3">
                            <h2 class="no-margins"><a class="J_menuItem" href="/CRM/index.php/Home/Customer/?showD=c15wlxkh" target="_blank" data-index="8"><span class="pull-right badge badge-danger"><?php echo ((isset($kehu['tj5']) && ($kehu['tj5'] !== ""))?($kehu['tj5']):'0'); ?></span></a>No Contact Over 15 Days</h2>
                            <div class="font-bold text-navy"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane active">
        <table id="ListCustomer" class="table table-striped table-bordered hover">
            <thead>
            <tr class="bg-info" style="background-color:#368da8;">
                <th>No.</th>
                <th><input class=SelectAllId type=checkbox sname="id[]" ></th>
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
                <th>Operation</th>
                <th>ID</th>
            </tr>
            </thead>
            <tbody align="center">
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Ranking List</h5>
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-xs btn-white zbbtn active"  name="Sales charts this month" what="month">This month</button>
                            <button type="button" class="btn btn-xs btn-white zbbtn"  name="Last month sales charts" what="premonth">Last month</button>
                            <button type="button" class="btn btn-xs btn-white zbbtn" name="2017 ranking" what="year">This year</button>
                            <button type="button" class="btn btn-xs btn-white zbbtn" name="2016 ranking" what="preyear">Last year</button>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                            <div id="dptop" name="Sales charts this month" what="month" style="width: 100%;height:400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.msg('Welcome to our AEG world ! Enjoy the Brand New system and rate your experience at Feedback',{area: ['730px', '']});
        });
        function showtime(){
            var d=new Date();
            str='';
            str +=d.getFullYear()+'-'; //获取当前年份
            str +=d.getMonth()+1+'-'; //获取当前月份（0——11）
            str +=d.getDate()+'     ';
            //str +=d.getHours()+':';
            //str +=d.getMinutes()+':';
            //str +=d.getSeconds();
            return str; }
        $(function(){
            var $timeStr=showtime();
            $("#today").text($timeStr) ;
        });
        layui.use(['layer', 'laytpl', 'laypage', 'laydate'],function(){
            var layer = layui.layer
                    ,laytpl = layui.laytpl
                    ,laypage = layui.laypage
                    ,laydate = layui.laydate
        });
        var name=$("#dptop").attr('name');
        var what=$("#dptop").attr('what');
        var myChart = echarts.init(document.getElementById('dptop'))
        myChart.setOption({
            tooltip : {
                trigger: 'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            toolbox: {
                show : true,
                feature : {
                    //mark : {show: true},
                    //dataView : {show: true, readOnly: false},
                    //magicType : {show: true, type: ['line', 'bar']},
                    //restore : {show: true},
                   // saveAsImage : {show: true}
                }
            },
            grid: {
                left: '2%',
                right: '2%',
                bottom: '2%',
                containLabel: true
            },
            xAxis: {
                data: []
            },
            yAxis: {},
            series: [{
                name: name,
                type: 'bar',
                data: []
            }]
        });
        $.get('?show=gsTop&what='+what).done(function (data) {
            // 填入数据
            myChart.setOption({
                title: {
                    text: 'Impossible Is Nothing'
                },
                legend: {
                    data:[name]
                },
                xAxis: {
                    data: data.categories
                },
                series: [{
                    name: name,
                    label: {
                        normal: {
                            show: true,
                            position: 'inside'
                        }
                    },
                    data: data.data
                }]
            });
        });
        $(".zbbtn").click(function(){
            $('.zbbtn').removeClass('active');
            $(this).addClass('active');
            var name=$(this).attr('name');
            var what=$(this).attr('what');
            $("#dptop").attr('name',name);
            $("#dptop").attr('what',what);
            $.get('?show=gsTop&what='+what).done(function (data) {
                // 填入数据
                myChart.setOption({
                    title: {
                        text: name
                    },
                    legend: {
                        data:[name]
                    },
                    xAxis: {
                        data: data.categories
                    },
                    series: [{
                        name: name,
                        label: {
                            normal: {
                                show: true,
                                position: 'inside'
                            }
                        },
                        data: data.data
                    }]
                });
            });
        });
        /*初始化表格*/
        var Customer = $('#ListCustomer').DataTable({
            "processing": true,
            "serverSide": true,
            stateSave: false,
            columnDefs:[{
                orderable:false,//禁用排序
                targets:[0,1]   //指定的列
            }],
            "order": [[1, 'desc']],
            "sDom": '<"top">rt<"bottom"><"clear">',
            bProcessing:true,
            aLengthMenu: [10],        //设置每页显示数据数量
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
                url:"?show=showCustomerDataTbale",
                dataType:"json",
                "dataSrc": function ( json ) {
                    return json.data;
                }
            }
        });
        <!--添加意向单-->
        $(document).on("click",".addintention",function(){
            var czid = $(this).attr('czid');
            $.ajax({
                url: "<?php echo U('Home/Customer/ismember');?>?czid="+czid,
                dataType: 'json',
                type: "post",
                success: function (res) {
                    if(res.code==1){
                        var title="Add intent";
                        var url="<?php echo U('Home/Customer/addintention');?>?cid="+czid;
                        layer.open({
                            skin: 'layui-layer-lan', //默认皮肤
                            type:2,
                            title:title, //标题
                            area: ['80%', '100%'], //宽高
                            //closeBtn:false,
                            shade: 0.5,//遮罩
                            zIndex:1,
                            maxmin: true,  //最大最小化
                            scrollbar: false,
                            zIndex:99999999,
                            //content: [url,'no']
                            content: [url],
                            end: function() {
                                $('#czid').val('');
                                if(Customer){
                                    Customer.ajax.reload(null, false);
                                }
                            }
                        });
                    }else if(res.code==2){
                        layer.msg('Please add a contact');
                        var title='Add a Contact';
                        var url = "<?php echo U('Home/Customer/addlianxiren');?>?cid="+czid;
                        layer.open({
                            skin: 'layui-layer-lan', //默认皮肤
                            type:2,
                            title:title, //标题
                            area: ['80%', '100%'], //宽高
                            //closeBtn:false,
                            shade: 0.5,//遮罩
                            zIndex:1,
                            maxmin: true,  //最大最小化
                            scrollbar: false,
                            zIndex:99999999,
                            //content: [url,'no']
                            content: [url],
                            end: function() {
                                $('#czid').val('');
                                if(Customer){
                                    Customer.ajax.reload(null, false);
                                }
                            }
                        });
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
                url: "<?php echo U('Home/Customer/ismember');?>?czid="+czid,
                dataType: 'json',
                type: "post",
                success: function (res) {
                    if(res.code==1){
                        var title="Add contact record";
                        var url="<?php echo U('Home/Customer/addlianxijilu');?>?cid="+czid;
                        layer.open({
                            skin: 'layui-layer-lan', //默认皮肤
                            type:2,
                            title:title, //标题
                            area: ['80%', '100%'], //宽高
                            //closeBtn:false,
                            shade: 0.5,//遮罩
                            zIndex:1,
                            maxmin: true,  //最大最小化
                            scrollbar: false,
                            zIndex:99999999,
                            //content: [url,'no']
                            content: [url],
                            end: function() {
                                $('#czid').val('');
                                if(Customer){
                                    Customer.ajax.reload(null, false);
                                }
                            }
                        });
                    }else if(res.code==2){
                        layer.msg('Please add a contact');
                        var title='Add a Contact';
                        var url = "<?php echo U('Home/Customer/addlianxiren');?>?cid="+czid;
                        layer.open({
                            skin: 'layui-layer-lan', //默认皮肤
                            type:2,
                            title:title, //标题
                            area: ['80%', '100%'], //宽高
                            //closeBtn:false,
                            shade: 0.5,//遮罩
                            zIndex:1,
                            maxmin: true,  //最大最小化
                            scrollbar: false,
                            zIndex:99999999,
                            //content: [url,'no']
                            content: [url],
                            end: function() {
                                $('#czid').val('');
                                if(Customer){
                                    Customer.ajax.reload(null, false);
                                }
                            }
                        });
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
            var url = "<?php echo U('Home/Customer/addlianxiren');?>?cid="+czid;
            layer.open({
                skin: 'layui-layer-lan', //默认皮肤
                type:2,
                title:title, //标题
                area: ['80%', '100%'], //宽高
                //closeBtn:false,
                shade: 0.5,//遮罩
                zIndex:1,
                maxmin: true,  //最大最小化
                scrollbar: false,
                zIndex:99999999,
                //content: [url,'no']
                content: [url],
                end: function() {
                    $('#czid').val('');
                    if(Customer){
                        Customer.ajax.reload(null, false);
                    }
                }
            });
        });
        //编辑客户
        $(document).on("click",".editFun",function(){
            var czid = $(this).attr('czid');
            var title='Edit Customer';
            var canshu="czid="+czid+"";
            var url = '<?php echo U('Home/Customer/add');?>?table=table&'+canshu;
            layer.open({
                skin: 'layui-layer-lan', //默认皮肤
                type:2,
                title:title, //标题
                area: ['80%', '100%'], //宽高
                //closeBtn:false,
                shade: 0.5,//遮罩
                zIndex:1,
                maxmin: true,  //最大最小化
                scrollbar: false,
                zIndex:99999999,
                //content: [url,'no']
                content: [url],
                end: function() {
                    $('#czid').val('');
                    if(Customer){
                        Customer.ajax.reload(null, false);
                    }
                }
            });
        });
    </script>

</div>
<script>
</script>
</body>
</html>