window.addEventListener("DOMContentLoaded", (e)=>{
    
const translate = document.querySelector("#translate")

translate.addEventListener("change", ()=>{
    const form = document.querySelector("#trans");
    form.submit();
});

const managerBtn = [...document.querySelectorAll("#manager")];
const adminBtn = [...document.querySelectorAll("#admin")];

const adminView = (liId, liName, liTime, liTitle, liMessage) => {
    return `
        <form method="POST" id="lid-<?= $message['id'] ?>">
            <label for="id"><strong>Id :</strong> ${liId}</label><br>
            <input type="text" name="id" style="display: none" value="${liId}"></input><br>
            <label for="name"><strong>Name :</strong> ${liName}</label><br>
            <input type="text" name="name" placeholder=${liName}></input><br>
            <label for="title"><strong>Title :</strong> ${liTitle}</label><br>
            <input type="text" name="title" placeholder=${liTitle}></input><br>
            <label for="message"><strong>Message :</strong> ${liMessage}</label><br>
            <input type="text" name="message" placeholder=${liMessage}></input><br>
            <label><strong>Created at :</strong> ${liTime}</label><br>
            <input type="submit" id="manager">Save M</input>
            <hr>
        </form>
    `
} // я гений за айди

const managerView = () => {
    return `
    <form method="POST" id="lid-<?= $message['id'] ?>">
        <label><strong>Id :</strong> ${liId}</label><br>
        <label><strong>Name :</strong> ${liName}</label><br>
        <label for="title"><strong>Title :</strong> ${liTitle}</label><br>
        <input type="text" name="title" placeholder=${liTitle}></input><br>
        <label for="message"><strong>Message :</strong> ${liMessage}</label><br>
        <input type="text" name="message" placeholder=${liMessage}></input><br>
        <label><strong>Created at :</strong> ${liTime}</label><br>    
        <input type="submit" id="manager">Save M</input>
        <hr>
    </form>
    `
}

adminBtn.map(item=>{
    item.addEventListener("click", (e)=>{
        e.preventDefault();
        const id = item.value;
        const li = document.querySelector(`#lid-${id}`);
        const liId = document.querySelector(`#lid-${id}-id`).innerHTML;
        const liName = document.querySelector(`#lid-${id}-name`).innerHTML;
        const liTime = document.querySelector(`#lid-${id}-time`).innerHTML;
        const liTitle = document.querySelector(`#lid-${id}-title`).innerHTML;
        const liMessage = document.querySelector(`#lid-${id}-message`).innerHTML;
        li.innerHTML = adminView(liId, liName, liTime, liTitle, liMessage);
        return null;
    })
});

managerBtn.map(item=>{
    item.addEventListener("click", (e)=>{
        e.preventDefault();
        const id = item.value;
        const li = document.querySelector(`#lid-${id}`);
        const liId = document.querySelector(`#lid-${id}-id`).innerHTML;
        const liName = document.querySelector(`#lid-${id}-name`).innerHTML;
        const liTime = document.querySelector(`#lid-${id}-time`).innerHTML;
        const liTitle = document.querySelector(`#lid-${id}-title`).innerHTML;
        const liMessage = document.querySelector(`#lid-${id}-message`).innerHTML;
        li.innerHTML = managerView(liId, liName, liTime, liTitle, liMessage);
        return null;
    })
});

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

// changeEmail.addEventListener("click", e=>{
//     e.preventDefault();
// });

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

// add admin buttons events

const adminButtons = [...document.querySelectorAll(".btn")];

adminButtons.forEach(item => {

    item.addEventListener("click", e => {
        e.preventDefault();
        const id = item.dataset.id;
        const type = item.dataset.type;
        const data = {
            id : id,
            type : type
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
    })
})

const promotionView = () => {
    return `
    <form method="POST" class="changeForm">
        <legend>Describe why are u need this promotion:</legend>
        <label for="desc">Enter pass:</label><br>
        <input id="desc" type="text" name="desc" placeholder="Describe here"><br>
        <button type="submit" id="changeSubmit" data-type="promotion">Send</button>
    </form>
`
};

const promotionBtn = document.querySelector("#promotion");


promotionBtn.addEventListener("click", (e) => {
    e.preventDefault();
    const forms = document.querySelector(".forms");
    if (document.querySelector(".changeForm")) {
        forms.innerHTML = "";
    } else {
        forms.innerHTML = promotionView();

        const changeSubmitBtn = document.querySelector("#changeSubmit");

        changeSubmitBtn.addEventListener("click", e => {
            e.preventDefault();

            const id = document.querySelector(".infoUser").dataset.id;
            const type = changeSubmitBtn.dataset.type;
            const desc = document.querySelector("#desc").value;

            const data = {
                type : type,
                id : id,
                desc : desc
            };

            $.ajax({
                url: "http://nmvc.site/profile",
                method: "POST",
                data : data,
                dataType : "json",
                success : function (data) {
                    if(!data.status) {
                        alert("Your promotion on consider.");
                    }
                    if(data.status) {
                        alert("Your promotion is sended!up");
                    }
                }
            })
        });

    }

});


// const register = document.querySelector("#register");
// const login = document.querySelector("#login");

// const body = document.body;

// body.addEventListener("click", (e)=>{
    
//     const target = e.target;

//     // console.log(target);

//     // let password;
//     // let email;
//     // let name;

//     // const DOMarrElements =[ 
//     //     {
//     //         DOMelement: password,
//     //         value: ""
//     //     },
//     //     {
//     //         DOMelement: email,
//     //         value: ""
//     //     },
//     //     {
//     //         DOMelement: name,
//     //         value: ""
//     //     }
//     // ];

//     // if (document.querySelector(".regform")) {

//     //     password = document.querySelector("#password");
//     //     email = document.querySelector("#email");
//     //     name = document.querySelector("#name");

//     //     DOMarrElements.map((item)=>{
//     //         item.DOMelement.addEventListener("change", ()=>{
//     //             item.value = item.DOMelement.value ? item.DOMelement.value : undefined;
//     //         })
//     //     })

//     //     console.log(TESTDOMarrElements);
//     // }

// });

});
