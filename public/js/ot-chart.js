(function ($) {
  
    "use strict";

// revenue chart
if($("#revenueChart").length){
    var revenueChartoptions = {
        series: [
            {
                name: "Earning",
                data: [
                    467, 559, 313, 782, 599, 567, 399, 399, 796,
                    899, 499,
                ],
            },
            {
                name: "Expense",
                data: [
                    378, 919, 452, 959, 235, 523, 524, 511, 789,
                    349, 789,
                ],
            },
        ],
    
        colors: ["#6CD6FD", "#DEF6FF"],
        chart: {
            type: "bar",
            height: 350,
            toolbar: {
                show: false,
            },
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "55%",
                endingShape: "rounded",
            },
        },
    
        legend: {
            itemMargin: {
                horizontal: 5,
                vertical: 5,
            },
            horizontalAlign: "center",
            verticalAlign: "center",
            position: "bottom",
            fontSize: "14px",
            fontWight: "bold",
            markers: {
                radius: 5,
                height: 14,
                width: 14,
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            show: true,
            width: 2,
            colors: ["transparent"],
        },
        xaxis: {
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "June",
                "July",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
            ],
        },
        yaxis: {
            title: {
                show: false,
            },
            labels: {
                formatter: function (value) {
                    var val = Math.abs(value);
                    if (val >= 1000) {
                        val = (val / 1000).toFixed(0) + "K";
                    }
                    return val;
                },
            },
        },
        fill: {
            opacity: 1,
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + "K";
                },
            },
        },
    };
    
    var revenueChart = new ApexCharts(
        document.querySelector("#revenueChart"),
        revenueChartoptions
    );
    revenueChart.render();
}




let otPieChart1 = {
    series: [623, 314, 239],
    chart: {
        id: "ot-pie-chart-alpha",
        fontFamily: "Lexend, sans-serif",
        type: "donut",
        height: 360,
        toolbar: {
            show: false,
        },
        zoom: {
            enabled: false,
        },
    },

    colors: ["#00F7BF", "#6BCCFD", "#9AFFFF"],
    labels: ["Check In", "Check Out", "Absence"],
    dataLabels: {
        enabled: false,
    },
    plotOptions: {
        pie: {
            donut: {
                size: "65%",
                labels: {
                    show: true,
                    name: {
                        fontSize: "30px",
                        offsetY: 0,
                        color: "#636E72",
                    },
                    value: {
                        fontSize: "30px",
                        width: 700,
                        offsetY: 20,

                        formatter(val) {
                            return `${val}`;
                        },
                    },
                    total: {
                        show: true,
                        fontSize: "18px",
                        color: "#636E72",
                        label: "Total",

                        formatter: function (w) {
                            return "2400";
                        },
                    },
                },
            },
        },
    },

    legend: {
        itemMargin: {
            horizontal: 5,
            vertical: 5,
        },
        horizontalAlign: "center",
        verticalAlign: "center",
        position: "top",
        fontSize: "16px",
        fontWight: "bold",
        markers: {
            radius: 3,
            height: 15,
            width: 15,
        },
    },

    responsive: [
        {
            breakpoint: 325,
            options: {
                legend: {
                    itemMargin: {
                        horizontal: 4,
                        vertical: 0,
                    },
                    horizontalAlign: "center",
                    position: "bottom",
                    fontSize: "14px",
                },
            },
        },
    ],
};

if (document.querySelector("#ot-pie-chart-alpha")) {
    let chart = new ApexCharts(
        document.querySelector("#ot-pie-chart-alpha"),
        otPieChart1
    );
    chart.render();
}

// // ot-line-chart-alpha

