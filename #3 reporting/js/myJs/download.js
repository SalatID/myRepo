function download(globalFilter,rows,offset,properties,globalOrder,page=1){
  var param = {request : {
                  properties : properties,
                  filter : globalFilter,
                  limit : {rows : rows, offset : offset},
                  order : globalOrder
              }
            };
  page = page;
  window.open('page/convert.php?'+'request='+JSON.stringify(param));
}
