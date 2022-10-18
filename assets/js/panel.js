window.addEventListener('DOMContentLoaded', (event) => {

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

});