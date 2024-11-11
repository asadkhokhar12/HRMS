"use strict";


// load dashboard
var dashboardAdmin =  (e ) => {
    
} 

$(function () {
    let user_slug = $("#user_slug").val();
    if (user_slug == "superadmin") {
        loadDashboard("My Dashboard");
    } else if (user_slug == "admin") {
        loadDashboard("Company Dashboard");
    } else {
        loadDashboard("My Dashboard");
    }
});


// const expenseChart = ( data ) => {
//         var options = {
//             series: [],
//             chart: {
//                 height: 450,
//                 type: 'line',
//                 zoom: {
//                     enabled: true
//                 },
//         },
//         responsive: [{
//             breakpoint: 480,
//             options: {
//                 chart: {
//                     width: '100%',
//                 },
//                 legend: {
//                     position: 'bottom'
//                 },
                

//             }
//         }],
//         animations:{
//             enabled: true,
//             easing: 'easeinout',
//             speed: 800,
//             animateGradually: {
//                 enabled: true,
//                 delay: 0.2
//             },
//             dynamicAnimation: {
//                 enabled: true,
//                 speed: 350
//             },

//         },
//         dataLabels: {
//             enabled: false
//         },
//         stroke: {
//             width: [5, 5, 5],
//             curve: 'straight',
//             dashArray: [0, 0, 0],
//         },
//         legend: {
//             tooltipHoverFormatter: function(val, opts) {
//             return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
//             }
//         },
//         markers: {
//             size: 0,
//             hover: {
//                 sizeOffset: 6
//             }
//         },
//         grid: {
//             borderColor: '#f1f1f1',
//         }
//         };

//         data.categories.forEach(element => {
//             options.series.push({
//                 name: element,
//                 data: data.expenses[element]

//             });
//         });
//         options.xaxis = {
//             categories: data.thisMonthArray,
//             tickPlacement: 'on',
//         };
//         var chart = new ApexCharts(document.querySelector("#lineChart"),options);
//         chart.render();


// }
// function drawPieChart(series, labels) {
//     let optionsforPieChart = {
//         series: series,
//         chart: {
//             width: '100%',
//             type: 'donut',
//             animations: {
//                 enabled: true,
//                 easing: 'easeinout',
//                 speed: 800,
//                 animateGradually: {
//                     enabled: true,
//                     delay: 0.2
//                 },
//                 dynamicAnimation: {
//                     enabled: true,
//                     speed: 350
//                 }
//             }

//         },
//         labels: labels,
//         legend: {
//             position: 'bottom',
//         }
//     };
//     let chartPieChart = new ApexCharts(document.querySelector("#employeeActivityChart2"), optionsforPieChart);
//     chartPieChart.render();
// }

function loadDashboard(e) {
    $("#__selected_dashboard").html(e);
    let dashboardType = e;
    console.log(e);
    let url = $("#profileWiseDashboard").val();
    let userID = $("#userID").val();
    // ajax
    $.ajax({
        url: url,
        type: "POST",
        data: {
            userID: userID,
            dashboardType: dashboardType,
        },
        success: function (data) {
            if (data.status == "success") {
                $("#__MyProfileDashboardView").html(data.dashboard);
                if(data?.expense?.original?.data) {
                    expenseChart(data.expense.original.data);
                }else{
                    $("#lineChart").html("");
                }
                if (data?.attendance_summary) {
                    let series = [];
                    let labels = [];
                    for (let key in data.attendance_summary) {
                        if(data.attendance_summary.total_employee ){
                            data.attendance_summary.absent = data.attendance_summary.total_employee - data.attendance_summary.present;
                            delete data.attendance_summary.total_employee;
                        }
                        series.push(data.attendance_summary[key]);
                        labels.push(key);
                    }
                    drawPieChart(series, labels);
                }else{
                    $("#employeeActivityChart2").html("");
                }
            }
        },
    });
    //add active class
    $(".profile_option").addClass("active");
    $(".company_option").removeClass("active");
    $("#profile_statistic").show();
    $("#company_statistic").hide();
}

// function showCompanyData() {
//     $("#profile_statistic").hide();
//     $("#company_statistic").show();
//     $(".company_option").addClass("active");
//     $(".profile_option").removeClass("active");
// }
