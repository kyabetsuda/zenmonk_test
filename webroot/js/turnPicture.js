if($(window).height() > $(window).width()){
  $('img').removeAttr('style');
  $('.modalTitle').remove();
  $('.modalBody').css('transform', 'rotate(90deg)');
  $('img').css('max-width', $(window).height());

  iziToast.settings({
    iconUrl: '/icon_133010.svg',
    message: 'Please rotate the display',
    timeout: false,
    position: 'topCenter'
  });
  iziToast.show();
  $('.iziToast-texts').css({'height' : $(window).height() * 0.1, 'display' : 'flex', 'align-items' : 'center'});

}
