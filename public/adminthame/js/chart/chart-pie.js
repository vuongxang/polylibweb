// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
let url_data = `${window.location.origin}/api/book-cate-data`;
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
          backgroundColor: ['#FF5900', '#FFD371', '#C2FFD9','#9DDAC6','#7C83FD','#96BAFF','#B2AB8C','#DBE6FD','#47597E','#293B5F','#DA7F8F','#F2BB7B'],
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


