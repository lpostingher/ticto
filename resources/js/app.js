import './bootstrap';

import 'jquery-mask-plugin/dist/jquery.mask.min.js';

$(function () {
    $('.cpf').mask('000.000.000-00')
    $('.cep').mask('00000-000')
})
