
function asset(data){
    return baseUrl + '/' + data;
}
getDashboard = () => {
    $.ajax({
        type: "POST",
        dataType: 'json',
        data: {
            'time' : $('#date_picker1').val(),
            '_token' : _token,
        },
        url: baseUrl + '/' + 'driver/statistics-info/'+$('#___user_id').val(),
        success: function (data) {
            if (data) {
                $('#totalCar').text(data['total_car']);
                $('#totalDistance').text(data['total_distance']+' km');
                $('#totalAmount').text((data['amount']) + ' Tk');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}
getSummery = () => {
    fetch(baseUrl + '/' + 'dashboard/summery-info/'+$('#___user_id').val(), {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': _token
        }
    })
    .then(response => response.json())
    .then(data => {
       if (data['summary'].length > 0) {
        let content='';
        data['summary'].forEach(stats => {
            let img = '';
            if( parseInt(stats.agreement) > parseInt(stats.distance)){
                img = '<img src="'+asset('backend/img/dashboard/partially-success.svg')+'" alt="">';
            }else{
                img = '<img src="'+asset('backend/img/dashboard/success.svg')+'" alt="">';
            }
            stats.agreement > 0 ? content += `<tr class="dashboard-summery-tr">
                            <td class="title">${ stats.month }</td>
                            <td class="summary-distance-td">
                                <span>
                                    <img src="${ asset('backend/img/dashboard/target-achieved.svg') }"
                                        alt="">
                                    <span class="all-amount" id="totalAmount_1">
                                        ${ stats.distance } km
                                    </span>
                                </span>
                                <br>
                                <span>
                                    <img src="${ asset('backend/img/dashboard/target.svg') }"
                                        alt="">
                                    <span class="all-amount ps" id="totalAmount_1">
                                        ${ stats.agreement } km
                                    </span>
                                </span>
                            </td>
                            <td class="summary-action-td">
                                <span>
                                    ${ img }
                                </span>
                            </td>
                        </tr>`
                        : content += '';

        });
        $('#summaryTable').html(content);
       }
    }
    ).catch(error => {
        console.log(error);
    });
}

$('.admin_dashboard').length > 0 && getDashboard();

$('.admin_dashboard').length > 0 ? getSummery() : '';

  $('#date_picker1').datetimepicker({
    format: 'MM-y',
  }).on('dp.update', () => {
    getDashboard();
  })
  $('#date_picker1').on("click", function(e) {
     return false;
  })


// distance calculation graph by monthsStrictRegex


var ctx = document.getElementById("myChart").getContext('2d');

let config = {
    type: 'line',
    data: { },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animations: {
          tension: {
            duration: 1000,
            easing: 'linear',
            from: 1,
            to: 0,
            loop: true
          }
        },

      legend: {
          display: true
      },
    },
}


var myChart = new Chart(ctx, config);

distanceCalculationGraph = () => {
    $.ajax({
        type: "POST",
        dataType: 'json',
        data: {
            'time' : $('#date_picker').val(),
            '_token' : _token,
        },
        url: baseUrl + '/' + 'driver/distance-graph-info/'+$('#___user_id').val(),
        success: function (data) {
            if (data) {
                config.data = {
                    labels: data['label'],
                    datasets: [{
                        label: 'Distance',
                        data: data['data'],
                        backgroundColor: '#8e5ea2',
                        borderColor: '#8e5ea2',
                        borderWidth: 3,
                        fill: false,
                    }]
                }
                myChart.update();
              }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

$('#myChart').length > 0 && distanceCalculationGraph();


  $('#date_picker').datetimepicker({
    format: 'MM-y',
  }).on('dp.update', () => {
    distanceCalculationGraph();
  })
  $('#date_picker').on("click", function(e) {
     return false;
  })

