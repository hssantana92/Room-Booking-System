function validateUsername(field, errorField){
    var errorMessage = document.querySelector("[name='" + errorField + "']"); 

    if (field.value.length == 0){
        field.className = "form-control is-invalid";
        errorMessage.textContent = "Please enter username";
        return false;
    } else if (field.value.length < 5){
        field.className = "form-control is-invalid";
        errorMessage.textContent = "Username must be more than 4 chars";
        return false;
    } else if (field.value.length >= 5){
        field.className = "form-control";
        errorMessage.textContent = "";
        return true;
    }

}
