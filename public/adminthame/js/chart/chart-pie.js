// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
let url_data = 'api/book-cate-data';
fetch(url_data)
  .then(response => response.json())
  .then(data => {
    console.log(data);
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: data.label,
        datasets: [{
          data: data.data,
          backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc','#FF0000','#FFFF00','#00FFFF','#0000AA','#990000','#FFCC00','#CCCC33','#FF6600','#CC3300'],
          hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: false
        },
        cutoutPercentage: 80,
      },
    });
  })


