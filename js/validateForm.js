function validateForm(form){
    var username = validateUsername(form.username, 'usernameFeedback');
    var fname = validateName(form.fName, 'nameFeedback');
    var surname = validateSurname(form.surname, 'surnameFeedback');
    var extension = validateExtension(form.extension, 'extensionFeedback');
    var pword = validatePassword(form.passwordInput, 'passwordFeedback');
    var cfirmPword = validateConfirmPassword(form, 'confirmFeedback');

    if (username == false || fname == false || surname == false || extension == false || pword == false || cfirmPword == false){
        return false;
    }
}