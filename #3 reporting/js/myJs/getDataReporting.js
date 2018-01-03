function getDataReporting(typeOfReportingId,provinceId,cityId,minDate,maxDate,rows,offset,convertReporting,orders,page=1){
  var param = {request : {
                  typeOfReportingId : typeOfReportingId,
                  filter : {
                    minDate : minDate,
                    maxDate : maxDate
                  },
                  limit:{
                    rows : rows,
                    offset : offset
                  },
                  order : orders,
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
        //var sortIcon = result.response.order.type=='ASC' ? 'fa fa-sort-asc' : 'fa fa-sort-desc';
          var th = '';
          $.each(result.response.tableHeader, function(e) {
           if (result.response.order.fieldName == 'id' || result.response.order.fieldName !== this.fieldName) {
             th += '<th class="headerTable" data-id="'+this.fieldName+'" order="ASC">'+this.col+'</th>';
           }else if (result.response.order.fieldName == this.fieldName) {
             th += '<th class="headerTable" data-id="'+this.fieldName+'" order="ASC">'+this.col+'<i class="icons '+result.response.order.icon+'" aria-hidden="true"></i></th>';
           }
         })
         html='<tr class="tableField">'+th+'</tr>';
         tHeader.append(html);
         order = result.response.order;
        $('.reporting').show();
        $('.filterRow').show();
        $('.grubPagination').show();
        $('.showData').show();
        $('.content').show();
        $('.aPageNumber').remove();
        //alert('bawah'+JSON.stringify(orders));
        $('.headerTable').click(function(){
          var fieldName = $(this).data('id');
          if (result.response.order.type=='ASC') {
            var orders = {fieldName : fieldName, type : 'DESC'};
          }else {
            var orders = {fieldName : fieldName, type : 'ASC'};
          }
          //var orders = {fieldName : fieldName, type : 'ASC'};
          getDataReporting(typeOfReportingId,provinceId,cityId,minDate,maxDate,rows,offset,convertReporting,orders,page);
        });
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
