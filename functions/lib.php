<?php

function startup()
{
    // создание линка подключение к БД
    sql_connect();

    // Языковая настройка.
    setlocale(LC_ALL, 'ru_RU.UTF-8');
    mb_internal_encoding('UTF-8');

    // запуск сесси
    session_start();
}

// Функция подключения к БД
function sql_connect()
{
    static $link;

    // Настройки подключения к БД.
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbName   = 'akulov_db';

    // только одно соединение с БД
    if($link === null) {
        // Подключение к БД
        $link = mysqli_connect($hostname, $username, $password);
        $db = mysqli_select_db($link, $dbName);
        // Создание БД, таблицы и заполнение таблицы
        if(!$db) {
            create_db();
            mysqli_select_db($link, $dbName);
            create_tb();
            create_data();
        }
        mysqli_query($link, 'SET NAMES utf8');
        mysqli_set_charset($link, 'utf8');
    }
    return $link;
}

function sql_select($sql)
{
    // Выполнение запроса
    $result = mysqli_query(sql_connect(), $sql);

    if (!$result) {
        die(mysqli_error(sql_connect()));
    }

    // извлекаем из БД данные
    $array = array();
    while($row = mysqli_fetch_assoc($result))
        $array[] = $row;
    return $array;
}

// Функция выполнения запроса к БД.
function sql_query($sql)
{
    // Выполнение запроса
    $result = mysqli_query(sql_connect(), $sql);

    if (!$result) {
        die(mysqli_error(sql_connect()));
    }
    return true;
}

// Функция экранирования спец. символов в sql запросе и удаление пробевол из начала и конца строки
function sql_escape($string)
{
    $result = mysqli_real_escape_string(sql_connect(), $string);
    return $result;
}

// Функция редиректа
function redirect($url)
{
    header("Location: $url");
    exit;
}

// В качестве аргумента используется ключ массива в сессии, в котором хранится сообщение об ошибке
function flashMessage($name)
{
    $storage = $_SESSION["$name"];  // сохранение в переменную
    unset($_SESSION["$name"]);      // удаление записи в массиве
    return $storage;
}

// Подключение шаблона.
function view_include($fileName, $vars = [])
{
    // Устанавливаем переменные
    foreach($vars as $key => $value)
        $$key = $value;

    // Генерация HTML в строку.
    ob_start();
    include $fileName;
    return ob_get_clean();
}

// создание БД
function create_db()
{
    $sql = "CREATE DATABASE akulov_db";
    return sql_query($sql);
}

