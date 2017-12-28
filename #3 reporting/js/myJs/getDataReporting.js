function getDataReporting(typeOfReportingId,provinceId,cityId,minDate,maxDate,rows,offset,convertReporting,page=1){
  var param = {request : {
                  typeOfReportingId : typeOfReportingId,
                  filter : {
                    minDate : minDate,
                    maxDate : maxDate
                  },
                  limit:{
                    rows : rows,
                    offset : offset,
                  },
                  properties : convertReporting}};
  //alert(JSON.stringify(param));
  page = page;
  $.ajax({
    type	: 'POST',
    async : false,
    url 	: 'page/getDataReporting.php',
    contentType: "application/json; charset=utf-8",
    data 	: JSON.stringify({param}),
    dataType : 'json',
    success	: function(result){
      var tableField = $('.tableContent');
      var tHeader = $('.tHeader');
      var tContent = $('.tContent');
      if (result.response.error == 0) {
        if (convertReporting.typeReporting == 'chart') {
          $('.chartCanvas').hide();
          if (typeOfReportingId==1){
            convertReportingToChart(result);
          }else if (typeOfReportingId==2) {
            convertClickToChart(result);
          }
        }else if (typeOfReportingId==1) {
          $(".tableField").remove();
          $.each(result.response.data, function(e) {
            html='<tr class="tableField">'
             + '<td style="text-align : center">'+((e+1)+(offset-1)*rows)+'</td>'
             + '<td style="text-align : center">'+this.contractId+'</td>'
             + '<td style="text-align : center">'+this.paymentDate+'</td>'
             + '<td style="text-align : center">'+this.totalPayment+' '+this.curencyCode+'</td>'
             + '</tr>';
            tContent.append(html);
            //tableField.append('<td>'+this.contractId+'</td></tr>');
          });
        }else if (typeOfReportingId==2) {
          $(".tableField").remove();
          $.each(result.response.data, function(e) {
            html='<tr class="tableField">'
             + '<td style="text-align : center">'+((e+1)+(offset-1)*rows)+'</td>'
             + '<td style="text-align : center">'+this.adsId+'</td>'
             + '<td style="text-align : center">'+this.date+'</td>'
             + '<td style="text-align : center">'+this.totalClick+'</td>'
             + '</tr>';
            tContent.append(html);
            //tableField.append('<td>'+this.contractId+'</td></tr>');
          });
        }
        $('.tipeOfReporting').text(': '+result.response.docAttribute.typeOfReporting);
        $('.startDate').text(': '+result.response.docAttribute.startDate);
        $('.endDate').text(': '+result.response.docAttribute.endDate);
        $('.title').text(result.response.docAttribute.title);
        html='<tr class="tableField">'
         + '<th class="headerTable">'+result.response.tableHeader.col1+'</th>'
         + '<th class="headerTable" >'+result.response.tableHeader.col2+'</th>'
         + '<th class="headerTable">'+result.response.tableHeader.col3+'</th>'
         + '<th class="headerTable">'+result.response.tableHeader.col4+'</th>'
         + '</tr>';
         tHeader.append(html);
        $('.reporting').show();
        $('.filterRow').show();
        $('.grubPagination').show();
        $('.showData').show();
        $('.content').show();
        $('.aPageNumber').remove();
        var totalRow = result.response.totalRow;
        totalPage = {totalPage : Math.ceil(totalRow/rows)};
        //alert('totalPage'+JSON.stringify(totalPage));
        //var offset = 0;
        pagination(page, totalPage);
        $('.labelGenDate').text('Generate Date : '+result.response.docAttribute.generateDate);
        $('.labelPageNumb').text(page+' of '+totalPage.totalPage);
        $('.alert-danger').hide();
      }else {
        $('.alert-danger').show();
        html = '<div class="errorAlert"><h3 >error code : <b>'+result.response.error+'</b></h3><strong>'+result.response.detail.message+'</strong></br>'
        +result.response.detail.debuging+'</div>';
        $('.errorAlert').remove();
        $('.alert-danger').append(html);
        $('.showData').hide();
      }
    }
  });
}
