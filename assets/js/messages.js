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
                url: "http://nmvc.site/",
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

    const editTemp = (idMess, idUs, name, mes) =>{ return `
        <li className="mesWrapper" data-id="${idMess}">
            <div className="infRow">
                <div>
                    <h4 class="tlt"></h4>
                    <span class="us">
                        by <a href='/user?id=${idUs}' class='userLink'>${name}</a>
                    </span>
                </div>
                <p class="tm"></p>
            </div>
            <hr>
                <div class="ms">
                    ${mes}
                </div>
        </li>
        `};

    const edit = [...document.querySelectorAll(".edit")];
    edit.forEach(item => {
        item.addEventListener("click", e => {
            e.preventDefault();
            const id = item.data.id;
            const divMes = document.querySelector(`#message-${id}`);
            const li = document.querySelector(`#li-${id}`);
            const title = document.querySelector(`#title-${id}`);
            li.innerHTML = editTemp(id, 50, "name", divMes);
            return null;
        });
    });

});