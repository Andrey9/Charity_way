#show more
$('.show_more').on 'click', ->
  _offset = $.find('.wrapper_tovar').length
  $.ajax(
    type: 'get'
    url: 'show_more'
    data: offset: _offset).done (response) ->
      console.log response
      $('.wrapper_tovar:last').after response
      return
  return
#
#load about modal window
$(document).on 'click', '.btn_about_tovar', ->
  _id = $(this).data('id')
  $.ajax(
    type: 'get'
    url: 'about_product'
    data: id: _id).done (response) ->
      $('#modal_form1').html response
      return
  return
#
#load order modal window
$(document).on 'click', '.btn_hover_tovar', ->
  _id = $(this).data('id')
  $.ajax(
    type: 'get'
    url: 'order_product'
    data: id: _id).done (response) ->
      $('#modal_form').html response
      return
  return
#
#order form submit
$(document).on 'submit', '#order-product', (event) ->
  event.preventDefault()
  formData = $(this).serialize()
  formMethod = $(this).attr('method')
  formUrl = $(this).attr('action')
  $.ajax(
    type: formMethod
    url: formUrl
    data: formData).done (response) ->
      console.log response
      $('#modal_form').html response
      return
  return
#
$(document).on 'click', '.oplata1', ->
# ловим клик по крестику или подложке
  $('#modal_form1').animate {
    opacity: 0
    top: '45%'
  }, 200, ->
# после анимации
    $(this).css 'display', 'none'
    # делаем ему display: none;
    $('#overlay1').fadeOut 400
    # скрываем подложку
    return
  _id = $(this).data('id')
  $.ajax(
    type: 'get'
    url: 'order_product'
    data: id: _id).done (response) ->
      $('#modal_form').html response
      return
  $('#overlay').fadeIn 400, ->
# после выполнения предъидущей анимации
    $('#modal_form').css('display', 'block').animate {
      opacity: 1
      top: '30%'
    }, 200
    # плавно прибавляем прозрачность одновременно со съезжанием вниз
    return
  return
$('#feedback-form').on 'submit', (event) ->
  event.preventDefault()
  formData = $(this).serialize()
  formMethod = $(this).attr('method')
  formUrl = $(this).attr('action')
  console.log formData
  $.ajax(
    type: formMethod
    url: formUrl
    data: formData
    dataType: 'json').done (response) ->
      html = '<span id="modal_close"><img src="assets/themes/default/img/close.png"></span>'
      html += '<h3 class="zakaz">' + response['message'] + '</h3>'
      html += '<style>.zakaz{margin-top: 200px;}</style>'
      $('#modal_form').html html
      $('#overlay').fadeIn 400, ->
# после выполнения предъидущей анимации
        $('#modal_form').css('display', 'block').animate {
          opacity: 1
          top: '30%'
        }, 200
        # плавно прибавляем прозрачность одновременно со съезжанием вниз
        return
      $('#feed_name').val ''
      $('#phone').val ''
      $('#feed_text').val ''
      return
  return