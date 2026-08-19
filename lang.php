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
        'page_title' => 'Моя Лаба',
        'nav_home' => 'Главная',

        'hero_title' => 'Gaan Dmitry Lab',
        'btn_send_photo' => 'Оставить заявку',

        'section_upload_title' => 'Оставить заявку',
        'upload_desc' => 'Прикрепите ссылку на ваш материал.',

        'label_email' => 'Ваш Email',
        'ph_email' => 'example@mail.com',
        'label_link' => 'Ссылка на файлы (Google Drive, Яндекс.Диск)',
        'ph_link' => 'https://...',
        'label_comments' => 'Пожелания (опционально)',
        'ph_comments' => 'Опишите задачу...',
        'btn_submit_retouch' => 'Отправить заявку',
        'submit_available_in' => 'Отправка доступна через',

        'footer_about' => 'Обо мне',
        'footer_about_desc' => 'Моя персональная лаборатория и якорный сайт.',
        'footer_nav' => 'Навигация',
        'footer_contacts' => 'Контакты',
        'footer_socials' => 'Соц. сети',
        'footer_rights' => 'Gaan Dmitry Lab. Все права защищены.',
    ],
    'en' => [
        'page_title' => 'My Lab',
        'nav_home' => 'Home',

        'hero_title' => 'Gaan Dmitry Lab',
        'btn_send_photo' => 'Submit Request',

        'section_upload_title' => 'Submit Request',
        'upload_desc' => 'Attach a link to your material.',

        'label_email' => 'Your Email',
        'ph_email' => 'example@mail.com',
        'label_link' => 'Source Link (Google Drive, Dropbox)',
        'ph_link' => 'https://...',
        'label_comments' => 'Wishes (optional)',
        'ph_comments' => 'Describe your task...',
        'btn_submit_retouch' => 'Submit Request',
        'submit_available_in' => 'Submit available in',

        'footer_about' => 'About Me',
        'footer_about_desc' => 'My personal laboratory and anchor site.',
        'footer_nav' => 'Navigation',
        'footer_contacts' => 'Contacts',
        'footer_socials' => 'Social Networks',
        'footer_rights' => 'Gaan Dmitry Lab. All rights reserved.',
    ]
];

function t($key) {
    global $translations, $current_lang;
    return isset($translations[$current_lang][$key]) ? $translations[$current_lang][$key] : $key;
}
?>