<extend name="Public/base"/>
<block name="main">
    <input type=hidden id="czid" checked>
    <div class="form-inline searchbar">
        <div class="pull-right btn-group pdl-10" role="group" aria-label="...">
            <button id="delFun" class="btn btn-danger">Delete</button>
            <button type="button" class="btn btn-info" id="btnRefresh"><i class="fa fa-refresh"></i></button>
        </div>
        <table id="ListTbl" class="table table-striped table-bordered hover">
            <thead>
            <tr class="bg-info">
                <th width="5%">No.</th>
                <th width="2%"><input class=SelectAllId type=checkbox sname="pid[]"></th>
                <th width="30%">Score</th>
                <th width="12%">Note</th>
                <th width="15%">Submitter</th>
                <th width="10%">Posttime</th>
                <th width="6%">ID</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>


    <script>
        /*初始化表格*/
        resetFrom();
        $("#delFun").click(function(){
            _del(table,'pid[]');
        });
        var table = $('#ListTbl').DataTable({
            "processing": true,
            "serverSide": true,
            stateSave: false,          //状态保存，使用了翻页或者改变了每页显示数据数量，会保存在cookie中，下回访问时会显示上一次关闭页面时的内容。
            bLengthChange: true,      //改变每页显示数据数量功能开启
            aLengthMenu: [10],        //设置每页显示数据数量
            "order": [[2, 'desc']],
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
            ajax: "?show=showDataTbale"
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
        /*双击调出编辑*/
        $('#ListTbl').on('dblclick','tbody tr',function () {
            var czid=$(this).find("td:last").text();
            $('#czid').val(czid);
            _save("edit");
        });
        /*响应添加*/
        $("#addFun").click(function(){
            var title = "Add Project";
            var url ="{:U('add')}";
            _layerOpen(url, title, '65%', '80%');
        });
        /*响应添加展会*/
        $(document).on("click", ".add", function () {
            var title = "Add Exhibition";
            var czid=$(this).attr('czid');
            var url ="{:U('Expo/add')}?czid="+czid;
            _layerOpen(url, title, '80%', '90%');
        });
        $('#search').click(function(){
            var value=$("#pagesvalue").val()-1;
            table.page(value).draw(false);
        });
    </script>
</block>
