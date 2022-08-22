<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn"t be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" rel="stylesheet">

    <!-- CSS Reset : BEGIN -->
    <style>
        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background: #f1f1f1;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
        a {
            text-decoration: none;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        *[x-apple-data-detectors],
        /* iOS */
        .unstyle-auto-detected-links *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }

        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
        .im {
            color: inherit !important;
        }

        /* If the above doesn"t work, add a .g-img class to any image in question. */
        img.g-img+div {
            display: none !important;
        }

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you"d like to fix */

        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            u~div .email-container {
                min-width: 320px !important;
            }
        }

        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            u~div .email-container {
                min-width: 375px !important;
            }
        }

        @media only screen and (min-device-width: 414px) {
            u~div .email-container {
                min-width: 414px !important;
            }
        }

        /* BACKGROUND SLICE */
        .title-div {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            height: 30px;
            font-family: 'Barlow Condensed', sans-serif;
            text-transform: uppercase;
            color: #ffffff;
            font-size: 5vw;
            line-height: 30px;
            width: 100%;
            font-weight: bold;
            overflow: visible;
        }

        .title-left,
            {
            height: 35px;
            position: relative;
            text-align: center;
            overflow: visible;
            z-index: 0
        }

        .title-left {
            width: 70%;
            z-index: 999;
            border-top: 4px solid white;
            border-left: 4px solid white;
            -webkit-transform: translateY(-15px);
            -ms-transform: translateY(-15px);
            transform: translateY(-15px);
            background-color: #0054a6;
        }

        .title-left::before {
            content: '';
            position: absolute;
            top: -4px;
            width: 95%;
            left: 9%;
            height: 31px;
            border-top: 4px solid white;
            border-right: 4px solid white;
            -webkit-transform: skew(-30deg);
            -ms-transform: skew(-30deg);
            transform: skew(-30deg);
            z-index: -1;
            background-color: #0054a6;
        }

        @media screen and (min-width:500px) {
            .title-div {
                height: 55px;
                font-size: 2vw;
                line-height: 55px;
            }

            .title-left,
                {
                height: 55px;
            }

            .title-left {
                border-top: 10px solid white;
                border-left: 10px solid white;
            }

            .title-left::before {
                top: -10px;
                width: 95%;
                left: 8%;
                height: 55px;
                border-top: 10px solid white;
                border-right: 10px solid white;
            }

        }

        @media screen and (min-width:300px) {
            .title-div {
                height: 40px;
                font-size: 2vw;
                line-height: 40px;
            }

            .title-left,
                {
                height: 40px;
            }

            .title-left {
                border-top: 10px solid white;
                border-left: 10px solid white;
            }

            .title-left::before {
                top: -10px;
                width: 95%;
                left: 8%;
                height: 40px;
                border-top: 10px solid white;
                border-right: 10px solid white;
            }

        }

        @media screen and (min-width:900px) {
            .title-div {
                height: 100px;
                line-height: 100px;
            }

            .title-left,
                {
                height: 95px;
            }

            .title-left::before {
                width: 95%;
                top: -10px;
                left: 13%;
                height: 95px;
            }
        }

        @media screen and (min-width:992px) {
            h1 {
                font-size: 30px;
            }

            .site-title {
                font-size: 4vw;
                line-height: 1.1;
            }

            .title-left::before {
                width: 100%;
                left: 7%;
            }
        }
    </style>

    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>
        .primary {
            background: #17bebb;
        }

        .bg_white {
            background: #ffffff;
        }

        .bg_light {
            background: #f7fafa;
        }

        .bg_black {
            background: #000000;
        }

        .bg_dark {
            background: rgba(0, 0, 0, .8);
        }

        .email-section {
            padding: 2.5em;
        }

        /*BUTTON*/
        .btn {
            padding: 10px 15px;
            display: inline-block;
        }

        .btn.btn-primary {
            border-radius: 5px;
            background: #17bebb;
            color: #ffffff;
        }

        .btn.btn-white {
            border-radius: 5px;
            background: #ffffff;
            color: #000000;
        }

        .btn.btn-white-outline {
            border-radius: 5px;
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
        }

        .btn.btn-black-outline {
            border-radius: 0px;
            background: transparent;
            border: 2px solid #000;
            color: #000;
            font-weight: 700;
        }

        .btn-custom {
            color: rgba(0, 0, 0, .3);
            text-decoration: underline;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Poppins", sans-serif;
            color: #000000;
            margin-top: 0;
            font-weight: 400;
        }

        body {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-size: 15px;
            line-height: 1.8;
            color: rgba(0, 0, 0, .4);
        }

        a {
            color: #17bebb;
        }

        table {}

        /*LOGO*/

        .logo h1 {
            margin: 0;
        }

        .logo h1 a {
            color: #17bebb;
            font-size: 24px;
            font-weight: 700;
            font-family: "Poppins", sans-serif;
        }

        /*HERO*/
        .hero {
            position: relative;
            z-index: 0;
        }

        .hero .text {
            color: rgba(0, 0, 0, .3);
        }

        .hero .text h2 {
            color: #000;
            font-size: 34px;
            margin-bottom: 0;
            font-weight: 200;
            line-height: 1.4;
        }

        .hero .text h3 {
            font-size: 24px;
            font-weight: 300;
        }

        .hero .text h2 span {
            font-weight: 600;
            color: #000;
        }

        .text-author {
            bordeR: 1px solid rgba(0, 0, 0, .05);
            max-width: 50%;
            margin: 0 auto;
            padding: 2em;
        }

        .text-author img {
            border-radius: 50%;
            padding-bottom: 20px;
        }

        .text-author h3 {
            margin-bottom: 0;
        }

        ul.social {
            padding: 0;
        }

        ul.social li {
            display: inline-block;
            margin-right: 10px;
        }

        /*FOOTER*/

        .footer {
            border-top: 1px solid rgba(0, 0, 0, .05);
            color: rgba(0, 0, 0, .5);
        }

        .footer .heading {
            color: #000;
            font-size: 12px;
        }

        .footer ul {
            margin: 0;
            padding: 0;
        }

        .footer ul li {
            list-style: none;
            margin-bottom: 10px;
        }

        .footer ul li a {
            color: rgba(0, 0, 0, 1);
        }


        @media screen and (max-width: 500px) {}
    </style>
