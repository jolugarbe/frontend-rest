<html><head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style type="text/css">
        /* FONTS */
        @media screen {
            @font-face {
                font-family: 'Lato';
                font-style: normal;
                font-weight: 400;
                src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: normal;
                font-weight: 700;
                src: local('Lato Bold'), local('Lato-Bold'), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: italic;
                font-weight: 400;
                src: local('Lato Italic'), local('Lato-Italic'), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: italic;
                font-weight: 700;
                src: local('Lato Bold Italic'), local('Lato-BoldItalic'), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
            }
        }

        /* CLIENT-SPECIFIC STYLES */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; }

        /* RESET STYLES */
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* MOBILE STYLES */
        @media screen and (max-width:600px){
            h1 {
                font-size: 32px !important;
                line-height: 32px !important;
            }
        }

        /* ANDROID CENTER FIX */
        div[style*="margin: 16px 0;"] { margin: 0 !important; }
    </style>
</head>
<body style="background-color: #f3f5f7; margin: 0 !important; padding: 0 !important;">

<!-- HIDDEN PREHEADER TEXT -->
{{--<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Lato', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">--}}
{{--We're thrilled to have you here! Get ready to dive into your new account.--}}
{{--</div>--}}

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!-- LOGO -->
    <tbody><tr>
        <td bgcolor="#33cabb" align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                <tr>
                    <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tbody><tr>
                    <td align="center" valign="top" style="padding: 80px 10px 80px 10px;">
                        <a href="{{URL::to('/')}}" target="_blank">
                            <img alt="Logo" src="{{URL::to('images/logocafaapp.png')}}" style="display: block; font-family: 'Lato', Helvetica, Arial, sans-serif; color: #ffffff; font-size: 18px;" border="0">
                        </a>
                    </td>
                </tr>
                </tbody></table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <!-- HERO -->
    <tr>
        <td bgcolor="#33cabb" align="center" style="padding: 0px 10px 0px 10px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                <tr>
                    <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tbody><tr>
                    <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                        <h1 style="font-size: 42px; font-weight: 400; margin: 0;">@if($is_owner) ¡Solicitud recibida! @else ¡Solicitud enviada! @endif</h1>
                    </td>
                </tr>
                </tbody></table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <!-- COPY BLOCK -->
    <tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                <tr>
                    <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <!-- COPY -->
                <tbody><tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;">
                        <p style="margin: 0;">Has @if($is_owner) recibido @else enviado @endif una solicitud de cesión del residuo:</p>
                        <p style="text-align: center"><strong>{{$waste->name}}</strong></p>
                        <p style="text-align: justify">Puedes consultar todos los datos del residuo así como de la empresa @if($is_owner) solicitante @else propietaria @endif del mismo en tu cuenta. <strong>@if($is_owner) "Mis Residuos/Cesiones" @else "Mis Residuos/Solicitudes" @endif</strong></p>
                    </td>
                </tr>
                <!-- BULLETPROOF BUTTON -->
                <tr>
                    <td bgcolor="#ffffff" align="left">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody><tr>
                                <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                                    <table border="0" cellspacing="0" cellpadding="0">
                                        <tbody><tr>
                                            <td align="center" style="border-radius: 3px;" bgcolor="#33cabb"><a @if($is_owner) href="{{URL::to('waste/user/transfers')}}" @else href="{{URL::to('waste/user/requests')}}" @endif target="_blank" style="font-size: 18px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 12px 50px; border-radius: 2px; border: 1px solid #33cabb; display: inline-block;">Acceder</a></td>
                                        </tr>
                                        </tbody></table>
                                </td>
                            </tr>
                            </tbody></table>
                    </td>
                </tr>
                <!-- COPY -->
                <tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;">
                        <p style="margin: 0; text-align: justify">Contacta con la empresa @if($is_owner) solicitante @else propietaria @endif para concretar las condiciones de la cesión del residuo. @if($is_owner)Recuerda que puedes aceptar o rechazar la solicitud desde tu panel de administración. @else Recuerda que puedes comprobar el estado de la solicitud desde tu panel de control. @endif </p>
                    </td>
                </tr>
                <!-- COPY -->
                <tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 25px;">
                        <p style="margin: 0;">Un saludo,<br>CAFA | Bolsa de residuos reutilizables y reciclables</p>
                    </td>
                </tr>
                </tbody></table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <!-- SUPPORT CALLOUT -->
    <tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                <tr>
                    <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <!-- HEADLINE -->
                <tbody><tr>
                    <td bgcolor="#fafafa" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;">
                        <h2 style="font-size: 16px; font-weight: 400; color: #111111; margin: 0;">¿Necesitas ayuda?</h2>
                        <p style="margin: 0; font-size: 14px;"><a href="{{URL::to('/')}}" target="_blank" style="color: #33cabb;">Habla con nosotros</a></p>
                    </td>
                </tr>
                </tbody></table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <!-- FOOTER -->
    <tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                <tr>
                    <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <!-- NAVIGATION -->
                <tbody>
                {{--<tr>--}}
                {{--<td bgcolor="#f4f4f4" align="left" style="padding: 30px 30px 30px 30px; color: #aaaaaa; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 18px;">--}}
                {{--<p style="margin: 0;">--}}
                {{--<a href="http://thetheme.io" target="_blank" style="color: #999999; font-weight: 700;">Dashboard</a> ---}}
                {{--<a href="http://thetheme.io" target="_blank" style="color: #999999; font-weight: 700;">Billing</a> ---}}
                {{--<a href="http://thetheme.io" target="_blank" style="color: #999999; font-weight: 700;">Help</a>--}}
                {{--</p>--}}
                {{--</td>--}}
                {{--</tr>--}}
                <!-- PERMISSION REMINDER -->
                <tr>
                    <td bgcolor="#f4f4f4" align="left" style="padding: 0px 30px 30px 30px; color: #aaaaaa; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 18px;">
                        <p style="margin: 0;">Has recibido este correo porque estás registrado en la bolsa de residuos reutilizables y reciclables. </p>
                        {{--<a href="http://thetheme.io" target="_blank" style="color: #999999; font-weight: 700;">view it in your browser</a>.</p>--}}
                    </td>
                </tr>
                <!-- UNSUBSCRIBE -->
                {{--<tr>--}}
                {{--<td bgcolor="#f4f4f4" align="left" style="padding: 0px 30px 30px 30px; color: #aaaaaa; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;">--}}
                {{--<p style="margin: 0;">If these emails get annoying, please feel free to <a href="http://thetheme.io" target="_blank" style="color: #999999; font-weight: 700;">unsubscribe</a>.</p>--}}
                {{--</td>--}}
                {{--</tr>--}}
                <!-- ADDRESS -->
                <tr>
                    <td bgcolor="#f4f4f4" align="left" style="padding: 0px 30px 30px 30px; color: #aaaaaa; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 18px;">
                        <p style="margin: 0;">CAFA | Vereda de Sevilla S/N. 41600 Arahal (Sevilla)</p>
                    </td>
                </tr>
                </tbody></table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    </tbody></table>



</body></html>