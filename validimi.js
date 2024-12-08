document.addEventListener("DOMContentLoaded", function () {
    const registerBtn = document.getElementById('registerBtn');
    const loginBtn = document.getElementById('loginBtn');
    
    const validateRegister = (ngjarja) => {
        ngjarja.preventDefault();

        const emri = document.getElementById('emri');
        const mbiemri = document.getElementById('mbiemri');
        const emailin = document.getElementById('adresaEmail');
        const fjalkalimi = document.getElementById('pass');
        const konfirmoFjalkalimi = document.getElementById('konfirmoPass');

        if (emri.value.trim() === "") {
            alert("Ju lutem shtoni emrin tuaj.");
            emri.focus();
            return false;
        }
        if (mbiemri.value.trim() === "") {
            alert("Ju lutem shtoni mbiemrin tuaj.");
            mbiemri.focus();
            return false;
        }
        if (emailin.value === "") {
            alert("Ju lutem shtoni email-in.");
            emailin.focus();
            return false;
        }
        if (!emailValid(emailin.value)) {
            alert("Ju lutem shkruani një email të vlefshëm.");
            emailin.focus();
            return false;
        }
        if (fjalkalimi.value === "") {
            alert("Ju lutem shtoni fjalëkalimin.");
            fjalkalimi.focus();
            return false;
        }
        if (konfirmoFjalkalimi.value === "") {
            alert("Ju lutem konfirmoni fjalëkalimin.");
            konfirmoFjalkalimi.focus();
            return false;
        }
        if (fjalkalimi.value.length < 8) {
            alert("Fjalëkalimi duhet të jetë të paktën 8 karaktere.");
            fjalkalimi.focus();
            return false;
        }
        if (fjalkalimi.value !== konfirmoFjalkalimi.value) {
            alert("Fjalëkalimet nuk përputhen.");
            konfirmoFjalkalimi.focus();
            return false;
        }
        alert("Regjistrimi u krye me sukses!");
        return true;
    };

    const validateLogin = (ngjarja) => {
        ngjarja.preventDefault();

        const emailin = document.getElementById('adresaEmail');
        const fjalkalimi = document.getElementById('pass');

        if (emailin.value === "") {
            alert("Ju lutem shtoni email-in.");
            emailin.focus();
            return false;
        }
        if (!emailValid(emailin.value)) {
            alert("Ju lutem shkruani një email të vlefshëm.");
            emailin.focus();
            return false;
        }
        if (fjalkalimi.value === "") {
            alert("Ju lutem shtoni fjalëkalimin.");
            fjalkalimi.focus();
            return false;
        }
        if (fjalkalimi.value.length < 8) {
            alert("Fjalëkalimi duhet të jetë të paktën 8 karaktere.");
            fjalkalimi.focus();
            return false;
        }
        alert("Login u krye me sukses!");
        return true;
    };

    const emailValid = (email) => {
        const emailRegex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
        return emailRegex.test(email.toLowerCase());
    };

    if (registerBtn) {
        registerBtn.addEventListener('click', validateRegister);
    }

    if (loginBtn) {
        loginBtn.addEventListener('click', validateLogin);
    }

});
