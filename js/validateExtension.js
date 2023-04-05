function validateExtension(field, errorField){
    var errorMessage = document.querySelector("[name='" + errorField + "']"); 

    if (field.value.length == 0){
        field.className = "form-control is-invalid";
        errorMessage.textContent = "Please enter an extension";
        return false;
    } else if (isNaN(field.value)){
        field.className = "form-control is-invalid";
        errorMessage.textContent = "Must be a number";
    } else if (field.value.length > 4){
        field.className = "form-control is-invalid";
        errorMessage.textContent = "Extension must not be more than 4 digits";
        return false;
    } else if (field.value.length < 4){
        field.className = "form-control is-invalid";
        errorMessage.textContent = "Extension must be 4 digits";
        return false;
    } else {
        field.className = "form-control";
        errorMessage.textContent = "";
        return true;
    }

}
