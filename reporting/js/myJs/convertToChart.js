function convertReportingToChart(result){
  $('.chartjs-hidden-iframe').remove();
  $('#canvasClick').hide();
  $('#canvasTrx').show();
  var label = new Array;
  var data = new Array;
  var backgroundColor = new Array;
  var borderColor = new Array;
  $.each(result.response.data, function(e){ label [e]=this.paymentDate});
  $.each(result.response.data, function(e){ data [e]=this.totalPayment});
  for (var i = 0; i < result.response.totalRow; i++) {
    backgroundColor [i]='rgba(255, 99, 132, 0.2)';
    i++;
    backgroundColor [i]='rgba(54, 162, 235, 0.2)';
    i++;
    backgroundColor [i]='rgba(255, 206, 86, 0.2)';
    i++;
    backgroundColor [i]='rgba(75, 192, 192, 0.2)';
    i++;
    backgroundColor [i]='rgba(153, 102, 255, 0.2)';
    i++;
    backgroundColor [i]='rgba(255, 159, 64, 0.2)';
  }
  for (var i = 0; i < result.response.totalRow; i++) {
    borderColor [i]='rgba(255,99,132,1)';
    i++;
    borderColor [i]='rgba(54, 162, 235, 1)';
    i++;
    borderColor [i]='rgba(255, 206, 86, 1)';
    i++;
    borderColor [i]='rgba(75, 192, 192, 1)';
    i++;
    borderColor [i]='rgba(153, 102, 255, 1)';
    i++;
    borderColor [i]='rgba(255, 159, 64, 1)';
  }
  var ctx = document.getElementById("canvasTrx");
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: label,
          datasets: [{
                  label: '# of Votes',
                  data: data,
                  backgroundColor: backgroundColor,
                  borderColor: borderColor,
                  borderWidth: 1
              }]
      },
      options: {
          scales: {
              yAxes: [{
                      ticks: {
                          beginAtZero: true
                      }
                  }]
          }
      }
  });
  $('.chartCanvas').show();
  pagination(page, totalPage);
}
function convertClickToChart(result){
  $('#canvasTrx').hide();
  $('#canvasClick').show();
  var label = new Array;
  var data = new Array;
  $.each(result.response.data, function(e){ label [e]=this.date});
  $.each(result.response.data, function(e){ data [e]=this.totalClick});
  var ctx = document.getElementById("canvasClick");
  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: label,
          datasets: [{
                  label: '# of Votes',
                  data: data,
                  pointBackgroundColor: 'rgba(255,0,4,1)',
                  borderWidth: 1
              }]
      },
      options: {
          scales: {
              yAxes: [{
                      ticks: {
                          beginAtZero: true
                      }
                  }]
          }
      }
  });
  $('.chartCanvas').show();
  pagination(page, totalPage);
}
