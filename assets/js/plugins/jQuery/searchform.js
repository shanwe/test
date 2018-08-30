

//搜索表单校验
$(document).ready(function(){
	
	$("#globalsearchform").submit(function(){
		if($("#globalsearchform_key")[0].value==""){
			alert("請輸入搜尋關鍵字");
			return false;
		}
		return true;
	});
}); 