import './bootstrap';

import 'jquery-mask-plugin/dist/jquery.mask.min.js';

import 'daterangepicker/daterangepicker.css';
import 'daterangepicker/daterangepicker.js';

$(function () {
    $('.cpf').mask('000.000.000-00')
    $('.cep').mask('00000-000')

    $('.daterange').daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        locale: {
            format: 'DD/MM/YYYY HH:mm:ss'
        }
    })
})
