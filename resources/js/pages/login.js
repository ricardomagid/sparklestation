import { newNotification } from "../notifications";

const pageTitle = document.getElementById("pageTitle");
const loginForm = document.getElementById("loginForm");
const changePasswordForm = document.getElementById("changePasswordForm");
const changeFormText = document.querySelector(".change-form");
const texts = { forgotPassword: ['Forgot your password?', "Reset password"], backToLogin: ['Remember your password?', "Back to Login"] }
const pageTitles = {forgotPassword: "Login", backToLogin: "Change Password"}
let cooldownActive = false;

export function toggleForm() {
    if (!loginForm || !changePasswordForm || !changeFormText) return;
    const currentStatus = loginForm.classList.contains("hidden") ? "forgotPassword" : "backToLogin";
    changePasswordForm.classList.toggle("hidden");
    loginForm.classList.toggle("hidden");
    changeFormText.childNodes[0].nodeValue = texts[currentStatus][0] + " ";
    changeFormText.querySelector("a").textContent = texts[currentStatus][1];
    pageTitle.textContent = pageTitles[currentStatus];
}

export function sendVerificationCode(button) {
    if (cooldownActive) {
        newNotification("error", "Please wait before requesting another code.");
        return;
    }
    const email = document.getElementById("checkEmail").value.trim();
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!re.test(email)) {
        newNotification("error", "Please write a valid email address.");
        return;
    }

    button.disabled = true;
    cooldownActive = true;
    const originalText = button.textContent;
    let timeLeft = 10;
    button.textContent = `Wait ${timeLeft}s...`;

    const countdown = setInterval(() => {
        timeLeft--;
        button.textContent = `Wait ${timeLeft}s...`;

        if (timeLeft == 0) {
            clearInterval(countdown);
            button.disabled = false;
            button.textContent = originalText;
            cooldownActive = false;
        }
    }, 1000)

    fetch('api/email/verification', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email: email })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                newNotification("success", "Verification code sent to your email!");
            } else {
                newNotification("error", `Failed to send verification email${data.message ? `: ${data.message}` : '.'}`)
            }
        })
        .catch(error => {
            newNotification("error", "An error occurred. Please try again.");
            console.error(error)
        });
}

export function checkPasswords(e) {
    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if (newPassword != confirmPassword) {
        e.preventDefault();
        newNotification("error", "Passwords do not match.");
        return false;
    }

    return true;
}