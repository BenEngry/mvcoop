window.addEventListener('DOMContentLoaded', (event) => {

    const btn = document.querySelector(".sendd");

    btn.addEventListener("click", e => {
        e.preventDefault();
        const oppor = $("#oppor").val();
        const action = $("#type").val();
        const idBox = $("input[type='checkbox']:checked").val();
        const data = {
            oppor : oppor,
            action : action,
            id : idBox
        };

        $.ajax({
            url: "http://nmvc.site/opportunity",
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

});