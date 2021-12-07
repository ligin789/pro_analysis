var ctx = document.getElementById("myChart").getContext('2d');
$.ajax({
    url: "./server/analysis.php",
    type: "POST",
    dataType: "json",
    data: {
        chartFetch: "chartFetch"
    },
    success: function(data, status) {
        console.log(data);
    },
    error: function (responseData, textStatus, errorThrown) {
        console.log(responseData, textStatus, errorThrown);
      }
});

var myChart = new Chart(ctx, {
    type: 'polarArea',
    data: {
        labels: [
            'Asia',
            'Europe',
            'Africa',
            'America',
            'Austrilla'
        ],
        datasets: [{
            label: 'My First Dataset',
            data: [11, 16, 7, 3, 14],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(75, 192, 192)',
                'rgb(255, 205, 86)',
                'rgb(201, 203, 207)',
                'rgb(54, 162, 235)'
            ]
        }]
    }
});

