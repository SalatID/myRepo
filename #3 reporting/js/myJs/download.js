function download(typeOfReportingId,provinceId,cityId,minDate,maxDate,rows,offset,convertReporting,page=1){
  var param = {request : { 0 : {typeOfReportingId : typeOfReportingId,provinceId : provinceId, cityId : cityId, minDate : minDate, maxDate : maxDate, rows : rows, offset : offset, convertReporting : convertReporting}}};
  page = page;
  window.open('page/convert.php?'+'request='+JSON.stringify(param));
}
