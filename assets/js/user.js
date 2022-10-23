window.addEventListener('DOMContentLoaded', (event) => {

    let myChart;
    throwGraphAJAX();

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

    function throwGraphAJAX() {
        const id = document.querySelector(".chartBtnWrapper").dataset.id;
        const type = "week";
        const dataJ = {
            id : id,
            type : type
        };

        $.ajax({
            url: "http://nmvc.site/user",
            method: "POST",
            data : dataJ,
            dataType : "json",
            success : function (data) {
                if(data.status) {
                    createGraph(data['labels'] ,data['dataArr']);
                }
            }
        })
    }

    function createGraph(labels, dataArr) {

        if(myChart!=null){
            myChart.destroy();
        }

        const dataGraph = {
            labels: labels,
            datasets: [{
                label: 'Activity',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: dataArr,
            }]
        };

        const config = {
            type: 'line',
            data: dataGraph,
            options: {
                scales: {
                    // yAxes: [
                    //     {
                    //         ticks: {
                    //             min: 0,
                    //             max: 1440
                    //         }
                    //     }
                    // ]
                }
            }
        };

        myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
        return true
    }

    const graphButtons = [...document.querySelectorAll(".chartBtn")];

    graphButtons.forEach(item => {

        item.addEventListener("click", e => {
            e.preventDefault();
            const id = document.querySelector(".chartBtnWrapper").dataset.id;
            const type = item.dataset.type;
            const dataJ = {
                id : id,
                type : type
            };

            $.ajax({
                url: "http://nmvc.site/user",
                method: "POST",
                data : dataJ,
                dataType : "json",
                success : function (data) {
                    if(data.status) {
                        // resetCanvas();
                        createGraph(data['labels'] ,data['dataArr']);
                    }
                }
            })
        })
    })
});

