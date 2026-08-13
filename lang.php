<?php
session_start();

if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    if (in_array($lang, ['ru', 'en'])) {
        $_SESSION['lang'] = $lang;
    }
}

$current_lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'ru';

$translations = [
    'ru' => [
        'page_title' => 'Профессиональная фоторетушь',
        'nav_home' => 'Главная',
        'nav_portfolio' => 'Портфолио',

        'hero_title' => 'Взглянем на ваши снимки <span>иначе</span>',
        'hero_subtitle' => '🎁 Бесплатная профессиональная ретушь до 01.11.2026. Загрузите свой исходник, и я покажу, на что он способен!',
        'btn_send_photo' => 'Отправить фото',
        'btn_view_portfolio' => 'Смотреть портфолио',

        'section_upload_title' => 'Оставить заявку',
        'upload_desc' => 'Прикрепите ссылку на облако с RAW/TIFF файлами (можно загрузить целую папку). Я сам отсмотрю материал и выберу от 1 до 3 лучших кадров для глубокой ретуши.',

        'label_email' => 'Ваш Email (туда придет результат)',
        'ph_email' => 'example@mail.com',
        'label_link' => 'Ссылка на исходник (Google Drive, Яндекс.Диск)',
        'ph_link' => 'https://...',
        'label_comments' => 'Пожелания (опционально)',
        'ph_comments' => 'Что бы вы хотели изменить?',
        'btn_submit_retouch' => 'Отправить на ретушь',
        'submit_available_in' => 'Отправка доступна через',

        'footer_about' => 'Обо мне',
        'footer_about_desc' => 'Профессиональная фоторетушь и цветокоррекция. Делаю ваши снимки ярче, выразительнее и стильнее. Индивидуальный подход к каждому кадру.',
        'footer_nav' => 'Навигация',
        'footer_contacts' => 'Контакты',
        'footer_socials' => 'Соц. сети',
        'footer_rights' => 'Профессиональная фоторетушь. Все права защищены.',

        'portfolio_title' => 'Портфолио - Фоторетушь',
        'portfolio_h1' => 'Мои работы',
        'portfolio_subtitle' => 'Примеры профессиональной ретуши',
        'portfolio_back' => '&larr; На главную',
        'portfolio_empty' => 'В портфолио пока нет работ. Они скоро появятся!',
    ],
    'en' => [
        'page_title' => 'Professional Photo Retouching',
        'nav_home' => 'Home',
        'nav_portfolio' => 'Portfolio',

        'hero_title' => 'Let\'s look at your shots <span>differently</span>',
        'hero_subtitle' => '🎁 Free professional retouching until Nov 1, 2026. Upload your source file, and I will show what it\'s capable of!',
        'btn_send_photo' => 'Send Photo',
        'btn_view_portfolio' => 'View Portfolio',

        'section_upload_title' => 'Submit Request',
        'upload_desc' => 'Attach a link to cloud storage with RAW/TIFF files (you can upload a whole folder). I will review the material and choose 1 to 3 best shots for deep retouching.',

        'label_email' => 'Your Email (results will be sent here)',
        'ph_email' => 'example@mail.com',
        'label_link' => 'Source Link (Google Drive, Dropbox)',
        'ph_link' => 'https://...',
        'label_comments' => 'Wishes (optional)',
        'ph_comments' => 'What would you like to change?',
        'btn_submit_retouch' => 'Submit for Retouching',
        'submit_available_in' => 'Submit available in',

        'footer_about' => 'About Me',
        'footer_about_desc' => 'Professional photo retouching and color correction. I make your shots brighter, more expressive, and stylish. Individual approach to every frame.',
        'footer_nav' => 'Navigation',
        'footer_contacts' => 'Contacts',
        'footer_socials' => 'Social Networks',
        'footer_rights' => 'Professional Photo Retouching. All rights reserved.',

        'portfolio_title' => 'Portfolio - Photo Retouching',
        'portfolio_h1' => 'My Works',
        'portfolio_subtitle' => 'Examples of professional retouching',
        'portfolio_back' => '&larr; Back to Home',
        'portfolio_empty' => 'There are no works in the portfolio yet. They will appear soon!',
    ]
];

function t($key) {
    global $translations, $current_lang;
    return isset($translations[$current_lang][$key]) ? $translations[$current_lang][$key] : $key;
}
?>