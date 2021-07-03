<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <title>Chiropractic Care</title>
{{--    <link rel="stylesheet" href="assets/fonts/fonts.min.css">--}}
{{--    <link rel="stylesheet" href="assets/plugins/font-awesome/font-awesome.min.css">--}}
{{--    <link rel="stylesheet" href="assets/plugins/jquery-ui/jquery-ui.min.css">--}}
{{--    <link rel="stylesheet" href="assets/plugins/jquery-ui/timepicker.min.css">--}}
{{--    <link rel="stylesheet" href="assets/plugins/bootstrap/bootstrap.min.css">--}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.16/jquery.timepicker.min.css" integrity="sha512-GgUcFJ5lgRdt/8m5A0d0qEnsoi8cDoF0d6q+RirBPtL423Qsj5cI9OxQ5hWvPi5jjvTLM/YhaaFuIeWCLi6lyQ==" crossorigin="anonymous" />
    <style>
        /*==========================================================
Theme Name: Chiropractic - Care for Back Pain
Author: OG Web Solutions
Author URI: https://www.ogwebsolutions.com/
Version:  1.0
==========================================================*/


        /*==========================================================
            CSS Index
        ============================================================
            # Global Styles
                ## Header
                ## Footer
                ## Banner Section
            # Home Page
            # Appointment Confirmation Page
            # Privacy Policy Page
            # Order Page
            # Order Cancelled Page
            # Thank You Page

        ==========================================================*/


        /*==========================================================
            # Global Styles
        ==========================================================*/

        body {
            color: #202020;
            background-color: #fff;
            font-family: 'Montserrat', sans-serif;
        }


        /*========== Text Colors ==========*/

        .text-blue {
            color: #02a5e9;
        }

        .text-yellow {
            color: #FFDB5D;
        }

        .text-orange {
            color: #fc6406;
        }

        /*========== Background Colors ==========*/

        .bg-blue {
            background-color: #02a5e9;
        }

        /*========== Font Weight ==========*/

        .font-weight-regular {
            font-weight: 400;
        }

        .font-weight-medium {
            font-weight: 500;
        }

        .font-weight-semibold {
            font-weight: 600;
        }


        /*========== Text Decoration ==========*/

        .text-underline {
            text-decoration: underline;
        }

        /*========== Line Height ==========*/

        .line-height-1-5 {
            line-height: 1.5 !important;
        }

        .line-height-1-2 {
            line-height: 1.2 !important;
        }



        /*========== Section Title ==========*/

        .section-title {
            margin-bottom: 40px;
            text-align: center;
        }

        .section-title h2 {
            font-size: 62px;
        }

        .section-title h5 {
            font-size: 22px;
            line-height: 1.5;
        }

        @media (max-width:991.98px) {
            .section-title h2 {
                font-size: 42px;
            }
        }

        @media (max-width:1199.98px) {
            .section-title h2 {
                font-size: 36px;
            }
            .section-title h5 {
                font-size: 20px;
            }
        }

        @media (max-width:767.98px) {
            .section-title h2 {
                font-size: 28px;
            }
            .section-title h5 {
                font-size: 18px;
            }
        }


        /*========== Buttons ==========*/

        .btn {
            border-radius: 10px;
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .btn:focus {
            box-shadow: none;
            outline: none;
        }

        .btn .title {
            font-size: 22px;
        }

        .btn .sub-title {
            font-size: 17px;
        }

        .btn-orange {
            background-color: #fc6406;
            color: #fff;
            max-width: 430px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            border: solid 2px #fc6406;
        }

        .btn-orange:hover {
            background-color: transparent;
            color: #fc6406;
        }

        .btn-hover-white:hover {
            background-color: #fff;
            color: #fc6406;
            border-color: #fff;
        }

        @media (max-width:767.98px) {
            .btn .title {
                font-size: 16px;
            }
            .btn .sub-title {
                font-size: 14px;
            }
        }


        /*========== Section Spacer ==========*/

        .section-spacer {
            padding-top: 80px;
            padding-bottom: 80px;
        }

        .section-alt-spacer {
            padding-top: 70px;
            padding-bottom: 80px;
        }

        .section-equal-spacer {
            padding-top: 70px;
            padding-bottom: 50px;
        }

        @media (max-width:991.98px) {
            .section-spacer {
                padding-top: 50px;
                padding-bottom: 50px;
            }
            .section-alt-spacer {
                padding-top: 45px;
                padding-bottom: 50px;
            }
            .section-equal-spacer {
                padding-top: 45px;
                padding-bottom: 10px;
            }
        }

        @media (max-width:767.98px) {
            .section-spacer {
                padding-top: 30px;
                padding-bottom: 30px;
            }
            .section-alt-spacer {
                padding-top: 25px;
                padding-bottom: 30px;
            }
            .section-equal-spacer {
                padding-top: 25px;
                padding-bottom: 0;
            }
        }

        /*========== Custom List ==========*/

        .custom-list-arrow {
            list-style-type: none;
            padding-left: 0;
        }

        .custom-list-arrow li {
            position: relative;
            padding-left: 40px;
        }

        .custom-list-arrow li:not(:last-child) {
            margin-bottom: 5px;
        }

        .custom-list-arrow li:before {
            /*content:url('../../../img/home-05-right-arrow-icon.png');*/
            content:url('../../../public/images/img/home-05-right-arrow-icon.png');
            position: absolute;
            left: 0;
            top: 0;
        }

        /*========== Custom Bullet ==========*/

        .custom-list-blue {
            list-style-type: none;
            padding-left: 0;
        }

        .custom-list-blue li {
            position: relative;
            padding-left: 25px;
        }

        .custom-list-blue li:not(:last-child) {
            margin-bottom: 5px;
        }

        .custom-list-blue li:before {
            content:'';
            position: absolute;
            left: 0;
            top: 7px;
            width:10px;
            height: 10px;
            border-radius: 10px;
            background-color: #02a5e9;
        }

        /*========== Blockquote ==========*/

        .blockquote {
            background-color: #f5f5f5;
            padding: 20px;
        }

        @media (max-width:767.98px) {
            .blockquote * {
                font-size: 18px;
            }
        }


        /*----------------------------------------------------------
            ## Header
        ---------------------------------------------------------*/

        header {
            padding-top: 5px;
            padding-bottom: 5px;
            background-color: #fff;
            -webkit-box-shadow: 0 0 5px #c1c1c1;
            box-shadow: 0 0 5px #c1c1c1;
        }

        .navbar-brand {
            max-width: 170px;
            width: 100%;
        }

        @media (max-width:767.98px) {
            header p {
                font-size: 14px;
            }
        }


        /*----------------------------------------------------------
            ## Footer
        ---------------------------------------------------------*/

        footer {
            background: #011226;
            padding-top: 50px;
            padding-bottom: 45px;
            border-top: 5px solid #02a5e9;
        }

        footer p,
        footer a {
            color: #fff;
            opacity: .5;
        }

        footer ul li {
            position: relative;
        }

        footer ul li:not(:last-child) {
            margin-right: 15px !important;
        }

        footer ul li:not(:last-child):after {
            content: '';
            position: absolute;
            right: -10px;
            top: 4px;
            width: 1px;
            height: 15px;
            background-color: rgba(255,255,255,.5);
        }

        footer .logo {
            max-width: 170px;
        }

        footer p:last-of-type {
            margin-bottom: 0;
        }

        @media (max-width:767.98px) {
            footer {
                font-size: 14px;
            }
        }

        /*----------------------------------------------------------
            ## Banner-Section
        ---------------------------------------------------------*/

        .banner-section h2 {
            font-size: 50px;
        }

        @media (max-width:1199.98px) {
            .banner-section h2 {
                font-size: 36px;
            }
        }

        @media (max-width:991.98px) {
            .banner-section h2 {
                font-size: 30px;
            }
        }

        @media (max-width:767.98px) {
            .banner-section h2 {
                font-size: 26px;
            }
        }


        /*==========================================================
            # Home Page
        ==========================================================*/

        main {
            margin-top: 59px;
        }

        @media (max-width:767.98px) {
            main {
                margin-top: 109px;
            }
        }

        /*----------------------------------------------------------
            ## Hero Section
        ---------------------------------------------------------*/

        .hero-section {
            padding-top: 80px;
            padding-bottom: 100px;
            background-image: url(../../../public/images/img/hero-bg.jpg);
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
        }

        .hero-section h1 {
            font-size: 88px;
        }

        .hero-section h2 {
            font-size: 68px;
            border: solid 2px #000;
            padding-left: 10px;
            padding-right: 10px;
            margin-bottom: 15px;
        }

        .hero-section p {
            font-size: 21px;
            max-width: 600px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-section .btn {
            margin-top: 30px;
        }

        .hero-section .btn:before {
            content: url('../../../public/images/img/left_arrow.png');
            position: absolute;
            left: -130px;
            top: -55px;
        }

        .hero-section .btn:after {
            content: url('../../../public/images/img/right_arrow.png');
            position: absolute;
            right: -130px;
            top: -55px;
        }

        @media (max-width:1500px) {
            .hero-section {
                padding-top: 50px;
                padding-bottom: 70px;
            }
        }

        @media (max-width:1199.98px) {
            .hero-section {
                background-position: 73% 100%;
            }

            .hero-section h1 {
                font-size: 70px;
            }
            .hero-section h2 {
                font-size: 54px;
            }
            .hero-section p {
                font-size: 18px;
            }
        }

        @media (max-width:991.98px) {
            .hero-section .btn:before,
            .hero-section .btn:after {
                display:none;
            }
            .hero-section h1 {
                font-size: 60px;
            }
            .hero-section h2 {
                font-size: 44px;
            }
        }

        @media (max-width:767.98px) {
            .hero-section h1 {
                font-size: 36px;
            }
            .hero-section h2 {
                font-size: 26px;
            }
        }


        /*----------------------------------------------------------
            ## Benefits Section
        ---------------------------------------------------------*/

        .benefits-section {
            padding-top: 45px;
            padding-bottom: 45px;
            background: rgb(1, 84, 161);
            background: -moz-linear-gradient(90deg, rgba(1, 84, 161, 1) 0%, rgba(0, 113, 185, 1) 100%);
            background: -webkit-linear-gradient(90deg, rgba(1, 84, 161, 1) 0%, rgba(0, 113, 185, 1) 100%);
            background: linear-gradient(90deg, rgba(1, 84, 161, 1) 0%, rgba(0, 113, 185, 1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#0154a1", endColorstr="#0071b9", GradientType=1);
        }

        .benefits-section h2 {
            font-size: 43px;
        }

        .benefits-section h5 {
            font-size: 18px;
        }

        .benefits-section .inner-container {
            margin-top: 30px;
        }

        .benefits-section .inner-container figure {
            margin-bottom: 20px;
        }

        .benefits-section .inner-container h5 {
            margin-bottom: 5px;
        }

        @media (max-width:1199.98px) {
            .benefits-section h2 {
                font-size: 30px;
            }
            .benefits-section .section-title {
                margin-bottom: 10px;
            }
        }

        @media (max-width:767.98px) {
            .benefits-section h2 {
                font-size: 26px;
            }
        }


        /*----------------------------------------------------------
            ## Improve Section
        ---------------------------------------------------------*/

        .improve-section {
            background: #fff;
        }

        .improve-section ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .improve-section ul li {
            list-style: none;
            margin-bottom: 30px;
        }

        .improve-section ul li:last-child {
            margin-bottom: 0;
        }

        .improve-section ul li img {
            width: 78px;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .improve-section h3 {
            font-size: 24px;
        }

        .improve-section p {
            font-size: 16px;
            font-weight: 500;
        }

        .improve-section p:last-of-type {
            margin-bottom: 0;
        }

        @media (max-width:767.98px) {
            .improve-section h3 {
                font-size: 20px;
            }
        }


        /*----------------------------------------------------------
            ## Why are You Suffering Section
        ---------------------------------------------------------*/

        .cta-section {
            padding-top: 145px;
            padding-bottom: 155px;
            background-image: url(../../../public/images/img/banner-home-04.png);
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
        }

        .cta-section h2 {
            padding-left: 10px;
            padding-right: 10px;
            margin-bottom: 20px;
        }

        .cta-section h5 {
            max-width: 700px;
        }

        .cta-section .section-title {
            max-width: 900px;
        }

        .cta-section h2:before {
            content: url('../../../public/images/img/home-04-left-arrow.png');
            position: absolute;
            left: -20px;
            top: 55px;
        }

        .cta-section h2:after {
            content: url('../../../public/images/img/home-04-right-arrow.png');
            position: absolute;
            right: -20px;
            top: 55px;
        }

        @media (max-width:1199.98px) {
            .cta-section {
                padding-top: 110px;
                padding-bottom: 120px;
            }
        }

        @media (max-width:991.98px) {
            .cta-section {
                padding-top: 40px;
                padding-bottom: 50px;
            }
        }

        @media (max-width:767.98px) {
            .cta-section h2:before,
            .cta-section h2:after {
                display:none;
            }
        }


        /*----------------------------------------------------------
            ## FAQ
        ---------------------------------------------------------*/

        .faq-section {
            background-color: #f0f0f0;
        }

        .faq-section .container {
            max-width: 980px;
        }

        .faq-section .section-title h2 {
            font-size: 56px;
        }

        .faq-section .section-title p {
            font-size: 22px;
            padding: 0 60px;
        }

        .accordion .accordion-section {
            border-bottom: 1px solid #d3d3d3;
        }

        .accordion .accordion-section:last-child {
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .accordion .accordion-section-title {
            color: #202020;
            font-weight: bold;
            font-size: 22px;
            position: relative;
            margin: 20px 0;
            display: block;
            transition: ease 0.3s all;
        }

        .accordion .accordion-section-title.active {
            margin-bottom: 10px;
            color: #02a5e9;
            border-bottom: 1px solid #02a5e9;
            padding-bottom: 10px;
        }

        .accordion .accordion-section-title:after {
            position: absolute;
            right: 25px;
            top: 50%;
            margin-top: -3px;
            content: '';
            height: 0;
            width: 0;
            border-left: 7px solid transparent;
            border-right: 7px solid transparent;
            border-top: 7px solid #3c3c3c;
        }

        .accordion .accordion-section-title.active:after {
            border-bottom: 7px solid #02a5e9;
            border-top: 0;
            border-bottom: 7px solid #02a5e9;
        }

        .accordion-section-content {
            display: none;
        }

        .accordion-section-content p {
            font-size: 18px;
            color: #2c2c2c;
            line-height: 1.4;
        }

        .accordion .accordion-section-title:hover {
            text-decoration: none;
            color: #02a5e9;
        }

        @media (max-width:1199.98px) {
            .faq-section .section-title h2 {
                font-size: 36px;
            }
        }

        @media (max-width:768.98px) {
            .faq-section .section-title h2 {
                font-size: 28px;
            }
        }


        /*----------------------------------------------------------
            ## Bottom CTA Section
        ---------------------------------------------------------*/

        .bottom-cta-section {
            padding-top: 115px;
            padding-bottom: 115px;
            background-image: url(../../../public/images/img/home-cta-bg.png);
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
        }

        .bottom-cta-section .section-title {
            max-width: 840px;
        }

        .bottom-cta-section .section-title p {
            font-size: 22px;
        }

        @media (max-width:991.98px) {
            .bottom-cta-section {
                padding-top: 50px;
                padding-bottom: 50px;
            }
        }

        /*----------------------------------------------------------
            ## Testimonial Section
        ---------------------------------------------------------*/


        .testimonial-section figure img {
            -ms-flex-negative: 0;
            flex-shrink: 0;
        }

        .testimonial-section .item-single {
            background-color: #f9f9f9;
            border: solid 2px #dddddd;
            margin-bottom: 25px;
        }

        .testimonial-section .content {
            padding: 15px 20px;
            border-left: solid 2px #dddddd;
        }

        .testimonial-section .content p {
            margin-bottom: 10px;
        }

        .testimonial-section .content h3 {
            font-size: 18px;
        }

        .testimonial-section .border,
        .testimonial-section .border-left {
            border-color: #ddd!important;
            border-width: 2px !important;
            background-color: #f9f9f9;
        }

        .testimonial-section .border-left {
            padding: 15px 10px 15px 20px;
        }

        .testimonial-box img {
            flex-shrink: 0;
        }

        .testimonial-box h3 {
            margin-bottom: 0;
            font-size: 18px;
        }

        .testimonial-box p {
            font-size: 18px;
            line-height: 24px;
        }

        @media (max-width:991.98px) {
            .testimonial-section {
                padding-bottom: 25px;
            }
        }

        @media (max-width:767.98px) {
            .testimonial-section .content {
                border-left: none;
                border-top: solid 2px #dddddd;
            }
        }


        /*----------------------------------------------------------
            ## Treatment Section
        ---------------------------------------------------------*/

        .treatment-section {
            background-color: #e5f7ff;
        }

        .treatment-section .section-title {
            margin-bottom: 35px;
        }

        .treatment-section .item-single {
            margin-bottom: 20px;
        }

        .treatment-section .item-single .content {
            margin-top: 20px;
        }

        .treatment-section .item-single .content h5 {
            margin-bottom: 10px;
        }

        .treatment-section .item-single .content p:last-of-type {
            margin-bottom: 0;
        }

        @media (min-width:1200px) {
            .treatment-section .section-title h5 {
                padding-left: 60px;
                padding-right: 60px;
            }
        }


        /*----------------------------------------------------------
            ## Chiropractor Section
        ---------------------------------------------------------*/

        .chiropractor-section .section-title {
            margin-bottom: 35px;
        }

        .chiropractor-section .section-title p {
            padding: 0 60px;
            font-size: 22px;
        }

        .chiropractor-section p {
            font-size: 17px;
        }

        .chiropractor-section .right-container ul li:not(:last-child) {
            margin-bottom: 10px;
        }

        .chiropractor-section .certificate {
            padding: 20px;
            background-color: #f9f9f9;
        }

        .chiropractor-section .caption {
            padding: 15px;
        }

        .chiropractor-section .caption h3 {
            font-size: 22px;
            margin-bottom: 5px;
        }
        @media (max-width:1199.98px) {
            .chiropractor-section p {
                font-size: 15px;
            }
            .custom-list-arrow li {
                font-size: 15px;
            }
        }
        /*----------------------------------------------------------
            ## Free Consultation Popup
        ---------------------------------------------------------*/

        .free-consultation-popup .modal-content {
            border-radius: 0;
            border: none;
        }

        .free-consultation-popup .top-content h3 {
            font-size: 26px;
        }

        .free-consultation-popup .top-content h3:before,
        .free-consultation-popup .top-content h3:after {
            content:"\f103";
            font-family: 'FontAwesome';
            color: #fff;
            position: absolute;
            font-size: 50px;
            top: -10px;
        }

        .free-consultation-popup .top-content h3:before {
            left: 20px;
        }

        .free-consultation-popup .top-content h3:after {
            right: 20px;
        }

        .free-consultation-popup .top-content.inner-container{
            padding: 20px;
        }

        .free-consultation-popup .bottom-content.inner-container{
            padding: 30px 15px;
        }

        .free-consultation-popup .bottom-content .btn {
            max-width: 330px;
        }

        .free-consultation-popup .form-status {
            display: none;
        }

        .ui-state-active, .ui-widget-content .ui-state-active {
            border: 1px solid #02a5e9;
            background: #02a5e9;
        }

        @media (max-width:991.98px) {
            .free-consultation-popup .top-content h3 {
                font-size: 20px;
            }
            .free-consultation-popup .top-content h3:before, .free-consultation-popup .top-content h3:after {
                font-size: 30px;
                top: -5px;
            }
            .free-consultation-popup .top-content h3:before {
                left: 0px;
            }
            .free-consultation-popup .top-content h3:after {
                right: 0px;
            }
        }

        /*==========================================================
            # Appointment Confirmation Page
        ==========================================================*/

        .appointment-confirmation-banner {
            background-image: url(../../../public/images/img/banner-thankyou.png);
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            padding: 100px 0 150px;
            text-align: center;
        }

        .appointment-confirmation-banner .banner_box {
            max-width: 900px;
            margin: 0 auto;
        }

        .appointment-confirmation-banner h1 {
            font-size: 55px;
            position: relative;
            padding-bottom: 35px;
            margin-bottom: 25px;
        }

        .appointment-confirmation-banner h1 span {
            font-size: 28px;
        }

        .appointment-confirmation-banner h1:before {
            width: 180px;
            height: 5px;
            background-color: #ffdb5d;
            position: absolute;
            left: 50%;
            bottom: 0;
            content: "";
            transform: translate(-50%, 0);
            -moz-transform: translate(-50%, 0);
            -o-transform: translate(-50%, 0);
            -ms-transform: translate(-50%, 0);
            -webkit-transform: translate(-50%, 0);
        }

        .appointment-confirmation-banner p {
            font-size: 20px;
            margin-bottom: 50px;
        }

        .appointment-confirmation-banner h2 {
            font-size: 36px;
        }

        .appointment-confirmation-banner h2 span {
            margin-top: 25px;
        }

        .appointment-confirmation-banner a:hover {
            color: #fff;
        }

        @media (max-width:1500px) {
            .appointment-confirmation-banner {
                padding-top: 80px;
                padding-bottom: 130px;
            }
        }

        @media (max-width:1199.98px) {
            .appointment-confirmation-banner h1 {
                font-size: 36px;
            }

            .appointment-confirmation-banner h2 {
                font-size: 30px;
            }
        }

        @media (max-width:767.98px) {
            .appointment-confirmation-banner {
                padding-top: 40px;
                padding-bottom: 40px;
            }
            .appointment-confirmation-banner h1 {
                font-size: 28px;
            }
            .appointment-confirmation-banner h1 span {
                font-size: 22px;
            }
            .appointment-confirmation h2 {
                font-size: 22px;
            }
        }

        /*==========================================================
            # Privacy Policy Page
        ==========================================================*/

        .privacy-policy-page .inner-container h3 {
            font-size: 26px;
        }

        .counter {
            -ms-flex-negative: 0;
            flex-shrink: 0;
            width:30px;
            height: 30px;
            margin-right: 10px;
            border-radius: 100px;
            font-size: 20px;
        }

        @media (max-width:767.98px) {
            .privacy-policy-page .inner-container h3 {
                font-size: 22px;
            }
        }

        /*==========================================================
            # Order Page
        ==========================================================*/

        .order-info {
            background: #ecfaff;
            padding: 15px;
            border: 1px solid #d9d9d9;
            margin-bottom: 30px;
        }

        .order-info h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .order-info ul li {
            font-size: 14px;
        }

        .order-info ul li:not(:last-child) {
            border-bottom: 1px solid #b0d2de;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .order-info ul li:last-child {
            font-size: 16px;
        }

        .order-form {
            border: 1px solid #d9d9d9;
            padding: 30px;
            box-shadow: 0px 2px 10px -1px #ccc;
        }

        .order-form .form-title {
            font-size: 20px;
            padding-bottom: 10px;
            border-bottom: 2px dotted #c7c7c7;
            margin-bottom: 30px;
        }

        .form-control {
            padding: 15px;
            border-radius: 0;
            height: auto;
            resize: none;
        }

        .form-control.error {
            border-color: #f00;
        }

        label.error {
            color: #f00;
            padding-left: 12px;
            font-size: 14px;
            padding-top: 5px;
        }

        .order-banner {
            background-image: url(../../../public/images/img/order-banner.png);
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
        }

        .order-banner .section-title h5 {
            max-width: 650px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        .order-form .right-container .btn {
            max-width:100%;
        }

        .order-banner .video-section {
            max-width:800px;
        }

        .order-banner .video-section video {
            border: solid 2px #fff;
        }

        .scroll-down i {
            -webkit-animation: bounce 3s infinite;
            animation: bounce 3s infinite;
            font-size: 30px;
            font-size: 30px;
        }

        @-webkit-keyframes bounce {
            0% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
            }

            50% {
                -webkit-transform: translateY(20px);
                transform: translateY(20px);
            }

            100% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
            }

            50% {
                -webkit-transform: translateY(20px);
                transform: translateY(20px);
            }

            100% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
            }
        }

        @media (max-width:991.98px) {
            .form-control {
                padding: 10px;
            }
        }

        @media (max-width:767.98px) {
            .order-form {
                padding: 15px;
            }
        }

        /*==========================================================
            # Order Cancelled Page
        ==========================================================*/

        .order-cancelled-banner {
            background-image: url('../../../public/images/img/banner-01.jpg');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
        }

        .order-cancelled-content-section {
            max-width: 880px;
        }

        .order-cancelled-content-section .order-details {
            -webkit-box-shadow: 0 0 8px #c1c1c1;
            box-shadow: 0 0 8px #c1c1c1;
        }

        .order-cancelled-content-section .order-details h2 {
            padding: 20px;
        }

        .order-cancelled-content-section .order-details .products {
            padding-left: 30px;
            padding-right: 30px;
        }

        .order-cancelled-content-section .order-details .products tr th {
            border-bottom: 1px solid #cccccc;
            font-size: 20px;
        }

        .order-cancelled-content-section .order-details .products tr td {
            font-size: 18px;
        }

        .order-cancelled-content-section .order-details .products tr th,
        .order-cancelled-content-section .order-details .products tr td {
            padding: 20px;
        }

        .order-cancelled-content-section .order-details .products tr th:last-child,
        .order-cancelled-content-section .order-details .products tr td:last-child {
            text-align: right;
        }

        @media (max-width:1199.98px) {
            .order-cancelled-content-section .order-details h2 {
                font-size: 26px;
            }
        }

        @media (max-width:991.98px) {
            .section-title h5 {
                font-size: 18px;
            }
            .order-cancelled-content-section .order-details h2 {
                font-size: 22px;
            }
        }

        @media (max-width:767.98px) {
            .order-cancelled-content-section .order-details .products tr th {
                font-size: 16px;
            }
            .order-cancelled-content-section .order-details .products tr td {
                font-size: 14px;
            }

            .order-cancelled-content-section .order-details .products tr th,
            .order-cancelled-content-section .order-details .products tr td {
                padding: 15px;
            }

            .order-cancelled-content-section .order-details .products {
                padding-left: 15px;
                padding-right: 15px;
            }
        }

        /*==========================================================
            # Thank You Page
        ==========================================================*/

        .thank-you-banner {
            background-image: url('../../../public/images/img/banner-01.jpg');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
        }

        .thank-you-banner .section-title h5 {
            max-width: 650px;
            width: 100%;
        }

        .thank-you-content-section {
            max-width: 880px;
        }

        .thank-you-content-section .order-details {
            -webkit-box-shadow: 0 0 8px #c1c1c1;
            box-shadow: 0 0 8px #c1c1c1;
        }

        .thank-you-content-section .order-details h2 {
            padding: 20px;
        }

        .thank-you-content-section .order-details .products {
            padding-left: 30px;
            padding-right: 30px;
        }

        .thank-you-content-section .order-details .products tr th {
            border-bottom: 1px solid #cccccc;
            font-size: 20px;
        }

        .thank-you-content-section .order-details .products tr td {
            font-size: 18px;
        }

        .thank-you-content-section .order-details .products tr th,
        .thank-you-content-section .order-details .products tr td {
            padding: 20px;
        }

        .thank-you-content-section .order-details .products tr th:last-child,
        .thank-you-content-section .order-details .products tr td:last-child {
            text-align: right;
        }

        @media (max-width:1199.98px) {
            .thank-you-content-section .order-details h2 {
                font-size: 26px;
            }
        }

        @media (max-width:991.98px) {
            .thank-you-content-section .order-details h2 {
                font-size: 22px;
            }
        }

        @media (max-width:767.98px) {
            .thank-you-content-section .order-details .products tr th {
                font-size: 16px;
            }
            .thank-you-content-section .order-details .products tr td {
                font-size: 14px;
            }

            .thank-you-content-section .order-details .products tr th,
            .thank-you-content-section .order-details .products tr td {
                padding: 15px;
            }

            .thank-you-content-section .order-details .products {
                padding-left: 15px;
                padding-right: 15px;
            }

            .thank-you-content-section .order-details h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
<!--// Header \\-->
<header class="fixed-top bg-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="inner-container d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">
{{--                    <div class="">--}}
                        {{--                            @if(empty($userData['business'][0]['avatar']))--}}
                        @if(empty($userData['business'][0]['logo']))
{{--                            <img style="width: 35px;height: 35px;border-radius: 35px;" src="{{ asset('public/images/icons/doc.jpg') }}" />--}}
                            <a class="navbar-brand" href="{{route('home')}}">
                                <img src="{{asset('public/images/img/logo-dark.svg')}}" alt="Chiropractic - Care for Back Pain" class="img-fluid">
                            </a>
                        @else
{{--                            <img class="has-avatar"  style="width: 35px;height: 35px;border-radius: 35px;" src="{!! uploadImagePath($userData['business'][0]['avatar']) !!}" />--}}
                            <a class="navbar-brand" href="{{route('home')}}">
                                <img class="has-avatar img-fluid" src="{!! uploadImagePath($userData['business'][0]['logo']) !!}" />
                            </a>
                        @endif
{{--                    </div>--}}

                    <p class="mb-0 mt-2 mt-md-0 text-center text-md-right"><span class="font-weight-bold text-blue">GET RELIEF NOW : </span>CALL TODAY: (XXX) XXX-XXXX</p>
                </div>
            </div>
        </div>
    </div>
</header>
<!--\\ Header //-->
<!--// Main \\-->
<main>
    <!--// Hero Section \\-->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-xl-8 text-center">
                    <h1 class="text-uppercase text-blue font-weight-bold mb-0">Chiropractic</h1>
                    <h2 class="font-weight-medium d-inline-block">Care for Back Pain</h2>
                    <p><span class="font-weight-bold text-underline">Chiropractic adjustment</span> is a procedure in which trained <span class="font-weight-bold text-underline">specialists</span> (chiropractors) use their hands or a small instrument to apply a controlled, sudden force to a spinal joint. The goal of this procedure, also known as spinal manipulation, is to <span class="font-weight-bold text-underline">improve spinal motion</span> and improve your body's physical function.</p>
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#freeConsultation" class="btn btn-orange d-inline-flex flex-column position-relative">
                        <span class="text-uppercase font-weight-bold title">Request a free Consultation </span>
                        <span class="text-capitalize font-weight-regular sub-title">You Don't Have To Suffer Anymore...</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!--\\ Hero Section //-->
    <!--// Benefits Section \\-->
    <section class="benefits-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-title">
                        <h2 class="font-weight-bold text-yellow">Chiropractors use hands-on spinal manipulation and other alternative treatments.</h2>
                        <h5 class="text-white font-weight-regular">Chiropractic treatment is primarily used as a <span class="font-weight-bold text-underline">pain relief alternative for muscles, joints, bones, and connective tissue,</span> such as cartilage, ligaments, and tendons. It is sometimes used i conjunction with conventional medical treatment.</h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="inner-container left-container">
                        <figure class="text-center"> <img src="{{asset('public/images/img/benefits_01.png')}}" alt="100% Natural" class="img-fluid"> </figure>
                        <div class="content text-center px-4">
                            <h5 class="text-uppercase text-yellow font-weight-bold">100% Natural</h5>
                            <p class="text-white mb-0">Medication-free remedies trigger healing mechanisms...</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="inner-container center-container">
                        <figure class="text-center"> <img src="{{asset('public/images/img/benefits_02.png')}}" alt="Rapid Relief" class="img-fluid"> </figure>
                        <div class="content text-center px-4">
                            <h5 class="text-uppercase text-yellow font-weight-bold">Rapid Relief</h5>
                            <p class="text-white mb-0">Begin seeing results as soon as the first treatment session...</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="inner-container right-container">
                        <figure class="text-center"> <img src="{{asset('public/images/img/benefits_03.png')}}" alt="Covered Visits" class="img-fluid"> </figure>
                        <div class="content text-center px-4">
                            <h5 class="text-uppercase text-yellow font-weight-bold">Covered Visits</h5>
                            <p class="text-white mb-0">Most insurance plans accepted through major providers...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--\\ Benefits Section //-->
    <!--// Improve Section \\-->
    <section class="improve-section section-spacer">
        <div class="container">
            <div class="row">
                <div class="col-12 order-2 order-lg-1 col-lg-6 mt-5 mt-lg-0">
                    <div class="inner-container left-container">
                        <ul>
                            <li>
										<span class="d-flex align-items-start">
											<img src="{{asset('public/images/img/home-03-01.png')}}" alt="IMPROVE YOUR POSTURE" class="img-fluid">
											<span class="d-flex flex-column">
												<h3 class="text-uppercase ">IMPROVE YOUR <span class="text-blue font-weight-bold">POSTURE</span></h3>
												<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel aliquet nulla. Aliquam sceleris consectetur adipiscing elit. Suspendisse vel aliquet nulla. Aliquam sceleris</p>
											</span>
										</span>
                            </li>
                            <li>
										<span class="d-flex align-items-start">
											<img src="{{asset('public/images/img/home-03-02.png')}}" alt="IMPROVE YOUR HEALTH" class="img-fluid">
											<span class="d-flex flex-column">
												<h3 class="text-uppercase ">IMPROVE YOUR <span class="text-blue font-weight-bold">HEALTH</span></h3>
												<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel aliquet nulla. Aliquam sceleris consectetur adipiscing elit. Suspendisse vel aliquet nulla. Aliquam sceleris</p>
											</span>
										</span>
                            </li>
                            <li>
										<span class="d-flex align-items-start">
											<img src="{{asset('public/images/img/home-03-03.png')}}" alt="IMPROVE YOUR LIFE" class="img-fluid">
											<span class="d-flex flex-column">
												<h3 class="text-uppercase ">IMPROVE YOUR <span class="text-blue font-weight-bold">LIFE</span></h3>
												<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel aliquet nulla. Aliquam sceleris consectetur adipiscing elit. Suspendisse vel aliquet nulla. Aliquam sceleris</p>
											</span>
										</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 order-1 order-lg-2 col-lg-6">
                    <div class="inner-container right-container">
                        <figure class="text-center mb-0"> <img src="{{asset('public/images/img/home-031-2.png')}}" alt="IMPROVE YOUR LIFE" class="img-fluid"> </figure>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--\\ Improve Section //-->
    <!--// CTA Section \\-->
    <section class="cta-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-title mx-auto">
                        <h2 class="text-capitalize text-white font-weight-bold d-inline-block position-relative">So Why are You <span class="text-underline">Suffering From Back Pain?</span></h2>
                        <h5 class="text-white font-weight-regular mx-auto">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel aliquet nulla. Aliquam sceleris consectetur adipiscing elit. Suspendisse vel aliquet nulla. Aliquam sceleris consectetur adipiscing elit. Suspendisse vel aliquet nulla. Aliquam sceleris </h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="inner-container text-center">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#freeConsultation" class="btn btn-orange btn-hover-white d-inline-flex flex-column position-relative"> <span class="text-uppercase font-weight-bold title">Request a free Consultation </span> <span class="text-capitalize font-weight-regular sub-title">You Don't Have To Suffer Anymore...</span> </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--\\ CTA Section //-->
    <!--// Chiropractors Section \\-->
    <section class="chiropractor-section section-alt-spacer">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-title">
                        <h2 class=" text-capitalize font-weight-bold">Chiropractors: Fundamental Beliefs and Goals</h2>
                        <h5 class="font-weight-regular">Lorem ipsum dolor sit amet, consectetur <span class="font-weight-bold text-underline">adipiscing elit. Sed non enim lectus.</span> Aenean ex, <span class="font-weight-bold text-underline">condimentum in neque et,</span> scelerisque fringilla elit. Vestibulum massa quam</h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-7">
                    <div class="inner-container left-container">
                        <video width="100%" height="auto" poster="{{asset('public/images/img/home-05.png')}}" controls>
                            <source src="https://webdevproof.com/click-funnel-videos/video.mp4" type="video/mp4">
                            <source src="https://webdevproof.com/click-funnel-videos/video.webm" type="video/webm">
                        </video>
                    </div>
                </div>
                <div class="col-12 col-lg-5 mt-4 mt-lg-0">
                    <div class="inner-container right-container">
                        <p>Sed mattis mi a pharetra venenatis. In vestibulum, nibh nec finibus cursus, enim sem molestie eros, et ultricies enim arcu vel tellus. Ut imperdiet nec finibus cursus, enim sem molestie eros, et ultricies enim arcu vel tellus. Ut imperdiet
                        </p>
                        <ul class="mb-0 custom-list-arrow">
                            <li>Ut tempus turpis quis diam egestas rutrum.</li>
                            <li>Aenean non semper lorem.</li>
                            <li>Aliquam bibendum ex vulputate</li>
                            <li>Tortor posuere, nec auctor ipsum auctor</li>
                            <li>sed, porta mauris. In aliquet</li>
                            <li>sed ultricies erat est id</li>
                        </ul>
                    </div>
                </div>
                <div class="col-12">
                    <p class="mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur laoreet tincidunt ante, quis eleifend arcu. Cras ut facilisis dui. Vivamus congue, massa id luctus convallis, mauris leo faucibus metus, efficitur vestibulum lectus sem eget eros. Praesent tincidunt nulla ac tellus dignissim, aliquam blandit orci tristique. Quisque feugiat, massa ac vehicula convallis, libero lorem imperdiet ligula, a convallis odio arcu vitae tortor. In feugiat risus ac purus euismod feugiat. Donec a pharetra metus.</p>
                    <p class="mb-4">Proin placerat vestibulum aliquet. Donec ac sagittis urna, eu vestibulum augue. Nunc gravida sollicitudin dolor condimentum faucibus. Donec commodo nulla eu efficitur maximus. Vivamus eget massa congue, sagittis magna at, placerat magna.</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="inner-container certificate border">
                        <div class="row">
                            <div class="col-12 col-lg-5">
                                <div class="left-container">
                                    <figure class="text-center mb-0">
                                        <img src="{{asset('public/images/img/certificate.png')}}" alt="John Doe" class="img-fluid">
                                    </figure>
                                    <div class="caption bg-blue text-center">
                                        <h3 class="font-weight-bold text-white">
                                            John Doe
                                        </h3>
                                        <p class="text-white mb-0">
                                            Board Certified Chiropractor
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7 mt-4 mt-lg-0">
                                <div class="right-container">
                                    <p>Sed mattis mi a pharetra venenatis. In vestibulum, nibh nec finibus cursus, enim sem molestie eros, et ultricies enim arcu vel tellus. Ut imperdiet nec finibus cursus, enim sem molestie eros, et ultricies enim arcu vel tellus. Ut imperdiet
                                    </p>
                                    <ul class="mb-0 custom-list-blue">
                                        <li><strong>Qualified:</strong> Certified Chiropractors with 70+ years total experience...</li>
                                        <li><strong>Effective:</strong>​ High quality treatments trigger rapid healing...</li>
                                        <li><strong>Safe:</strong> Proper procedures used to minimize future damage...</li>
                                        <li><strong>​Trusted:</strong> Recommended by hundreds of happy clients...</li>
                                        <li><strong>​Local:</strong> Local: Healing [Boise] area residents for 40+ years...</li>
                                        <li><strong>​Preferred Provider:</strong> ​Preferred Provider: Working with insurance companies to reduce or eliminate your out of pocket costs...</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!--\\ Chiropractors Section //-->
    <!--// Treatment Section \\-->
    <section class="treatment-section section-alt-spacer">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-title">
                        <h2 class=" text-capitalize font-weight-bold">Effective Treatment Therapies</h2>
                        <h5 class="font-weight-regular">Lorem ipsum dolor sit amet, consectetur <span class="font-weight-bold text-underline">adipiscing elit. Sed non enim lectus.</span> Aenean ex, <span class="font-weight-bold text-underline">condimentum in neque et,</span> scelerisque fringilla elit. Vestibulum massa quam</h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="inner-container item-single">
                        <figure class="text-center mb-0"> <img src="{{asset('public/images/img/home-06-1.png')}}" alt="100% Natural" class="img-fluid"> </figure>
                        <div class="content text-center">
                            <h5 class="text-uppercase font-weight-bold">ADJUSTMENTS</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur laoreet tincidunt</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="inner-container item-single">
                        <figure class="text-center mb-0"> <img src="{{asset('public/images/img/home-06-02.png')}}" alt="Rapid Relief" class="img-fluid"> </figure>
                        <div class="content text-center">
                            <h5 class="text-uppercase font-weight-bold">LASER THERAPY</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur laoreet tincidunt</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="inner-container item-single">
                        <figure class="text-center mb-0"> <img src="{{asset('public/images/img/home-06-03.png')}}" alt="Covered Visits" class="img-fluid"> </figure>
                        <div class="content text-center">
                            <h5 class="text-uppercase font-weight-bold">MASSAGE</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur laoreet tincidunt</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="inner-container item-single">
                        <figure class="text-center mb-0"> <img src="{{asset('public/images/img/home-06-04.png')}}" alt="Covered Visits" class="img-fluid"> </figure>
                        <div class="content text-center">
                            <h5 class="text-uppercase font-weight-bold">REVERSE GRAVITY</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur laoreet tincidunt</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <div class="inner-container text-center bottom-content">
                        <h3 class="text-uppercase text-blue font-weight-bold mb-4">
                            BEGIN RELIEVING YOUR PAIN TODAY
                        </h3>
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#freeConsultation" class="btn btn-orange d-inline-flex flex-column position-relative"> <span class="text-uppercase font-weight-bold title">Request a free Consultation </span> <span class="text-capitalize font-weight-regular sub-title">You Don't Have To Suffer Anymore...</span> </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--\\ Treatment Section //-->
    <!--// Testimonial Section \\-->
    <section class="testimonial-section section-equal-spacer">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-title">
                        <h2 class="text-capitalize font-weight-bold mb-0">What Our Patient Are Saying</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-0">
                    <div class="item-single d-flex flex-column flex-md-row">
                        <figure class="mb-0 flex-shrink-0">
                            <img src="{{asset('public/images/img/testimonial-01.png')}}" alt="JOHN DOE" class="w-100">
                        </figure>
                        <div class="content">
                            <p class="font-italic">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non felis consectetur, convallis massa vel, pulvinar massa. Morbi quis est odio. Aenean accumsan tincidunt tincidunt.</p>
                            <h3 class="text-uppercase font-weight-bold mb-0">JOHN DOE</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-0">
                    <div class="item-single d-flex flex-column flex-md-row">
                        <figure class="mb-0 flex-shrink-0">
                            <img src="{{asset('public/images/img/testimonial-02.png')}}" alt="JOHN DOE" class="w-100">
                        </figure>
                        <div class="content">
                            <p class="font-italic">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non felis consectetur, convallis massa vel, pulvinar massa. Morbi quis est odio. Aenean accumsan tincidunt tincidunt.</p>
                            <h3 class="text-uppercase font-weight-bold mb-0">JOHN DOE</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-0">
                    <div class="item-single d-flex flex-column flex-md-row">
                        <figure class="mb-0 flex-shrink-0">
                            <img src="{{asset('public/images/img/testimonial-03.png')}}" alt="JOHN DOE" class="w-100">
                        </figure>
                        <div class="content">
                            <p class="font-italic">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non felis consectetur, convallis massa vel, pulvinar massa. Morbi quis est odio. Aenean accumsan tincidunt tincidunt.</p>
                            <h3 class="text-uppercase font-weight-bold mb-0">JOHN DOE</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-0">
                    <div class="item-single d-flex flex-column flex-md-row">
                        <figure class="mb-0 flex-shrink-0">
                            <img src="{{asset('public/images/img/testimonial-04.png')}}" alt="JOHN DOE" class="w-100">
                        </figure>
                        <div class="content">
                            <p class="font-italic">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non felis consectetur, convallis massa vel, pulvinar massa. Morbi quis est odio. Aenean accumsan tincidunt tincidunt.</p>
                            <h3 class="text-uppercase font-weight-bold mb-0">JOHN DOE</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--\\ Testimonial //-->
    <!--// FAQ Section \\-->
    <section class="faq-section section-alt-spacer">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-title">
                        <h2 class="text-uppercase font-weight-bold">HAVE QUESTIONS? LOOK HERE.</h2>
                        <h5 class="font-weight-regular">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque imper diet augue sed elit convallis, at auctor velit aliquam.</h5>
                    </div>
                </div>
                <div class="col-12">
                    <div class="accordion">
                        <div class="accordion-section">
                            <a class="accordion-section-title active " href="#accordion-1">What is the registration process?</a>
                            <div id="accordion-1" class="accordion-section-content open" style="display: block;">
                                <p>Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet.</p>
                            </div>
                        </div>
                        <div class="accordion-section">
                            <a class="accordion-section-title " href="#accordion-2">Which payment methods do you accept?</a>
                            <div id="accordion-2" class="accordion-section-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet.</p>
                            </div>
                        </div>
                        <div class="accordion-section">
                            <a class="accordion-section-title " href="#accordion-3">Integer ultricies lectus egestas eros cursus semper.</a>
                            <div id="accordion-3" class="accordion-section-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet.</p>
                            </div>
                        </div>
                        <div class="accordion-section">
                            <a class="accordion-section-title " href="#accordion-4">Fusce id sem ac felis aliquam malesuada sed eu enim.</a>
                            <div id="accordion-4" class="accordion-section-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet.</p>
                            </div>
                        </div>
                        <div class="accordion-section">
                            <a class="accordion-section-title " href="#accordion-5">Fusce id sem ac felis aliquam malesuada sed eu enim.</a>
                            <div id="accordion-5" class="accordion-section-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet, consectetur adipis. Maec enas id nibh non. Lorem ipsum dolor sit amet.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--// FAQ Section \\-->
    <!--// Bottom CTA Section \\-->
    <section class="bottom-cta-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-title mx-auto">
                        <h2 class="text-capitalize text-white font-weight-bold">So Why are You <span class="text-underline">Suffering From Back Pain?</span></h2>
                        <p class="text-white mt-4 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel aliquet nulla. Aliquam sceleris consectetur adipiscing elit. Suspendisse vel aliquet nulla. Aliquam sceleris consectetur adipiscing elit. Suspendisse vel aliquet nulla. Aliquam sceleris</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="inner-container text-center">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#freeConsultation" class="btn btn-orange btn-hover-white d-inline-flex flex-column position-relative"> <span class="text-uppercase font-weight-bold title">Request a free Consultation </span> <span class="text-capitalize font-weight-regular sub-title">You Don't Have To Suffer Anymore...</span> </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--\\ Bottom CTA Section //-->
</main>
<!--\\ Main //-->
<!--// Footer Section \\-->
<footer>
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="logo mx-auto mb-3">
                    <div class="avatar-icon">
                        {{--                            @if(empty($userData['business'][0]['avatar']))--}}
                        @if(empty($userData['business'][0]['logo']))
                            {{--                            <img style="width: 35px;height: 35px;border-radius: 35px;" src="{{ asset('public/images/icons/doc.jpg') }}" />--}}
                            <a class="navbar-brand" href="{{route('home')}}">
                                <img src="{{asset('public/images/img/logo-light.svg')}}" alt="Chiropractic - Care for Back Pain" class="img-fluid">
                            </a>
                        @else
                            {{--                                <img class="has-avatar"  style="width: 35px;height: 35px;border-radius: 35px;" src="{!! uploadImagePath($userData['business'][0]['avatar']) !!}" />--}}
                            <a class="navbar-brand" href="{{route('home')}}">
                                <img class="has-avatar img-fluid" src="{!! uploadImagePath($userData['business'][0]['logo']) !!}" />
                            </a>
                        @endif
                    </div>
{{--                    <img src="{{asset('public/images/img/logo-light.svg')}}" alt="Diee Mass - Chiropractic Care" class="img-fluid">--}}
                </div>
                <p>* Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fringilla consectetur metus at scelerisque. Nam mattis felis quis sollicitudin cursus. Suspendisse potenti. Vestibulum ante ipsum primis in faucibus orci luctus.</p>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="privacy-policy.html" class="text-white">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="terms-and-conditions.html" class="text-white">Terms & Conditions</a></li>
                </ul>
                <p>© Copyright 2020 YourBrand.com-All rights reserved</p>
            </div>
        </div>
    </div>
</footer>
<!-- \\ Footer Section // -->
<!--// Free Consultation Popup \\-->
<div class="modal fade free-consultation-popup" id="freeConsultation" tabindex="-1" aria-labelledby="freeConsultationLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col">
                            <div class="inner-container top-content bg-blue">
                                <h3 class="font-weight-bold text-uppercase position-relative text-center text-white">SCHEDULE YOUR FREE CONSULTATION TODAY</h3>
                                <p class="text-center text-white mb-0">Complete the form below to schedule your appointment...</p>
                            </div>
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col">
                            <div class="inner-container bottom-content">
                                <div class="form-status"></div>
                                <form id="consultationForm">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" name="first_name" placeholder="First Name *" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" name="last_name" placeholder="Last Name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="tel" class="form-control" name="phone" placeholder="Phone *" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="email" class="form-control" name="email" placeholder="Email *" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" name="appointment_day" placeholder="Appointment Day *" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" name="appointment_time" placeholder="Appointment Time *" required>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <textarea class="form-control" name="issue" rows="3" placeholder="Tell Us About Your Neck or Back Issue *" required></textarea>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-orange mx-auto mt-3">
                                            <span class="text-uppercase font-weight-bold title">Submit</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--\\ Free Consultation Popup //-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
{{--<script src="assets/plugins/jquery/jquery.min.js"></script>--}}
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
{{--<script src="assets/plugins/bootstrap/bootstrap.min.js"></script>--}}
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<!-- Jquery Validate JS -->
{{--<script src="assets/plugins/validate/validate.min.js"></script>--}}
{{--<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
<!-- Jquery UI -->
{{--<script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
<!-- Timepicker -->
{{--<script src="assets/plugins/jquery-ui/timepicker.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.16/jquery.timepicker.min.js" integrity="sha512-huX0hcUeIkgR0QvTlhxNpIAcwiN2sABe3VwyzeZAYjMPn3OU71t9ZLlk6qs27Q049SPgeB/Az12jv/ayedXoAw==" crossorigin="anonymous"></script>
<!-- Custom JS -->
<script src="assets/js/main.js"></script>
<script>
    $(document).ready(function () {
        /*==================================================
            FAQ Section
        ==================================================*/
        function close_accordion_section() {
            $('.accordion .accordion-section-title').removeClass('active');
            $('.accordion .accordion-section-content').slideUp(300).removeClass('open');
        }

        $('.accordion-section-title').click(function (e) {
            // Grab current anchor value
            var currentAttrValue = $(this).attr('href');

            if ($(e.target).is('.active')) {
                close_accordion_section();
            } else {
                close_accordion_section();

                // Add active class to section title
                $(this).addClass('active');
                // Open up the hidden content panel
                $('.accordion ' + currentAttrValue).slideDown(300).addClass('open');
            }
            e.preventDefault();
        });

        /*==================================================
            Order Form
        ==================================================*/

        if ($("#orderform").length) {
            $("#orderform").validate({
                errorPlacement: function(error,element) {
                    return true;
                },
                rules: {
                    first_name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    shipping_address: {
                        required: true,
                    },
                    city: {
                        required: true,
                    },
                    state: {
                        required: true,
                    },
                    zip: {
                        required: true,
                    },
                    country: {
                        required: true,
                    }
                },
                submitHandler: function (form) {
                    var formdata = jQuery("#orderform").serialize();
                    $.ajax({
                        type: "POST",
                        url: 'assets/php/order-form.php',
                        data: formdata,
                        dataType: 'json',
                        async: false,
                        success: function (data) {
                            if (data.success) {
                                $('.form-status').addClass('alert alert-success');
                                $('.form-status').text('Your Message Has been Sent Successfully');
                                $('.form-status').slideDown().delay(3000).slideUp();
                                form.submit();
                            } else {
                                $('.form-status').addClass('alert alert-danger');
                                $('.form-status').text('Error Occurred, Please Try Again');
                                $('.form-status').slideDown().delay(3000).slideUp();
                            }
                        },
                        error: function (error) {
                            $('.form-status').addClass('alert alert-danger');
                            $('.form-status').text('Something Went Wrong');
                            $('.form-status').slideDown().delay(3000).slideUp();
                        }
                    });
                }
            });
        }

        /*==================================================
            Consultation Form
        ==================================================*/

        if ($("input[name='appointment_day']").length) {
            $( "input[name='appointment_day']" ).datepicker();
        }
        if ($("input[name='appointment_time']").length) {
            $("input[name='appointment_time']").timepicker();
        }

        if ($("#consultationForm").length) {
            $("#consultationForm").validate({
                errorPlacement: function(error,element) {
                    return true;
                },
                rules: {
                    first_name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    appointment_day: {
                        required: true,
                    },
                    appointment_time: {
                        required: true,
                    },
                    issue: {
                        required: true,
                    },
                },
                submitHandler: function(form) {
                    var formData = $('#consultationForm').serialize();
                    $.ajax({
                        type: 'POST',
                        url: 'assets/php/popup-form.php',
                        dataType: "json",
                        data: formData,
                        success: function (data) {
                            if (data.success) {
                                $('.form-status').addClass('alert alert-success');
                                $('.form-status').text('Your Message Has been Sent Successfully');
                                form.submit();
                                $('.form-status').slideDown().delay(3000).slideUp();
                                $("#consultationForm").trigger("reset");
                                window.location.href = 'https://webdevproof.com/theme-forest-demo/funnel-templates/chiropractic-care/appointment-confirmation.html';
                            } else {
                                $('.form-status').addClass('alert alert-danger');
                                $('.form-status').text('Error Occurred, Please Try Again');
                                $('.form-status').slideDown().delay(3000).slideUp();
                            }
                        },
                        error: function (xhr, status, error) {
                            $('.form-status').addClass('alert alert-danger');
                            $('.form-status').text('Something Went Wrong');
                            $('.form-status').slideDown().delay(3000).slideUp();
                        }
                    });
                }
            });
        }


    });
</script>
</body>
</html>