let options = {
    series: [
        {
            name: "Earning",
            data: [10, 41, 35, 51, 49, 62, 69, 91, 148],
        },
    ],
    chart: {
        height: 125,
        type: "line",
        zoom: {
            enabled: false,
        },

        toolbar: {
            show: false,
        },
    },

    dataLabels: {
        enabled: false,
    },

    stroke: {
        curve: "straight",
        colors: "#fa5c7c",
        lineCap: "butt",
        width: 2,
    },

    title: {
        show: false,
    },

    markers: {
        shape: "circle",
    },

    grid: {
        show: true, // you can either change hear to disable all grids
        xaxis: {
            lines: {
                dashArray: 4,
                show: true, //or just here to disable only x axis grids
            },
        },
        yaxis: {
            lines: {
                show: false, //or just here to disable only y axis
            },
        },
    },

    yaxis: {
        show: false,
        labels: {
            show: false,
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false,
        },
    },

    xaxis: {
        show: false,
        labels: {
            show: false,
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false,
        },
    },
};
if($("#ot-line-chart-alpha").length){
    const lineChartAlpha = new ApexCharts(
        document.querySelector("#ot-line-chart-alpha"),
        {
            ...options,
            stroke: {
                colors: "#5669ff",
                curve: "straight",
                width: 2,
            },
        }
    );
    lineChartAlpha.render();
}



if($("#ot-line-chart-beta").length){
    const lineChartBeta = new ApexCharts(
        document.querySelector("#ot-line-chart-beta"),
        {
            ...options,
            stroke: {
                colors: "#00F7BF",
                curve: "straight",
                width: 2,
            },
        }
    );
    lineChartBeta.render();
}


if($("#ot-line-chart-gama").length){
    const lineChartGama = new ApexCharts(
        document.querySelector("#ot-line-chart-gama"),
        {
            ...options,
            stroke: {
                colors: "#FF991A",
                curve: "straight",
                width: 2,
            },
        }
    );
    
    lineChartGama.render();
}


let optionsAnalyticsVisit = {
    series: [35, 25, 45],
    chart: {
        id: "visited_customer_chart",
        type: "donut",
        height: 320,
        toolbar: {
            show: false,
        },
        zoom: {
            enabled: false,
        },
    },
    colors: ["#6CD6FD", "#9597FF", "#00F7BF"],

    labels: ["Desktop Users", "Tablet User", "Mobile User"],

    dataLabels: {
        enabled: false,
    },
    plotOptions: {
        pie: {
            donut: {
                size: "75%",
                labels: {
                    show: true,
                    name: {
                        fontSize: "12px",
                        offsetY: 0,
                    },
                    value: {
                        fontSize: "12px",
                        offsetY: 0,
                        formatter(val) {
                            return `% ${val}`;
                        },
                    },
                    total: {
                        show: true,
                        fontSize: "16px",
                        label: "Total",

                        formatter: function (w) {
                            return "2400";
                        },
                    },
                },
            },
        },
    },

    legend: {
        itemMargin: {
            horizontal: 0,
            vertical: 10,
        },
        horizontalAlign: "center",
        verticalAlign: "center",
        position: "right",
        fontFamily: "Lexend",
        fontSize: "15px",
        fontWight: "500",
        markers: {
            radius: 5,
            height: 14,
            width: 14,
        },
    },

    responsive: [
        {
            breakpoint: 1400,
            options: {
                legend: {
                    itemMargin: {
                        horizontal: 5,
                        vertical: 5,
                    },
                    horizontalAlign: "center",
                    verticalAlign: "center",
                    position: "bottom",
                    fontFamily: "Lexend",
                    fontSize: "15px",
                    fontWight: "500",
                    markers: {
                        radius: 5,
                        height: 14,
                        width: 14,
                    },
                },
            },
            breakpoint: 420,
            options: {
                legend: {
                    itemMargin: {
                        horizontal: 5,
                        vertical: 5,
                    },
                    horizontalAlign: "center",
                    verticalAlign: "center",
                    position: "bottom",
                    fontFamily: "Lexend",
                    fontSize: "12px",
                    fontWight: "500",
                    markers: {
                        radius: 5,
                        height: 14,
                        width: 14,
                    },
                },
            },
        },
    ],
};

if($("#visited_customer_chart").length){
    if (document.querySelector("#visited_customer_chart")) {
        let chart = new ApexCharts(
            document.querySelector("#visited_customer_chart"),
            optionsAnalyticsVisit
        );
        chart.render();
    }
}

})(jQuery);
// // group chart label