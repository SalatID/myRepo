function getDataReporting(filter,rows,offset,properties,orders,totalPage=null,page=1){
  var param = {request : {
                  filter : filter,
                  limit:{
                    rows : rows,
                    offset : offset
                  },
                  order : orders,
                  properties : properties}};
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
        if (properties.typeReporting == 'chart') {
          $(".tableField").remove();
          if (properties.typeOfReportingId==1){
            convertReportingToChart(result,totalPage);
          }else if (properties.typeOfReportingId==2) {
            convertClickToChart(result,totalPage);
          }
        }else if (properties.typeOfReportingId==1) {
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
        }else if (properties.typeOfReportingId==2) {
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
        var icon = result.response.order.type == 'ASC' ? 'fa fa-sort-asc' : 'fa fa-sort-desc';
          var th = '';
          $.each(result.response.tableHeader, function(e) {
           if (result.response.order.fieldName == 'id' || result.response.order.fieldName !== this.fieldName) {
             th += '<th class="headerTable" data-id="'+this.fieldName+'" order="ASC">'+this.col+'</th>';
           }else if (result.response.order.fieldName == this.fieldName) {
             th += '<th class="headerTable" data-id="'+this.fieldName+'" order="ASC">'+this.col+'<i class="icons '+icon+'" aria-hidden="true"></i></th>';
           }
         })
         html='<tr class="tableField">'+th+'</tr>';
         tHeader.append(html);
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
          getDataReporting(filter,rows,offset,properties,orders,page);
        });
        var totalRow = result.response.totalRow;
        totalPages = {totalPage : Math.ceil(totalRow/rows)};
        order = result.response.order;
        //alert('totalPage'+JSON.stringify(totalPage));
        //var offset = 0;
        pagination(page, totalPages);
        $('.labelGenDate').text('Generate Date : '+result.response.docAttribute.generateDate);
        $('.labelPageNumb').text(page+' of '+totalPages.totalPage);
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
