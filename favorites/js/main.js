//Category validation function 
function validateCategory(field){
	var error ="";
	//Make sure a category is selected
	if($('#category:selected').length==0) {
		error = "Please select an item in the list.\n";
	}
	return error;
}
					