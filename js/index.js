// If nothing in this search so disable search button
let search = document.getElementById('search');
search.addEventListener('input', (e) => {
    if (e.target.value.length === 0) {
        document.getElementById('searchBtn').disabled = true;
    }
    else {
        document.getElementById('searchBtn').disabled = false;
    }
});
search.addEventListener('blur', (e) => {
    if (e.target.value.length === 0) {
        document.getElementById('searchBtn').disabled = true;
    }
    else {
        document.getElementById('searchBtn').disabled = false;
    }
});

window.onload = () => {
    // Scripts for close alert
    document.querySelectorAll('.alert .btn-close')
        .forEach((element) => {
            setTimeout(() => {
                element.click();
            }, 3000);
        });
}

// Add event listener in all input tag
Array.from(document.getElementsByTagName('input')).forEach((element)=>{
    element.addEventListener('input', (e)=>{
        e.target.classList.remove('is-invalid');
    });
});
// Add event listener in all textarea tag
Array.from(document.getElementsByTagName('textarea')).forEach((element)=>{
    element.addEventListener('input', (e)=>{
        e.target.classList.remove('is-invalid');
    });
});

try {
    // Validate login form
    let validLoginEmail = false;
    let validLoginPassword = false;
    // Event listener for login email
    let loginemail = document.getElementById('loginemail');
    loginemail.addEventListener('blur', (e) => {
        let regex = /^[a-zA-Z]([a-zA-Z0-9\_\-\.])+@([a-zA-Z0-9])([a-zA-Z0-9\_\-\.])+\.([a-zA-Z])+$/;
        if (regex.test(e.target.value)) {
            e.target.classList.remove('is-invalid');
            validLoginEmail = true;
        }
        else {
            e.target.classList.add('is-invalid');
            validLoginEmail = false;
        }
        loginButton();
    });
    // Event listener for login password
    let loginpassword = document.getElementById('loginpassword');
    loginpassword.addEventListener('blur', (e) => {
        let regex = /^(\S+){6,55}$/g;
        if (regex.test(e.target.value)) {
            e.target.classList.remove('is-invalid');
            validLoginPassword = true;
        }
        else {
            e.target.classList.add('is-invalid');
            validLoginPassword = false;
        }
        loginButton();
    });
    // function for active signin btn
    function loginButton() {
        if (validLoginEmail && validLoginPassword) {
            document.getElementById('loginBtn').disabled = false;
        }
        else {
            document.getElementById('loginBtn').disabled = true;
        }
    }
} catch { }

try {
    // Validate signup form
    let validSignupFirstName = false;
    let validSignupLastName = true;
    let validSignupEmail = false;
    let validSignupPassword = false;
    let validSignuCpPassword = false;
    // Event listener for Sign up first name
    let signupfirstname = document.getElementById('signupfirstname');
    signupfirstname.addEventListener('blur', (e) => {
        let regex = /^([a-zA-Z])+([a-zA-Z1-9]){0,}\s?([a-zA-Z1-9]){0,}$/;
        if (regex.test(e.target.value)) {
            e.target.classList.remove('is-invalid');
            validSignupFirstName = true;
        }
        else {
            e.target.classList.add('is-invalid');
            validSignupFirstName = false;
        }
        signUpButton();
    });
    // Event listener for Sign up last name
    let signuplastname = document.getElementById('signuplastname');
    signuplastname.addEventListener('blur', (e) => {
        let regex = /^([a-zA-Z]){0,}([a-zA-Z1-9]){0,}$/;
        if (regex.test(e.target.value)) {
            e.target.classList.remove('is-invalid');
            validSignupLastName = true;
        }
        else {
            e.target.classList.add('is-invalid');
            validSignupLastName = false;
        }
        signUpButton();
    });
    // Event listener for Sign up email
    let signupemail = document.getElementById('signupemail');
    signupemail.addEventListener('blur', (e) => {
        let regex = /^[a-zA-Z]([a-zA-Z0-9\_\-\.])+@([a-zA-Z0-9])([a-zA-Z0-9\_\-\.])+\.([a-zA-Z])+$/;
        if (regex.test(e.target.value)) {
            e.target.classList.remove('is-invalid');
            validSignupEmail = true;
        }
        else {
            e.target.classList.add('is-invalid');
            validSignupEmail = false;
        }
        signUpButton();
    });
    // Event listener for Signup  password
    let signuppassword = document.getElementById('signuppassword');
    signuppassword.addEventListener('blur', (e) => {
        let regex = /^(\S+){6,55}$/g;
        if (regex.test(e.target.value)) {
            e.target.classList.remove('is-invalid');
            validSignupPassword = true;
        }
        else {
            e.target.classList.add('is-invalid');
            validSignupPassword = false;
        }
        signUpButton();
    });
    // Event listener for Signup confirm password
    let csignuppassword = document.getElementById('csignuppassword');
    csignuppassword.addEventListener('blur', (e) => {
        if (signuppassword.value == e.target.value) {
            e.target.classList.remove('is-invalid');
            validSignuCpPassword = true;
        }
        else {
            e.target.classList.add('is-invalid');
            validSignuCpPassword = false;
        }
        signUpButton();
    });
    // function for active signin btn
    function signUpButton() {
        if (validSignupFirstName && validSignupLastName && validSignupEmail && validSignupPassword && validSignuCpPassword) {
            document.getElementById('signupBtn').disabled = false;
        }
        else {
            document.getElementById('signupBtn').disabled = true;
        }
    }
} catch { }