</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;">
    <center style="width: 100%; background-color: #f1f1f1;">
        <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
        </div>
        <div style="max-width: 1000px; margin: 0 auto;" class="email-container">
            <!-- BEGIN BODY -->
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                <tr>
                    <td valign="top" class="bg_white" style="padding: 1em 1em 0 1em;">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">

                            <tr>
                                <td class="logo" style="text-align: center;padding-top: 10px;">
                                    <div class="title-div">
                                        <div class="title-left">E-PAYSLIP SEPTEMBER 2022</div>
                                        <img style="position: relative; right: 0;" width="200px;" src="<?= base_url('assets/images/nusindoPNG.png') ?>" alt="PT Rajawali Nusindo" />
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                    <tr>
                        <td valign="middle" class="bg_white footer email-section">
                            <table>
                                <tr>
                                    <td valign="top" width="100%" style="padding-top: 5px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr style="background-color: #f2f2f2;">
                                                <td style="text-align: left; padding-right: 10px;">
                                                    <b class="heading"> NIK </b>
                                                </td>
                                                <td width="2%" style="text-align: left; padding-right: 10px;">
                                                    <b class="heading"> : </b>
                                                </td>
                                                <td style="text-align: left; padding-right: 10px;">
                                                    <b class="heading"> 123123123 </b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left; padding-right: 10px;">
                                                    <b class="heading"> NAMA </b>
                                                </td>
                                                <td width="2%" style="text-align: left; padding-right: 10px;">
                                                    <b class="heading"> : </b>
                                                </td>
                                                <td style="text-align: left; padding-right: 10px;">
                                                    <b class="heading"> AHMAT CHOLID </b>
                                                </td>
                                            </tr>
                                            <tr style="background-color: #f2f2f2;">
                                                <td style="text-align: left; padding-right: 10px;">
                                                    <b class="heading"> JABATAN </b>
                                                </td>
                                                <td width="2%" style="text-align: left; padding-right: 10px;">
                                                    <b class="heading"> : </b>
                                                </td>
                                                <td style="text-align: left; padding-right: 10px;">
                                                    <b class="heading"> PELAKSANA SDM </b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left; padding-right: 10px;">
                                                    <b class="heading"> GOLONGAN </b>
                                                </td>
                                                <td width="2%" style="text-align: left; padding-right: 10px;">
                                                    <b class="heading"> : </b>
                                                </td>
                                                <td style="text-align: left; padding-right: 10px;">
                                                    <b class="heading"> IV </b>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" width="100%" style="padding-top: 20px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                            <tr style="text-align: left; padding-right: 10px;">
                                                <td colspan="3" style="background-color: #0054a6;">
                                                    <b class="heading" style="display:flex;align-items:center;color:white;padding-left:5px;"> GAJI NORMATIF </b>
                                                </td>
                                            </tr>
                                            <tr style="height: 5px; background-color: #f2f2f2;">
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Gaji Pokok = 5.000.0000
                                                </td>
                                                <td width="2%" style="height: 5px; text-align: left; padding-right: 10px;"></td>
                                                <td style="height: 5px; text-align: left; padding-right: 10px;"></td>
                                            </tr>
                                            <tr style="height: 5px;">
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    TUNJ. KELUARGA = 1000
                                                </td>
                                                <td width="2%" style="height: 5px; text-align: left; padding-right: 10px;"></td>
                                                <td style="height: 5px; text-align: left; padding-right: 10px;"></td>
                                            </tr>
                                            <tr style="height: 5px; background-color: #f2f2f2;">
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    FAKTOR = 123123
                                                </td>
                                                <td width="2%" style="height: 5px; text-align: left; padding-right: 10px;"></td>
                                                <td style="height: 5px; text-align: left; padding-right: 10px;"></td>
                                            </tr>
                                            <tr style="height: 5px;">
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Gaji Dasar Pensiun
                                                </td>
                                                <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Rp 123123
                                                </td>
                                            </tr>
                                            <tr style="height: 5px; background-color: #f2f2f2;">
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Tunj. Golongan
                                                </td>
                                                <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Rp 123123123
                                                </td>
                                            </tr>
                                            <tr style="height: 5px;">
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Tunj. Merit
                                                </td>
                                                <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Rp 123123
                                                </td>
                                            </tr>
                                            <tr style="height: 5px; background-color: #f2f2f2;">
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Tunj. Beras
                                                </td>
                                                <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Rp 123123
                                                </td>
                                            </tr>
                                            <tr style="height: 5px;">
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Tunj. Peralihan
                                                </td>
                                                <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Rp 12313123
                                                </td>
                                            </tr>
                                            <tr style="height: 5px; background-color: #f2f2f2;">
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Tunj. Operasional
                                                </td>
                                                <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Rp 123123123
                                                </td>
                                            </tr>
                                            <tr style="height: 5px;">
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Tunj. Bantuan Sosial
                                                </td>
                                                <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Rp 12312234
                                                </td>
                                            </tr>
                                            <tr style="height: 5px; background-color: #f2f2f2;">
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Tunj. Kompensasi UMP
                                                </td>
                                                <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                    Rp 23453223
                                                </td>
                                            </tr>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="100%" style="padding-top: 5px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr style="height:5px;">
                                <tr style="text-align: left; padding-right: 10px;">
                                    <td colspan="3" style="background-color: #0054a6;">
                                        <b class="heading" style="display:flex;align-items:center;color:white;padding-left:5px;"> TUNJANGAN </b>
                                    </td>
                                </tr>
                                <tr style="height: 5px; background-color: #f2f2f2;">
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        STRUKTURAL
                                    </td>
                                    <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        Rp 234234234
                                    </td>
                                </tr>
                                <tr style="height: 5px;">
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        LISTRIK & AIR
                                    </td>
                                    <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        Rp 2342342
                                    </td>
                                </tr>
                                <tr style="height: 5px; background-color: #f2f2f2;">
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        TRANSPORT
                                    </td>
                                    <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        Rp 234234234
                                    </td>
                                </tr>
                                <tr style="height: 5px;">
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        PERUMAHAN
                                    </td>
                                    <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        Rp 234234234
                                    </td>
                                </tr>
                                <tr style="height: 5px; background-color: #f2f2f2;">
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        SKALA
                                    </td>
                                    <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        Rp 234234
                                    </td>
                                </tr>
                                <tr style="height: 5px;">
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        KEMAHALAN
                                    </td>
                                    <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        Rp 234234234
                                    </td>
                                </tr>
                                <tr style="height: 5px; background-color: #f2f2f2;">
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        LAIN - LAIN
                                    </td>
                                    <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        Rp 234234234
                                    </td>
                                </tr>
                                <tr style="height: 5px;">
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        PPH Ps 21
                                    </td>
                                    <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        Rp 234234234
                                    </td>
                                </tr>
                                <tr style="height: 5px; background-color: #f2f2f2;">
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        PREMI PENSIUN
                                    </td>
                                    <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        Rp 23423423
                                    </td>
                                </tr>
                                <tr style="height: 5px;">
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        PREMI JAMSOSTEK
                                    </td>
                                    <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        Rp 2342342
                                    </td>
                                </tr>
                                <tr style="height: 5px; background-color: #f2f2f2;">
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        BPJS KESEHATAN
                                    </td>
                                    <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        Rp 234234
                                    </td>
                                </tr>
                                <tr style="height: 5px;">
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        BPJS KETENAGAKERJAAN
                                    </td>
                                    <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        Rp 23423423
                                    </td>
                                </tr>
                                <tr style="height: 5px; background-color: #f2f2f2;">
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        UANG MUKA
                                    </td>
                                    <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        Rp 2342342
                                    </td>
                                </tr>
                                <tr style="height: 5px;">
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        DPLK
                                    </td>
                                    <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                    <td style="height: 5px; text-align: left; padding-right: 10px;">
                                        Rp 2342342
                                    </td>
                                </tr>
                    </tr>
                </table>
                </td>
                </tr>
                <tr>
                    <td valign="top" width="100%" style="padding-top: 5px;">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                            <tr style="text-align: left; padding-right: 10px;">
                                <td colspan="3" style="background-color: #0054a6;">
                                    <b class="heading" style="display:flex;align-items:center;color:white;padding-left:5px;"> JUMLAH PERHITUNGAN GAJI </b>
                                </td>
                            </tr>
                            <tr style="height: 5px; background-color: #f2f2f2;">
                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                    GAJI DASAR PENSIUN
                                </td>
                                <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                    Rp 234234
                                </td>
                            </tr>
                            <tr style="height: 5px;">
                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                    GAJI KOTOR
                                </td>
                                <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                    Rp 234234
                                </td>
                            </tr>
                            <tr style="height: 5px; background-color: #f2f2f2;">
                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                    GAJI BERSIH
                                </td>
                                <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                    Rp 23423423
                                </td>
                            </tr>
                            <tr style="height: 5px;">
                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                    POTONGAN LAIN-LAIN
                                </td>
                                <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                    Rp 23423423
                                </td>
                            </tr>
                            <tr style="height: 5px; background-color: #f2f2f2;">
                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                    JUMLAH DIBAYAR
                                </td>
                                <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                <td style="height: 5px; text-align: left; padding-right: 10px;">
                                    Rp 2342342234
                                </td>
                            </tr>
                </tr>
            </table>
            </td>
            </tr>
            </table>
            </td>
            </tr>
            </table>
            </table>
        </div>
    </center>
</body>

</html>