// создание таблицы
function create_tb()
{
    $sql = "CREATE TABLE IF NOT EXISTS `articles` (
  `id_article` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_article`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4";
    return sql_query($sql);
}

// заполнение таблицы
function create_data()
{
    $sql = "INSERT INTO `articles` (`id_article`, `title`, `content`, `date_time`) VALUES
(1, 'Как защитить свой смартфон от взлома?', 'По производительности смартфоны уже давно догнали ПК, но количество угроз для мобильных устройств пока несоизмеримо выше. Большинство пользователей смартфонов не используют антивирус и межсетевой экран на своих устройствах - это пока еще из разряда экзотики. Однако, проблема не в отсутствии какого-то специализированного софта на смартфоне, а в незнании элементарных правил безопасности. Если вы все еще оставляете включенными неиспользуемые сервисы (например, Wi-Fi и Bluetooth), переходите по ссылкам в письмах от непроверенных источников, да и просто никогда не слышали про фишинг, то внимательно прочитайте эту статью.\r\n\r\nМетоды взлома\r\nПрежде всего, как можно снять деньги со счета смартфона? Правильно, через отправку СМС на короткий номер, это можно легко сделать в фоновом режиме, специальным приложением, пользователь вообще ничего не заметит. Наиболее радикальный способ борьбы с этим заключается в подключении услуги запрет контента, например, так это выглядит у мтс.\r\n\r\nОднако, данный способ подходит не всем, многим нужна опция отправки сообщений на короткие номера. Кроме того, помимо баланса счета в телефоне может быть много чего интересного, например, привязанный номер кредитной карты в магазине приложений или какие-то сохраненные пароли для доступа к личной почте или онлайн кабинету самообслуживания банка. И это только с точки зрения обычного пользователя, если вы не работаете с конфиденциальной информацией. В противном случае все осложняется.\r\n\r\nОсторожно, мошенники!\r\nНапример, недавно была раскрыта следующая интересная схема: по Москве ездил микроавтобус, в котором сидел человек со сканирующей аппаратурой, делая остановки в людных местах. Во время остановок злоумышленники сканировали эфир на предмет открытого беспроводного соединения на мобильных телефонах. При обнаружении активного соединения предпринималась попытка подобрать пароль, как правило это удавалось, потому что использовались простые комбинации: простые слова или вообще нули. Если пароль не удавалось подобрать в течение, максимум, десяти минут, то злоумышленники переходили к следующему аппарату из списка. После удачной попытки взлома с телефона отправляли смс на платный номер, причем счет клиента не опустошался полностью, из-за чего многие клиенты так и не заметили пропажи. Мошенничество было обнаружено благодаря службе безопасности одного из сотовых операторов.   \r\n\r\nТеория заговора\r\nЕсли же вы работаете с действительно ценной информацией, то забудьте все, что было сказано ранее, какие-либо меры предосторожности не помогут. Согласно недавним разоблачениям Эдварда Сноудена, АНБ может взламывать телефоны пользователей посредством отправки зашифрованного текстового сообщения на атакуемый смартфон, после чего спецслужбы могут следить за всем происходящим вокруг, делать фото, просматривать смс и списки посещаемых сайтов, источник тут. Необходимо учесть, что штаб-квартиры таких компаний, как Apple (iPhone) и Microsoft (Windows Phone) находятся в США, следовательно, у АНБ есть масса возможностей неофициально договориться с разработчиками о внедрении шпионских закладок в телефоны, которые активируются при получении соответствующего шифрованного пакета и это не просто домыслы, об этом также говорил Сноуден. Тоже самое касается и операционных систем: даже не надо ничего взламывать, подбирать ключи, искать уязвимости, можно ведь просто договориться с разработчиками. В меньшей степени это касается Google (Android), потому что у этой ОС открытый исходный код и при желании наличие закладок можно обнаружить.\r\n\r\nВспомните Дмитрия Анатольевича и его неподдельную радость, когда он получил новый iPhone из рук самого Стива Джобса. Я искренне надеюсь, что он не ведет по этому телефону каких-либо важных переговоров, содержащих гостайну, а использует для этого спецсредства, предоставленные ФСО.  ', '2015-11-21 19:09:52'),
(2, 'Google пошел войной на web', 'Корпорация Google сделала значительный рывок в повышении доступности содержания мобильных приложений через свой сервис поиска. Теперь нет надобности в том, чтобы существовала web-страница с их копией. Индекс Google научился извлекать информацию прямо из приложений, а у пользователя смартфона при этом отпала необходимость в установке  ПО к себе на устройство.\r\n\r\nВместо этого поисковик предлагает опцию «поток» для просмотра текста, видео и т.д. Приложение будет запущено на виртуальных машинах в «облаке» Google. При этом можно будет имитировать нажатия и прикосновения подобно тому, как пользователь в реальности управляет своим мобильным девайсом.\r\n\r\nКак всегда, поисковый гигант дает своим пользователям привыкнуть к  новой фиче перед массовым выводом на рынок. В пилотном проекте участвуют такие сервисы, как Hotel Tonight, Weather, Chimani, Gormey, My Horoscope, Visual Anatomy Free, Useful Knots, Daily Horoscope и New York Subway.\r\n\r\nИстория вопроса\r\n\r\nФактически, Google запустил индексацию мобильных приложений два года назад, когда ему стало окончательно понятно, что мир Mobile Apps теснит уже «архаичный» web по всем фронтам. Это время было потрачено на оттачивание множества технологий, например, анализа «deep links» (ссылки на страницы внутри приложения). В итоге «app» индекс для iOS и Android ничем не отличается от «web» индекса. В Google утверждают, что уже проиндексированы тысячи приложений и имеется около 100 млрд ссылок внутри них.\r\n\r\nПо словам Раджана Пателя (Rajan Patel, the director leading the app indexing team inside Google):\r\n\r\nэволюция мобильного мира уже довольно давно привела к тому, что пусть и не много, но социально важные сервисы (справочные системы Нью-Йоркского метрополитена, национального парка Chimani), уже не имеют веб-аналогов. Задача корпорации в этом контексте заключается в том, чтобы пользователи могли иметь доступ к этому контенту, независимо от того,  доступен он в Интернете или в приложении.\r\n\r\n\r\nНа сегодня, чтобы приложения могли быть проиндексированы, разработчикам необходимо внедрить в свой код алгоритмы поддержки  Google API, далее поисковый робот работает, как обычно. Естественно, немного изменяются алгоритмы ранжирования. Кое-какие меры приняты для поиска скрытого контента внутри приложений. Все эти ухищрения должны оградить рекламный бизнес Google от нападок конкурентов. Ведь показ рекламы в приложениях мало-помалу становится весомым источником доходов корпорации.\r\n\r\n\r\nНегативные последствия\r\nОдной из сложных проблем, решаемых инженерами и программистами Google, является то, как именно искать контент внутри мобильных приложений, ведь оно может и не быть еще установлено и персонализировано на смарфоне. Независимые эксперты видят в этом серьезный удар по бизнесу разработчиков ПО для мобильных гаджетов. Ведь, если в основе добавленной стоимости приложения – продажа (показ) контента или игры, то зачем юзеру платить деньги за покупку ПО, получая его напрямую из поисковика?\r\n\r\n\r\nКак указывает ряд источников, технологию «потока» Google приобрела вместе с ее разработчиком – компанией Agawi. Сделка была проведена в 2014г. без особой огласки. На тот момент наблюдателям казалось, что компания разрабатывает средства потоковой доставки мобильных приложений через Интернет, главным образом, мобильных игр и рекламных блоков в них. А оказалось всё гораздо сложнее…\r\n\r\nВ заключении хотелось бы привести выдержку из Фейсбука Игоря Мацанюка – владельца компании Game Insight, бизнес которой (и его бизнес-инкубатора) эта неожиданная новость из Google должна затронуть самым непосредственным образом.\r\n\r\n\r\n«С топами мобильных игр и приложений произойдет то же самое, что происходило с топами в вебе. Поиск их убил. Я же честно верю, что существует истина, где победит золотая середина. Но мы просто эволюционно в эту точку еще не пришли. Анализ качества приложений и игр и их релевантности - следующий большой шаг вперед, к которому все заинтересованные должны быть готовы. Наши продукты в скором времени станут искать, а не выбирать в «сторах». Это поменяет рынок на столько, на сколько это произошло с приходом поисковиков в web».\r\n\r\n\r\nТак что, делайте выводы, дамы и господа!\r\n\r\nP.S.\r\n\r\n\r\nВ этом вопросе оставалась одна не поставленная точка. А кто будет отвечать за мобильный «облачный» сервис Google? И на чьи технологии виртуализации он будет опираться?', '2015-11-21 19:09:54'),
(3, 'Говорит и показывает заказчик', 'Заказчики и клиенты бывают разные. Но некоторые из них выдают такие фразы, что настроение поднимается на весь день. Правда, после некоторых их перлов мозг вылетает в BSoD.\r\n\r\n«Цвет влюбленного носорога»\r\n\r\nНарисуйте мне, пожалуйста, эту линию жирным цветом. (Классика ... )\r\n\r\nЯ думал, просто открыл интернет и сайт готов. (Эх, хотелось бы...)\r\n\r\nСделайте фон в 2-х разных белых цветах. (Во мне дизайнер умер, не родившись…)\r\n\r\nХочу, чтобы блоки были нарисованы невидимым цветом. (Новое в CMYK…)\r\n\r\nХочу, чтобы сайт бы в цветах лихих 90-х. (Оказалось — малиновый с золотым…)\r\n\r\nВот представьте и вы то, что я увидел в своей голове. (Да упаси Боже…)\r\n\r\nЯ вам сейчас по скайпу нарисую. (Хм, может, и я когда-нибудь так научусь…)\r\n\r\nНеоднозначность:\r\n\r\nХочу получить отчет о сайте в сауне. (Оказалось, речь про сайт сауны… )\r\n\r\nПочему программа посылает меня в разные места? (Какая некультурная программа… )\r\n\r\nВы не могли бы еще раз выслать факс, а то мы на нём селёдку порезали. (Не самое страшное применение бумаги…)\r\n\r\nЯ хочу интернет-магазин для новорожденных. Вы же знаете, какие сайты им нравятся. (Ага! По статистике 80% опрошенных новорождённых заявили, что…)\r\n\r\nПереведу оплату заранее, т.к. уезжаю в отпуск на месяц, когда вернусь – не знаю. (Правы ученые про временные искажения…)\r\n\r\n—Директор спьяну поменял пароль. Теперь не может вспомнить. Что делать?\r\n—Лучше сбросить.\r\n—(шепотом в ужасе) Директора?!\r\n\r\nКлиент всегда прав:\r\n\r\nНу и что, что Яндекс поменял алгоритм, я же когда-то уже деньги за ссылки заплатил! (Да и правда что, подумаешь, Яндекс... )\r\n\r\nКритерий качества:\r\n\r\nЯ думал у них серьёзное качество, у них 5 этажей сотрудников! (Вот главный показатель! А вы: безопасность, надежность, конверсия. А качество — оно в этажах, оно такое… )\r\n\r\nУвидев дизайн — перекрестился, а я – мусульманин. (Убойная сила проекта!...)', '2015-11-21 19:09:56'),
(4, '10 советов, как быстро выучить технический английский', 'На английском говорит более 400 млн. человек по всему миру и еще 1,5 млрд. используют его как второй язык. Вся документация программирования изначально на английском, 5-ти миллионное комьюнити Stack Overflow общается на английском. Интересные и денежные заказы, топовые работодатели, свежие новости из IT сферы и многое другое закрыто для разработчиков, которые не владеют этим языком. Знание английского — обязательное условие для успешного трудоустройства и карьерного роста программиста. Чтобы помочь подписчикам блога GeekBrains в обучении, мы с командой стартапа по изучению английского по Skype EnglishDom подготовили практические советы о том, как обучиться техническому английскому быстро и эффективно.\r\n\r\nЗанимайтесь каждый день\r\nЭто актуально для каждого, кто хочет быстро изучить иностранный язык. Не ищите оправдания в устоявшихся фразах наподобие: “пять минут ничего не решают”. За это время можно прочесть новость на английском, выучить несколько слов или посмотреть тематический ролик. Ищите возможности, а не отговорки. Скачайте аудиокнигу на английском, чтобы слушать, пока едете в метро, или обучающее языку приложение, с помощью которого можно с пользой провести эти пять минут.\r\n\r\nУчите слова по темам\r\nДля лучшего запоминания изучайте слова в контексте употребления. Например, чтобы овладеть английской терминологией по теме “Алгебра множеств” ознакомьтесь с тематическими статьями и выделите неизвестные слова. После этого практикуйте их, изучая материалы по теме, пока не сможете обходиться без словаря. Такой способ изучения позволит понять оттенки значений слов, чего невозможно добиться просто заучивая словарь.\r\n\r\nПравильно ставьте цели\r\n“Выучить технический английский” — слишком абстрактная цель. Новые слова появляются ежедневно и всех тонкостей не знают даже носители. А когда что-то слишком абстрактно, то невозможно понять качество результата, из-за этого нет мотивации. Поэтому ставьте конкретные, измеримые цели, например: “Выполнить небольшой заказ от англоязычного работодателя”, “Прочесть такую-то книгу по Java на английском”, “Знать 100 технических терминов”, “Попросить совета на англоязычном ресурсе.”\r\n\r\nЧитайте англоязычные IT форумы\r\nЗдесь можно набраться актуальных выражений, которые используют программисты по всему миру при неформальном общении. Это не просто веселая прихоть. Знание тонкостей будет важно для последующего общения с зарубежными коллегами и заказчиками.\r\n\r\nПодпишитесь на англоязычных программистов в социальных сетях\r\nВо-первых, это неиссякаемый источник новых слов и выражений. Во-вторых, вы будете “в теме” последних событий и новинок из мира IT.\r\n\r\nСмотрите тематические видео \r\nЗнания лексики без умения воспринимать на слух недостаточно. Для того, чтобы успешно общаться с зарубежными заказчиками и коллегами, нужно уметь воспринимать язык на слух. Для того, чтобы приобрести этот навык, советуем смотреть видео с конференций, хакатонов, презентаций. Главное правило — максимум живого общения. Фильмы, сериалы, программы полезны, но они не дадут такого эффекта, как знакомство с “не фильтрованной” речью. Можно слушать и аудиозаписи, но просмотр видео создает эффект полного погружения в языковую среду, отслеживается все, вплоть до характерных жестов и особенностей мимики говорящего.\r\n\r\nРегулярно повторяйте пройденный материал\r\nЧеловек хорошо помнит только то, что он использует. Данный факт обусловлен тем, что мозг считает не применяемый длительное время навык не релевантным. Поэтому очень важно иногда повторять даже давно изученные и очевидные слова и выражения. Лучше, если это будет на практике.\r\n\r\nНе углубляйтесь в грамматику\r\nУчите грамматику попутно с лексикой, это даст более глубокое понимание языка и его структур. Когда маленькие дети учатся говорить, то им не вдалбливают десятки правил по употреблению артиклей (хотя, к сожалению, зачастую при изучении языков в школе это именно так), они просто смотрят, как это делают другие и повторяют за ними.\r\n\r\nНе учите через силу\r\nСделать приятным можно изучение даже сухого технического языка. Найдите интересную вам специфическую тему или новость на английском и постарайтесь ее перевести. Когда вы понимаете, что это принесет вам результат уже сейчас, например, в виде новых знаний о технологиях, то это очень мотивирует.\r\n\r\nПрактикуйтесь\r\nОб этом говорят все, но не многие пользуются этим обязательным правилом. Отсутствие языкового барьера, умение быстро переключаться на разговорный режим и подбирать нужные слова — одни из самых важных индикаторов владения языком на продвинутом уровне. Ищите любые возможности, чтобы говорить. Например, можно пообщаться с носителями языка в текстовых и видеочатах.', '2015-11-21 19:24:43'),
(5, 'Базы данных. Как я делал проект на C#', 'Предыстория\r\nБуквально пару недель назад мой начальник обратился ко мне с просьбой - создать простое приложение на C# для регистрации задач и проектов сотрудников нашего отдела. Ничего сложного, стандартная форма с текстовыми полями и кнопками, по заполнению которых в некоторый файл на сервере добавляется строка с введёнными данными. Дополнительное приложение позволяет контролирующему органу извлекать из файла эту информацию, фильтровать и использовать в дальнейшем планировании. Казалось бы, что может быть проще. В этой истории лишь одна загвоздка. Я никогда не работал на C#.\r\n\r\n\r\nНет, безусловно, как и у любого «высокообразованного технаря», в университете у меня были курсы по программированию, где обучали в том числе и вышеобозначенному языку. Кстати, данный факт в резюме и привёл моего начальника со своей просьбой. Что ж, делать нечего, отбросив страх и лень, пришлось взяться за дело.\r\n\r\nБерёмся за дело\r\nПрежде всего, необходим бесплатный дистрибутив. Приложение нам необходимо для личного пользования, поэтому можно смело идти на официальный сайт Visual Studio Community и запускать процесс скачивания. Почему именно VS, а не более простое решение? Если вкратце, то это большие возможности по развитию, графическому и программному. Пока идёт долгий процесс скачивания и установки, освежаем знания. Основы C# или VS здесь описываться не будут. Просто допустим, что любой человек хоть немного изучавший программирование, прекрасно знает циклы, функции и операторы. Со структурой среды программирования можно разобраться просто скачав один из примеров на сайте разработчика и внимательно его изучив. \r\n\r\nМой же краткий план таков – на первом этапе пишем приложение, которое создаёт базу данных сотрудников и записывает её в формат XML. На втором этапе позаботимся о начальниках, подумав об извлечении информации с использованием различных фильтров. Чтобы немного усложнить конечную задачу, я решил поэкспериментировать с различными подходами – работа с БД напрямую и через коллекции. \r\n\r\nВ остальном, задача предельно ясна, поэтому можно приступать.', '2015-11-21 19:26:45'),
(6, 'Сколько ты стоишь? Программист C++', 'Начнем с интересных тезисов:\r\n\r\nНаибольшим спросом C++ разработчики пользуются в небольших компаниях,\r\nЗнание Java увеличивает потенциальный доход прогграммиста C++ на 14%, а знание agile-методов на все 20%,\r\n50% открытых вакансий предлагают в дополнение к деньгам ДМС, оплату питания и другие бонусы.\r\nФункционал\r\nТипичные задачи такого специалиста сводятся к на удивление простому минимуму: создание и проддержка программных продуктов и составление технической документации.\r\n\r\nНо все ли так просто? Узнаем, что за этим стоит.\r\n\r\nI. Новички\r\nНеполное высшее образование, навыки ООП, знание теории реляционных БД и полгода программирования на C++, которые вы могли получить на профильных курсах, открывают для вас возможности, исчисляемые в рублях: 30 или 40 тысяч рублей для Санкт-петербурга и Москвы соответственно — тот зарплатный порог, ниже которого предложения можно не рассматривать. Максимум, доступный на этом уровне — 70 тысяч для москвичей и 55 для петербуржцев, претендующих на работу в IT-компаниях.\r\n\r\nII. Опыт работы на C++ от года,\r\nА также очень важное умение разбираться в чужом коде, зачастую опыт разработки Windows-приложений и знание методик организации командной работы открывают куда более интересную перспективу: 55000-83000 рублей в Москве и чуть меньше, 44-65 тысяч в Петербурге.\r\n\r\nIII. Весомый опыт: 2 и более лет\r\nОсновные требования:\r\n\r\nВысшее техническое образование\r\nЗнанние C++, библиотек и шаблонов проектирования,\r\nSQL,\r\nАнглийский язык (технический),\r\nОпыт рефакторинга,\r\nЗнание сетевых технологий.\r\nПри наличии всех вышеперечисленных возможностей можно ориентироваться на доход в 100 тысяч рублей и более.\r\n\r\nIV. От 3 лет продуктивной разработки на C++\r\nВысшая ступень развития разработчика предполагает следующие знания, умения и опыт:\r\n\r\nМетодологий проектирования ПО,\r\nОптимизации C++ кода,\r\nРазработки многопоточных приложений,\r\nа также желательно\r\n\r\nСвободный английский,\r\nОпыт разработки кроссплатформенных и клиент-серверных приложений.\r\nКонкуренты\r\nС кем вы столкнетесь при поиске работы?\r\n\r\n94% соискателей мужчины, средний возраст кандидата 32 года и 88% имеют высшее образование.', '2015-11-21 19:28:02');
";
    return sql_query($sql);
}

