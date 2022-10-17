window.addEventListener('DOMContentLoaded', (event) => {


const changePassView = () => {
    return `
<form method="POST" class="changeForm">
    <legend>Change password</legend>
    <label for="oldpassword">Enter curent pass:</label><br>
    <input id="enteredpassword" type="text" name="oldpassword" placeholder="new password"><br>
    <label for="newpassword">Enter new pass:</label><br>
    <input id="newpassword" type="text" name="newpassword" placeholder="new password"><br>
    <label for="repeatpassword">Repeat pass:</label><br>
    <input id="conifrimpassword" type="text" name="repeatpassword" placeholder="new password"><br>
    <button type="submit" id="changeSubmit" data-type="password">Change</button>
</form>`
}

const changeEmailView = () => {
    return `
<form method="POST" class="changeForm">
    <legend>Change email</legend>
    <label for="oldpassword">Enter pass:</label><br>
    <input id="enteredpassword" type="text" name="oldpassword" placeholder="new password"><br>
    <label for="newpassword">Enter new email:</label><br>
    <input id="newpassword" type="text" name="newpassword" placeholder="new password"><br>
    <label for="repeatpassword">Repeat email:</label><br>
    <input id="conifrimpassword" type="text" name="repeatpassword" placeholder="new password"><br>
    <button type="submit" id="changeSubmit" data-type="email">Change</button>
</form>`
}

const changeEmail = document.querySelector("#changeEmail");
const changePass = document.querySelector("#changePass");

changePass.addEventListener("click", (e) => {
    e.preventDefault();
    const forms = document.querySelector(".forms");
    if (document.querySelector(".changeForm")) {
        forms.innerHTML = "";
    } else {
        forms.innerHTML = changePassView();

        const changeSubmitBtn = document.querySelector("#changeSubmit");
        const changeForm = document.querySelector(".changeForm");

        changeSubmitBtn.addEventListener("click", e => {
            e.preventDefault();
            console.log(changeSubmitBtn);

            const type = changeSubmitBtn.dataset.type;
            const login = document.querySelector("#login").dataset.login;
            const enteredpassword = document.querySelector("#enteredpassword").value;
            const newpassword = document.querySelector("#newpassword").value;
            const conifrimpassword = document.querySelector("#conifrimpassword").value;

            if (!newpassword === conifrimpassword || !newpassword === enteredpassword) {
                console.log("error");
            } else {
                const data = {
                    type : type,
                    login : login,
                    enteredpassword : enteredpassword,
                    newpassword : newpassword
                };

                $.ajax({
                    url: "http://nmvc.site/profile",
                    method: "POST",
                    data : data,
                    dataType : "json",
                    success : function (data) {
                        if(data.status) {
                            location.reload();
                        }
                    }
                })
            }
        });

    }

});


changeEmail.addEventListener("click", (e) => {
    e.preventDefault();
    const forms = document.querySelector(".forms");
    if (document.querySelector(".changeForm")) {
        forms.innerHTML = "";
    } else {
        forms.innerHTML = changeEmailView();

        const changeSubmitBtn = document.querySelector("#changeSubmit");
        const changeForm = document.querySelector(".changeForm");

        changeSubmitBtn.addEventListener("click", e => {
            e.preventDefault();

            const type = changeSubmitBtn.dataset.type;
            const login = document.querySelector("#login").dataset.login;
            const enteredpassword = document.querySelector("#enteredpassword").value;
            const newpassword = document.querySelector("#newpassword").value;
            const conifrimpassword = document.querySelector("#conifrimpassword").value;

            if (!newpassword === conifrimpassword || !newpassword === enteredpassword) {
                //togle error
            } else {
                const data = {
                    type : type,
                    login : login,
                    enteredpassword : enteredpassword,
                    newpassword : newpassword
                };

                $.ajax({
                    url: "http://nmvc.site/profile",
                    method: "POST",
                    data : data,
                    dataType : "json",
                    success : function (data) {
                        if(data.status) {
                            location.reload();
                        }
                    }
                })
            }
        });

    }

});


});