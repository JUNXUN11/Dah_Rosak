// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: buildingLabels,
    datasets: [{
      data: buildingData,
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc','#5a5cdd','#17a589','#33b1c7','#7a81e0','#2ed573','#74b9ff','#e17055','#fdcb6e'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf','#4a4cb3','#138f73','#2d99af','#6366b0',	'#25a45a','#5c95cc','	#b55a44','#cc9c57'],
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
