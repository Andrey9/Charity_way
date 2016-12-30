$(document).ready ->
# вся магия после загрузки страницы
  $(document).on 'click', 'a.go', (event) ->
# ловим клик по ссылки с id="go"
    event.preventDefault()
    # выключаем стандартную роль элемента
    $('#overlay').fadeIn 400, ->
# после выполнения предъидущей анимации
      $('#modal_form').css('display', 'block').animate {
        opacity: 1
        top: '30%'
      }, 200
      # плавно прибавляем прозрачность одновременно со съезжанием вниз
      return
    return

  ### Закрытие модального окна, тут делаем то же самое но в обратном порядке ###

  $(document).on 'click', '#modal_close, #overlay', ->
# ловим клик по крестику или подложке
    $('#modal_form').animate {
      opacity: 0
      top: '45%'
    }, 200, ->
# после анимации
      $(this).css 'display', 'none'
      # делаем ему display: none;
      $('#overlay').fadeOut 400
      # скрываем подложку
      return
    return
  return
#///////////////2papapab///////////////////
$(document).ready ->
# вся магия после загрузки страницы
  $(document).on 'click', 'a.go1', (event) ->
# ловим клик по ссылки с id="go"
    event.preventDefault()
    # выключаем стандартную роль элемента
    $('#overlay1').fadeIn 400, ->
# после выполнения предъидущей анимации
      $('#modal_form1').css('display', 'block').animate {
        opacity: 1
        top: '30%'
      }, 200
      # плавно прибавляем прозрачность одновременно со съезжанием вниз
      return
    return

  ### Закрытие модального окна, тут делаем то же самое но в обратном порядке ###

  $(document).on 'click', '#modal_close1, #overlay1', ->
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
    return
  return
#////////////////////////////
$(document).ready ->
  $(document).on 'click', '.number-min', ->
    $input = $(this).closest('.group-input').find('input[type="number"]')
    $price = parseFloat($('.smal_price').children('p').children('i').html())
    $sum = $('.order_sum_price')
    console.log $input
    count = parseInt($input.val()) - 1
    count = if count < 1 then 1 else count
    $input.val count
    $input.change()
    $sum.html $input.val() * $price
    false
  $(document).on 'click', '.number-max', ->
    $input = $(this).closest('.group-input').find('input[type="number"]')
    $price = parseFloat($('.smal_price').children('p').children('i').html())
    $sum = $('.order_sum_price')
    $input.val parseInt($input.val()) + 1
    $input.change()
    $sum.html parseFloat(Math.round($input.val() * $price * 100) / 100).toFixed(2)
    false
  return