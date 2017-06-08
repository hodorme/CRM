function SelectAll(form)
   {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name == 'id')
       e.checked = form.ChkAll.checked;
    }
	}
function check(){
	if(confirm("请选择要操作的项！")){	
	var chked;
	chked=false;
    for(var i=0;i<listform.elements.length;i++)
    {
       var e = listform.elements[i];
       if (e.name=='id'&&e.checked==true)
        { chked=true;
	       break;}
    }
	if(chked==false){
	alert("请选择要操作的项！");
	return false;	
	}
	return true;
	}
	else
	{return false;}
	
	}
function checkcaozuo(subwhat)
{
		var i;
		id_arr = document.getElementsByName("id")
		for(i = 0;i < id_arr.length;i++)
		{
		 if(id_arr[i].checked)
		 {
		 	a = true;
			break;
		 }
		 else
		 {
		 	a = false;
		 }
		}
		if (a == true)
		{
			document.listform.action="?sub="+subwhat;
			document.listform.submit();
			alert(id_arr);
		}
		else
		{
			alert("请选择要操作的项！");
			return false;
		}
}
		var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="neirong"]', {
					allowFileManager : true
				});
			});
			KindEditor.ready(function(K) {
				var editor = K.editor({
					allowFileManager : true
				});
				K('#image1').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							imageUrl : K('#tu').val(),
							clickFn : function(url, title, width, height, border, align) {
								K('#tu').val(url);
								editor.hideDialog();
							}
						});
					});
				});
			});