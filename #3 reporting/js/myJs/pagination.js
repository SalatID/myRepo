function pagination(page, totalPage){
  var page = page;
  var totalPage = totalPage;
  $('.currentPage').val(page);
  $('.endPage').text('of '+totalPage.totalPage);
  if (page == 1 && page >= totalPage.totalPage) {
    $('.start').addClass('disabled');
    $('.end').addClass('disabled');
  }else if (page == 1) {
    $('.start').addClass('disabled');
    $('.end').removeClass('disabled');
  }else if (page >= totalPage.totalPage) {
    $('.end').addClass('disabled');
    $('.start').removeClass('disabled');
  }else {
    $('.end').removeClass('disabled');
    $('.start').removeClass('disabled');
  }
}
