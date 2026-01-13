const usernameError = document.getElementById("usernameError");
const passwordError = document.getElementById("passwordError");
const passwordField = document.getElementById("password");
const confirmPasswordField = document.getElementById("passwordConfirmation");

/**
 * Validates the username field to ensure it contains only allowed characters
 * @param {string} value - The username input value to validate
 */
export function checkUsernameField(value) {
    const regex = /^[a-zA-Z0-9_]+$/;

    if (!regex.test(value)) {
        usernameError.classList.remove("hidden");
    } else {
        usernameError.classList.add("hidden");
    }
}

/**
 * Validates the confirm password field to ensure it matches with the password field
 */
export function checkPasswordField() {
    if (passwordField.value != confirmPasswordField.value && confirmPasswordField.value != '') {
        passwordError.classList.remove("hidden");
    } else {
        passwordError.classList.add("hidden");
    }
}

/**
 * Checks for any visible error messages in the form before submission
 * @param {Event} event - The form submission event
 * @returns {void} - Either submits the form or displays an alert
 */
export function checkFormErrors(event) {
    let hasErrors = false;
    
    const errorElements = document.querySelectorAll(".error");

    errorElements.forEach((errorElement) => {
        if (!errorElement.classList.contains('hidden')) {
            hasErrors = true;
        }
    });

    if (hasErrors) {
        alert("Please fix the errors before submitting!");
    } else {
        event.target.submit();
    }
}