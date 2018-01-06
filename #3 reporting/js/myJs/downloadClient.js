function downloadExcel(printingOption){
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#divTableContent').html()));
}
function downloadPdf(typeOfReportingId,result,offset,rows){
  var header = [];
  $.each(result.response.tableHeader, function(e){
    header [e]={text: this.col, style: 'tableHeader', bold: true, alignment: 'center', fillColor:'#7AD7FF', height : '10px'};
  });
  var label = [];
  for (var i = 0; i < result.response.data.length; i++) {
    if (typeOfReportingId==1) {
      $.each(result.response.data, function(e){
        label [e]=[{text : ((e+1)+(offset-1)*rows), alignment: 'center'},
                  {text : this.contractId, alignment: 'center'},
                  {text: this.paymentDate, alignment: 'center'},
                  {text: this.totalPayment+' '+this.curencyCode, alignment: 'center'}];
      });
    }else if (typeOfReportingId==2) {
      $.each(result.response.data, function(e){
        label [e]=[{text : ((e+1)+(offset-1)*rows), alignment: 'center'},
                  {text : this.adsId, alignment: 'center'},
                  {text: this.date, alignment: 'center'},
                  {text: this.totalClick, alignment: 'center'}];
      });
    }
  }
  label.unshift(header);
   var docDefinition = { footer:
                        function(currentPage, pageCount) {
                          return {table: {
                            widths: ['*','auto'],
                            body: [
                              [{ text: 'Generate Date : '+result.response.docAttribute.generateDate,
                              bold : true}, currentPage.toString() + ' of ' + pageCount]
                            ],
                          },
                          layout: 'noBorders',
                          margin: [10, 0]
                          }
                        },
                        content: [
                          {text: result.response.docAttribute.title, fontSize: 20, bold: true, alignment: 'center'},
                          {
                      			image: 'logo.jpg',
                      			width: 50,
                            alignment : 'right'
                      		},
                          {
                      			style: 'tableExample',
                      			table: {
                      				body: [
                      					[{text: 'Type Of Reporting ', bold: true, fillColor:'#E6E6E6'}, ': '+result.response.docAttribute.typeOfReporting],
                      					[{text: 'Start Date', bold: true, fillColor:'#E6E6E6'}, ': '+result.response.docAttribute.startDate],
                                [{text: 'End Date', bold: true, fillColor:'#E6E6E6'}, ': '+result.response.docAttribute.endDate],
                                [' ', ' ']
                      				]
                      			},
                            layout: 'noBorders'
                      		},
                          {
                      			style: 'tableExample',
                      			table: {
                              widths: [20, 100, '*', 100],
                      				body: label
                      			}
                      		},
   ] };
    pdfMake.createPdf(docDefinition).download();
}
function downloadClient(globalFilter,rows,offset,globalProperties,page=1,printingOption,globalOrder,name){
  var param = {request : {
                  filter : globalFilter,
                  limit:{
                    rows : rows,
                    offset : offset
                  },
                  order : globalOrder,
                  properties : globalProperties}};
  $.ajax({
    type	: 'POST',
    async : false,
    url 	: 'page/getDataReporting.php',
    contentType: "application/json; charset=utf-8",
    data 	: JSON.stringify({param}),
    dataType : 'json',
    success	: function(result){
        //alert(JSON.stringify(result));
        //console.log(result)
        var tHeaderHidden = $('.tHeaderHidden');
        var tContentHidden = $('.tContentHidden');
        title = result.response.title;
        if (globalProperties.typeOfReportingId==1) {
          $(".tableFieldHidden").remove();
          html='<tr class="tableFieldHidden">'
           + '<th style="text-align: center;height: 35px;background-color: #7AD7FF;">NO</th>'
           + '<th style="text-align: center;height: 35px;background-color: #7AD7FF;">Contract Id</th>'
           + '<th style="text-align: center;height: 35px;background-color: #7AD7FF;">Payment Date</th>'
           + '<th style="text-align: center;height: 35px;background-color: #7AD7FF;">Total Payment</th>'
           + '</tr>';
           tHeaderHidden.append(html);
          $.each(result.response.data, function(e) {
            html='<tr class="tableFieldHidden">'
             + '<td style="text-align: center">'+((e+1)+(offset-1)*rows)+'</td>'
             + '<td style="text-align: center">'+this.contractId+'</td>'
             + '<td style="text-align: center">'+this.paymentDate+'</td>'
             + '<td style="text-align: center">'+this.totalPayment+' '+this.curencyCode+'</td>'
             + '</tr>';
            tContentHidden.append(html);
            //tableField.append('<td>'+this.contractId+'</td></tr>');
          });

        }else if (globalProperties.typeOfReportingId==2) {
          $(".tableFieldHidden").remove();
          html='<tr class="tableField">'
           + '<th style="text-align: center;height: 35px;background-color: #7AD7FF;">NO</th>'
           + '<th style="text-align: center;height: 35px;background-color: #7AD7FF;">Ads Id</th>'
           + '<th style="text-align: center;height: 35px;background-color: #7AD7FF;">Date</th>'
           + '<th style="text-align: center;height: 35px;background-color: #7AD7FF;">Total Click </th>'
           + '</tr>';
           tHeaderHidden.append(html);
          $.each(result.response.data, function(e) {
            html='<tr class="tableField">'
             + '<td style="text-align: center">'+((e+1)+(offset-1)*rows)+'</td>'
             + '<td style="text-align: center">'+this.adsId+'</td>'
             + '<td style="text-align: center">'+this.date+'</td>'
             + '<td style="text-align: center">'+this.totalClick+'</td>'
             + '</tr>';
            tContentHidden.append(html);
            //tableField.append('<td>'+this.contractId+'</td></tr>');
          });
        }
        $('.labelGenDateHidden').text(' : '+result.response.docAttribute.generateDate);
        if (name == 'PDF') {
          downloadPdf(globalProperties.typeOfReportingId,result,offset,rows);
        }else {
          downloadExcel (printingOption);
        }
      }
  });
}
