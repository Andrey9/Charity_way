$(document).ready(function () { // вся магия после загрузки страницы
    $(document).on('click','a.go',function (event) { // ловим клик по ссылки с id="go"
        event.preventDefault(); // выключаем стандартную роль элемента
        $('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
            function () { // после выполнения предъидущей анимации
                $('#modal_form')
                    .css('display', 'block') // убираем у модального окна display: none;
                    .animate({opacity: 1, top: '30%'}, 200); // плавно прибавляем прозрачность одновременно со съезжанием вниз
            });
    });

    /* Закрытие модального окна, тут делаем то же самое но в обратном порядке */
    $(document).on('click','#modal_close, #overlay', function () { // ловим клик по крестику или подложке
        $('#modal_form')
            .animate({opacity: 0, top: '45%'}, 200,  // плавно меняем прозрачность на 0 и одновременно двигаем окно вверх
                function () { // после анимации
                    $(this).css('display', 'none'); // делаем ему display: none;
                    $('#overlay').fadeOut(400); // скрываем подложку
                }
            );
    });
});
/////////////////2papapab///////////////////
$(document).ready(function () { // вся магия после загрузки страницы
    $(document).on('click','a.go1',function (event) { // ловим клик по ссылки с id="go"
        event.preventDefault(); // выключаем стандартную роль элемента
        $('#overlay1').fadeIn(400, // сначала плавно показываем темную подложку
            function () { // после выполнения предъидущей анимации
                $('#modal_form1')
                    .css('display', 'block') // убираем у модального окна display: none;
                    .animate({opacity: 1, top: '30%'}, 200); // плавно прибавляем прозрачность одновременно со съезжанием вниз
            });
    });

    /* Закрытие модального окна, тут делаем то же самое но в обратном порядке */
    $(document).on('click','#modal_close1, #overlay1',function () { // ловим клик по крестику или подложке
        $('#modal_form1')
            .animate({opacity: 0, top: '45%'}, 200,  // плавно меняем прозрачность на 0 и одновременно двигаем окно вверх
                function () { // после анимации
                    $(this).css('display', 'none'); // делаем ему display: none;
                    $('#overlay1').fadeOut(400); // скрываем подложку
                }
            );
    });
});
//////////////////////////////
$(document).ready(function () {
    $(document).on('click','.number-min',function () {
        var $input = $(this).closest('.group-input').find('input[type="number"]');
        var $price = parseFloat($('.smal_price').children('p').children('i').html());
        var $sum = $('.order_sum_price');
        console.log($input);
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        $sum.html(parseFloat(Math.round($input.val() * $price * 100) / 100).toFixed(2));
        return false;
    });
    $(document).on('click', '.number-max',function () {
        var $input = $(this).closest('.group-input').find('input[type="number"]');
        var $price = parseFloat($('.smal_price').children('p').children('i').html());
        var $sum = $('.order_sum_price');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        $sum.html(parseFloat(Math.round($input.val() * $price * 100) / 100).toFixed(2));
        return false;
    });
});
