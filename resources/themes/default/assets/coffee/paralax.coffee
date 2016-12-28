$(window).scroll ->
  st = $(this).scrollTop()
  $('.dum').css 'transform': 'translate(0%, ' + st * 1.5 + '%'
  $('.star').css 'transform': 'translate(0%, ' + st / 2 + '%'
  $('.nipple').css 'transform': 'translate(0%, ' + st / 6 + '%'
  $('.heart').css 'transform': 'translate(0%, ' + st / 4 + '%'
  $('.star2').css 'transform': 'translate(0%, -' + st / 2 + '%'
  $('.candy').css 'transform': 'translate(0%, -' + st / 2 + '%'
  return