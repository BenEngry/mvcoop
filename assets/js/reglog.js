// window.addEventListener("DOMContentLoaded", ()=>{
    
// // const inputs

// const password = document.querySelector("#password");
// const email = document.querySelector("#email");
// const name = document.querySelector("#name");

// // submit form button

// // data object

// const DOMarrElements =[ 
//     {
//         DOMelement: password,
//         value: ""
//     },
//     {
//         DOMelement: email,
//         value: ""
//     },
//     {
//         DOMelement: name,
//         value: ""
//     }
// ];

// // envet onChange on evry inputs

// DOMarrElements.map((item)=>{
//     item.DOMelement.addEventListener("change", ()=>{
//         item.value = item.DOMelement.value ? item.DOMelement.value : undefined;
//     })
// })

// // async function postData(url = '', data = {}) {
// //     const response = await fetch(url, {
// //         method: 'POST',
// //         headers: {
// //           'Content-Type': 'application/json',
// //         },
// //         body: JSON.stringify(data)
// //     });
// //     return response.json(); 
// // }

// submit.addEventListener("click",(e)=>{
//     e.preventDefault();

//     const url = "../../php/server.php";

//     const passwordval = DOMarrElements[0].value;
//     const emailval = DOMarrElements[1].value;
//     const nameval = DOMarrElements[2].value;

//     // postData(url, {
//     //     password: passwordval,
//     //     email: emailval,
//     //     name: nameval
//     // })
//     //     .then(reuslt=>console.log(reuslt));

//     fetch("../../php/server.php", {
//         method: 'GET'
//         // body: "formData"
//     }).then(response => response.json())

// });

// });

