function validateConfirmPassword(field, errorField){
    // Create shortcut var
    var errorMessage = document.querySelector("[name='" + errorField + "']"); 

    if (field.confirmPassword.value != field.passwordInput.value){
        field.confirmPassword.className = "form-control is-invalid";
        errorMessage.textContent = "Passwords do not match";
        return false;                
    } else if (field.confirmPassword.value.length == 0){
        field.confirmPassword.className = "form-control is-invalid";
        errorMessage.textContent = "Please confirm password";
        return false;
    } else if (field.confirmPassword.value.length < 5){
        field.confirmPassword.className = "form-control is-invalid";
        errorMessage.textContent = "Password must be more than 4 chars";
        return false;
    } else {
        field.confirmPassword.className = "form-control";
        errorMessage.textContent = "";
        return true;
    }

}

