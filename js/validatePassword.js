// Password Validator
function validatePassword(field, errorField){
    // Create shortcut var
    var errorMessage = document.querySelector("[name='" + errorField + "']"); 

    // Display appropriate error message according to error criteria. Reset if field is valid.
    if (field.value.length == 0){
        field.className = "form-control is-invalid";
        errorMessage.textContent = "Please enter password";
        return false;
    } else if (field.value.length < 5){
        field.className = "form-control is-invalid";
        errorMessage.textContent = "Password must be more than 4 chars";
        return false;
    } else {
        field.className = "form-control";
        errorMessage.textContent = "";
        return true;
    }
}
