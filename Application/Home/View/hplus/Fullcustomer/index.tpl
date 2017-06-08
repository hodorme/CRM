<extend name="Public/base"/>
<block name="main">
    <input type=hidden id="czid" checked>
    <div class="form-inline">
        <div class="pull-right btn-group pdl-10" role="group" aria-label="...">
            <button type="button" class="btn btn-info" id="btnRefresh"><i class="fa fa-refresh"></i></button>
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li <if condition="$showD eq ''">class=active</if>> <a href="?showD=">Find all clients</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active">
        <table id="ListTbl" class="table table-striped table-bordered hover">
                <thead>
                <tr class="bg-info">
                    <th> No.</th>
                    <th>Company Name</th>
                    <th>Customer type</th>
                    <th>Add time</th>
                    <th>Acct. Manager</th>
                    <th>Detail</th>
                    <th>ID</th>
                </tr>
                </thead>
                <tbody align="center">
                </tbody>
            </table>
        </div>
    <script>
            /*重置表单*/
            resetFrom();
            layui.use('form', function() {
                var form = layui.form();
                form.on('select(searchselect)', function(data){
                    var value = data.value;
                    var col=$(data.elem).attr('col');
                    if(value){
                        table.column(col).search(value).draw();
                    }else{
                        table.column(col).search("").draw();
                    }
                });
            });
            <eq name="FullSearch" value=""> $("#FullSearch").hide();</eq>
            $("#addForm").hide();
            /*基础设置*/
            $("#addFun").click(function(){
                _save("create");
            });
            $("#editFun").click(function(){
                _save("edit");
            });
            $("#delFun").click(function(){
                _del(table);
            });
                var table = $('#ListTbl').DataTable({
                    "processing": true,
                    "serverSide": true,
                    stateSave: false,
                    columnDefs:[{
                        orderable:false,//禁用排序
                        targets:[0,1]   //指定的列
                    }],
                    "order": [[2, 'asc']],
                    "sDom": '<"top">rt<"bottom"ip><"clear">',
                    bProcessing:true,
                    aLengthMenu: [10],        //设置每页显示数据数量
                    bLengthChange: true,
                    // bInfo:true,
                    //bAutoWidth: true,
                    paging:true,
                    createdRow: function( row, data, dataIndex ) {
                        $(row).children('td').eq(1).attr('style', 'text-align: left;')
                    },
                    ordering: true,
                    info:true,
                    searching: true,
                    autoWidth: false,
                    ajax:"?show=showDataTbale&showD={$showD}&title={$title}"
                });
                /*调用自定义 */
                _customSearch(table);
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
            /*双击调出编辑*/
            $('#ListTbl').on('dblclick','tbody tr',function () {
                var czid=$(this).find("td:last").text();
                $(this).addClass('selected');
                $('#czid').val(czid);
            });
            //鼠标经过
            $('#ListTbl').on('mouseover','tbody tr',function () {
                var czid=$(this).find("td:last").text();
                var tr=$(this);
                $.ajax({
                    url: "{:U('Home/Fullcustomer/record')}?czid="+czid,
                    dataType: 'json',
                    type: 'POST',
                    success: function (res) {
                        var trHTML='';
                        $.each(res, function (i, item) {
                            trHTML+="[联系记录："+item.posttime+"]"+item.note+"\r\n\r";
                        });
                        tr.attr('title',trHTML);
                    }
                });
            });
    </script>
</block>
