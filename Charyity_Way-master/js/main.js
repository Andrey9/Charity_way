$(document).ready(function () { // вся магия после загрузки страницы
    $('a.go').click(function (event) { // ловим клик по ссылки с id="go"
        event.preventDefault(); // выключаем стандартную роль элемента
        $('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
            function () { // после выполнения предъидущей анимации
                $('#modal_form')
                    .css('display', 'block') // убираем у модального окна display: none;
                    .animate({opacity: 1, top: '30%'}, 200); // плавно прибавляем прозрачность одновременно со съезжанием вниз
            });
    });

    /* Закрытие модального окна, тут делаем то же самое но в обратном порядке */
    $('#modal_close, #overlay').click(function () { // ловим клик по крестику или подложке
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
    $('a.go1').click(function (event) { // ловим клик по ссылки с id="go"
        event.preventDefault(); // выключаем стандартную роль элемента
        $('#overlay1').fadeIn(400, // сначала плавно показываем темную подложку
            function () { // после выполнения предъидущей анимации
                $('#modal_form1')
                    .css('display', 'block') // убираем у модального окна display: none;
                    .animate({opacity: 1, top: '30%'}, 200); // плавно прибавляем прозрачность одновременно со съезжанием вниз
            });
    });

    /* Закрытие модального окна, тут делаем то же самое но в обратном порядке */
    $('#modal_close1, #overlay1').click(function () { // ловим клик по крестику или подложке
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
    $('.number-min').click(function () {
        var $input = $(this).closest('.group-input').find('input[type="number"]')
        console.log($input);
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $('.number-max').click(function () {
        var $input = $(this).closest('.group-input').find('input[type="number"]')
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });
});


$(document).ready(function() {
    $('#comments_block').jScrollPane();
});