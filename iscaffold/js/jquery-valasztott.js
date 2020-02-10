$(document).ready(function(){

   $("select[name='konzulens_id']").change(function(){
      $.post('Valasztott/szabadhely/',{id:$("select[name='konzulens_id'] option:selected").val()},function(data){
         if (data < 1) {
   			$("#szabadhely").addClass("error");
   		}else{
   			$("#szabadhely").removeClass("error");
   		}
   		$("#szabadhely").html("A kiválasztott konzulensnek "+data+" szabad helye van");
         });
    });


   $("select[name='valasztott_tema_id']").change(function(){
   	
   		if ($("select[name='valasztott_tema_id'] option:selected").html() != 'Saját téma') {
   		$("input[name=valasztott_cim]").val($("select[name='valasztott_tema_id'] option:selected").html());
   		}else{
   			$("input[name=valasztott_cim]").val('');
   		}
   	});
});