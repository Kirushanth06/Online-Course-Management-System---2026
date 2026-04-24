function validateContactForm() {
    let name = document.forms["contactForm"]["name"].value;
    let email = document.forms["contactForm"]["email"].value;
    let message = document.forms["contactForm"]["message"].value;
    
    if (name.trim() == "") {
        alert("Name must be filled out");
        return false;
    }
    if (email.trim() == "") {
        alert("Email must be filled out");
        return false;
    }
    if (message.trim() == "") {
        alert("Message must be filled out");
        return false;
    }
    return true;
}

function validateRegisterForm() {
    let name = document.forms["registerForm"]["name"].value;
    let email = document.forms["registerForm"]["email"].value;
    let password = document.forms["registerForm"]["password"].value;
    
    if (name.trim() == "" || email.trim() == "" || password.trim() == "") {
        alert("Name, Email, and Password are required");
        return false;
    }
    if (password.length < 6) {
        alert("Password must be at least 6 characters");
        return false;
    }
    return true;
}

function validateLoginForm() {
    let email = document.forms["loginForm"]["email"].value;
    let password = document.forms["loginForm"]["password"].value;
    
    if (email.trim() == "" || password.trim() == "") {
        alert("Email and password are required");
        return false;
    }
    return true;
}