try {
    // Validate contact form
    let validContactFirstName = false;
    let validContactLastName = false;
    let validContactEmail = false;
    let validContactPhone = true;
    let validContactMessage = false;
    // Event listener for contact first name
    let contact_first_name = document.getElementById('contact_first_name');
    contact_first_name.addEventListener('blur', (e) => {
        let regex = /^([a-zA-Z])+([a-zA-Z1-9]){0,}\s?([a-zA-Z1-9]){0,}$/;
        if (regex.test(e.target.value)) {
            e.target.classList.remove('is-invalid');
            validContactFirstName = true;
        }
        else {
            e.target.classList.add('is-invalid');
            validContactFirstName = false;
        }
        contactButton();
    });
    // Event listener for contact last name
    let contact_last_name = document.getElementById('contact_last_name');
    contact_last_name.addEventListener('blur', (e) => {
        let regex = /^([a-zA-Z]){0,}([a-zA-Z1-9]){0,}$/;
        if (regex.test(e.target.value)) {
            e.target.classList.remove('is-invalid');
            validContactLastName = true;
        }
        else {
            e.target.classList.add('is-invalid');
            validContactLastName = false;
        }
        contactButton();
    });
    // Event listener for contact email
    let contact_email = document.getElementById('contact_email');
    contact_email.addEventListener('blur', (e) => {
        let regex = /^[a-zA-Z]([a-zA-Z0-9\_\-\.])+@([a-zA-Z0-9])([a-zA-Z0-9\_\-\.])+\.([a-zA-Z])+$/;
        if (regex.test(e.target.value)) {
            e.target.classList.remove('is-invalid');
            validContactEmail = true;
        }
        else {
            e.target.classList.add('is-invalid');
            validContactEmail = false;
        }
        contactButton();
    });
    // Event listener for contact phone
    let contact_phone = document.getElementById('contact_phone');
    contact_phone.addEventListener('blur', (e) => {
        let regex = /^((\+91)?0?([0-9]){10})?$/;
        if (regex.test(e.target.value)) {
            e.target.classList.remove('is-invalid');
            validContactPhone = true;
        }
        else {
            e.target.classList.add('is-invalid');
            validContactPhone = false;
        }
        contactButton();
    });
    // Event listener for contact phone
    let contact_message = document.getElementById('contact_message');
    contact_message.addEventListener('blur', (e) => {
        let regex = /^(.){3,}$/;
        if (regex.test(e.target.value)) {
            e.target.classList.remove('is-invalid');
            validContactMessage = true;
        }
        else {
            e.target.classList.add('is-invalid');
            validContactMessage = false;
        }
        contactButton();
    });
    // function for active contact btn
    function contactButton() {
        if (validContactFirstName && validContactLastName && validContactEmail && validContactPhone && validContactMessage) {
            document.getElementById('contactBtn').disabled = false;
        }
        else {
            document.getElementById('contactBtn').disabled = true;
        }
    }
} catch { }