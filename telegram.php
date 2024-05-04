<?php
include (__DIR__ . '/vendor/autoload.php');
$telegram = new Telegram('token');
$text = $telegram->Text();
$data = $telegram->getData();

$lang = $data['message']['from']['language_code'];
$name = $data['message']['from']['first_name'];
$username = $data['message']['from']['username'];
    
    switch ($text) {
        case 'Libs':
            $text = getLibs();
            say($text, $telegram);
        break;

        case 'Services':
            $text = getServices();
            say($text, $telegram);
        break;

        case 'Contacts':
            $text = getContacts();
            say($text, $telegram);
        break;

        case 'CV':
            $file = curl_file_create('../cv_rus.pdf', 'document/pdf'); 
            send_document($file, $telegram);
            $file = curl_file_create('../cv.pdf', 'document/pdf'); 
            send_document($file, $telegram);
        break;
        
        default:
            $reply = getStart($name, $telegram);
            $file = curl_file_create('../assets/img/logo_256.jpg', 'image/jpg'); 
            send_image($file, $telegram);
            say_with_buttons($reply['text'], $reply['buttons'], $telegram);
        break;
    }

// methods:

function say($reply, $telegram) {
    $chat_id = $telegram->ChatID();
    $content = ['chat_id' => $chat_id, 'text' => $reply, 'parse_mode' => 'HTML'];
    $telegram->sendMessage($content);
}

function say_with_buttons($reply, $buttons, $telegram) {
    $chat_id = $telegram->ChatID();
    $keyb = $telegram->buildKeyBoard($buttons, $onetime=false, $resize=true, $selective=true);
    $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply];
    $telegram->sendMessage($content);
}

function send_image($file, $telegram) {
    $chat_id = $telegram->ChatID();
    $content = ['chat_id' => $chat_id, 'photo' => $file];
    $telegram->sendPhoto($content);
}

function send_document($file, $telegram) {
    $chat_id = $telegram->ChatID();
    $content = ['chat_id' => $chat_id, 'document' => $file];
    $telegram->sendDocument($content);
}

// =========

// answers:

function getStart($username, $telegram) {
    $buttons = [ 
        [
            $telegram->buildKeyboardButton("Services"),
            $telegram->buildKeyboardButton("Libs"),  
            $telegram->buildKeyboardButton("CV"),
            $telegram->buildKeyboardButton("Contacts")
        ] 
    ];
    $text = "Hello, $username, I hope you are doing well.
Click on the buttons under the input field for an additional info.";
    return ['text' => $text, 'buttons' => $buttons];
}

function getServices() {
    $text = '<b>SERVICES:</b>

    <tg-emoji emoji-id="5368324170671202286">➖</tg-emoji> <i>Professional FullStack Web Development</i>
    <tg-emoji emoji-id="5368324170671202286">➖</tg-emoji> <i>Ruby on Rails (RoR) Web Applications</i>
    <tg-emoji emoji-id="5368324170671202286">➖</tg-emoji> <i>Desktop Ruby Applications (GTK)</i>
    <tg-emoji emoji-id="5368324170671202286">➖</tg-emoji> <i>PHP & Frameworks (Yii2, Slim, LAMP\LEMP)</i>
    <tg-emoji emoji-id="5368324170671202286">➖</tg-emoji> <i>JavaScript & Frameworks (React, Vue, jQuery)</i>
    <tg-emoji emoji-id="5368324170671202286">➖</tg-emoji> <i>DataBases</i>
    <tg-emoji emoji-id="5368324170671202286">➖</tg-emoji> <i>API Development</i>
    <tg-emoji emoji-id="5368324170671202286">➖</tg-emoji> <i>Hybrid Mobile Applications (Cordova + JS)</i>
    <tg-emoji emoji-id="5368324170671202286">➖</tg-emoji> <i>Slack Applications & Chat Bots</i>
    <tg-emoji emoji-id="5368324170671202286">➖</tg-emoji> <i>IT Projects Management</i>
    <tg-emoji emoji-id="5368324170671202286">➖</tg-emoji> <i>Linux Servers Configuration</i>
    <tg-emoji emoji-id="5368324170671202286">➖</tg-emoji> <i>Support and Consulting</i>
    <tg-emoji emoji-id="5368324170671202286">➖</tg-emoji> <i>Internet of Things (IoT, gadget\'s web interface & apps)</i>
    ';
    return $text;
}

function getLibs() {
        $text = '<b>EXTENSIONS:</b>

<tg-emoji emoji-id="5368324170671202287">✔️</tg-emoji> <b><i>Is Dark:</i></b> <i>Gem to detect a dark background over an area by coordinates or a color code based on W3 Luminance standarts.</i>
<a href="https://github.com/butteff/is_dark_ruby_gem">GitHub</a> | <a href="https://rubygems.org/gems/is_dark">RubyGems</a> 

<tg-emoji emoji-id="5368324170671202287">✔️</tg-emoji> <b><i>Is Valid:</i></b> <i>Gem to validate hashes or variables based on regular expressions with own templates or based on existed rules.</i>
<a href="https://github.com/butteff/is_valid_ruby_gem">GitHub</a> | <a href="https://rubygems.org/gems/is_valid">RubyGems</a> 

<tg-emoji emoji-id="5368324170671202287">✔️</tg-emoji> <b><i>Yii2 Passwords:</i></b> <i>Using of wordpress password hashes for Yii2 authorization, which helps to move users database without password changes.</i>
<a href="https://github.com/butteff/Yii2-login-with-a-wordpress-password-hashes">GitHub</a>
    ';
    return $text;
}

function getContacts() {
    $text = '<b>CONTACTS:</b>

    <b>WWW:</b> <a href="https://butteff.ru/en/">https://butteff.ru</a>
    <b>CV (english version):</b> <a href="https://butteff.ru/cv.pdf">https://butteff.ru/cv.pdf</a>
    <b>CV (russian version):</b> <a href="https://butteff.ru/cv_rus.pdf">https://butteff.ru/cv_rus.pdf</a>
    <b>LinkedIn:</b> <a href="https://linkedin.com/in/butteff">https://linkedin.com/in/butteff</a>
    <b>GitHub:</b> <a href="https://github.com/butteff">https://github.com/butteff</a>
    <b>Telegram:</b> <a href="https://t.me/butteff">https://t.me/butteff</a>
    ';
    return $text;
}


// =========

/*

$text = 'Markup Sample:
<b>bold</b>, <strong>bold</strong>
<i>italic</i>, <em>italic</em>
<u>underline</u>, <ins>underline</ins>
<s>strikethrough</s>, <strike>strikethrough</strike>, <del>strikethrough</del>
<span class="tg-spoiler">spoiler</span>, <tg-spoiler>spoiler</tg-spoiler>
<b>bold <i>italic bold <s>italic bold strikethrough <span class="tg-spoiler">italic bold strikethrough spoiler</span></s> <u>underline italic bold</u></i> bold</b>
<a href="http://www.example.com/">inline URL</a>
<a href="tg://user?id=123456789">inline mention of a user</a>
<tg-emoji emoji-id="5368324170671202286">👍</tg-emoji>
<code>inline fixed-width code</code>
<pre>pre-formatted fixed-width code block</pre>
<pre><code class="language-python">pre-formatted fixed-width code block written in the Python programming language</code></pre>
<blockquote>Block quotation started\nBlock quotation continued\nThe last line of the block quotation</blockquote>';

*/

?>