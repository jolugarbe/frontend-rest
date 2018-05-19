// Additional method for validate CIF/NIF with jQueryValidator
jQuery.validator.addMethod("identificacionES", function(value, element) {
    "use strict";

    value = value.toUpperCase();

    // Texto común en todos los formatos
    if (!value.match('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)')) {
        return false;
    }

    /* Inicio validacion NIF */
    if (/^[0-9]{8}[A-Z]{1}$/.test(value)) {
        return ("TRWAGMYFPDXBNJZSQVHLCKE".charAt(value.substring(8, 0) % 23) === value.charAt(8));
    }
    //  Hay ciertos NIFs que empiezan por K, L o M
    if (/^[KLM]{1}/.test(value)) {
        return (value[ 8 ] === String.fromCharCode(64));
    }
    /* Fin validacion NIF */


    /* Inicio validacion NIE */
//            if (/^[T]{1}/.test(value)) {
//                return (value[ 8 ] === /^[T]{1}[A-Z0-9]{8}$/.test(value));
//            }
//
//            // Con los que empiezan por XYZ
//            if (/^[XYZ]{1}/.test(value)) {
//                return (
//                    value[ 8 ] === "TRWAGMYFPDXBNJZSQVHLCKE".charAt(
//                        value.replace('X', '0')
//                            .replace('Y', '1')
//                            .replace('Z', '2')
//                            .substring(0, 8) % 23
//                    )
//                );
//            }
    /* Fin validacion NIE */

    /* Inicio validacion CIF */
    var sum,
        num = [],
        digitoControl;


    for (var i = 0; i < 9; i++) {
        num[ i ] = parseInt(value.charAt(i), 10);
    }

    // Comprobamos el CIF
    sum = num[ 2 ] + num[ 4 ] + num[ 6 ];
    for (var count = 1; count < 8; count += 2) {
        var tmp = (2 * num[ count ]).toString(),
            tmpValor = tmp.charAt(1);

        sum += parseInt(tmp.charAt(0), 10) + (tmpValor === '' ? 0 : parseInt(tmpValor, 10));
    }

    if (/^[ABCDEFGHJNPQRSUVW]{1}/.test(value)) {
        sum += '';
        digitoControl = 10 - parseInt(sum.charAt(sum.length - 1), 10);
        value += digitoControl;
        return (num[ 8 ].toString() === String.fromCharCode(64 + digitoControl) || num[ 8 ].toString() === value.charAt(value.length - 1));
    }
    /* Fin validacion CIF */

    return false;

}, "Por favor indica un CIF / NIF correcto.");