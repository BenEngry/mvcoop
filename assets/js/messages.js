window.addEventListener('DOMContentLoaded', (event) => {

    const adminButtons = [...document.querySelectorAll(".btn")];

    adminButtons.forEach(item => {
        console.log('w');
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

    const editTemp = `
        <li className="mesWrapper" data-id="{$row[" id"]}">
            <div className="infRow">
                <div>
                    <h4 class="tlt"></h4>
                    <span class="us">
                        by <a href='/user?id={$row["idUser"]}' className='userLink'>"{$row["name"]}"</a>
                    </span>
                </div>
                <p class="tm"></p>
            </div>
            <hr>
                <div class="ms">
                    {$row["message"]}
                </div>
        </li>
        `;



    const edit = [...document.querySelectorAll(".")];
    edit.forEach(item => {

    }

});