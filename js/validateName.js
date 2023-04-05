// Name Validator
function validateName(field, errorField){
    var errorMessage = document.querySelector("[name='" + errorField + "']"); 

    if (field.value.length == 0){
        field.className = "form-control is-invalid";
        errorMessage.textContent = "Please enter a first name";
        return false;
    } else if (field.value.length > 50){
        field.className = "form-control is-invalid";
        errorMessage.textContent = "First Name must not be more than 50 chars";
        return false;
    } else {
        field.className = "form-control";
        errorMessage.textContent = "";
        return true;
    }
}