/*package functions START */
function PacIncQty(qty){	
	var result = parseInt(qty)+1;	
	$('#quantity').val(result);	
}

function PacDecQty(qty){
	var result = parseInt(qty)-1;
	if(result <=0)
		result  =1;
	$('#quantity').val(result);
}