<?php
error_reporting(E_ERROR | E_PARSE);

include 'auth.php';

const MONTH_JAN = 1;
const MONTH_FEB = 2;
const MONTH_MAR = 3;

$requestData = $_POST;

$action = $_GET['action'];
$errors = [];
$mysqli = getMysqli($errors);

function render($templatePath, $arguments) {
    echo vsprintf(file_get_contents($templatePath), $arguments);
}

switch ($action) {
    case 'advanced':
        advancedForm($requestData);
        break;
    case 'register':
        $registerData = [];
        $registerData['login'] = $requestData['login'];
        $registerData['password'] = md5($requestData['password']);
        $registerData['firstname'] = $requestData['firstname'];
        $registerData['lastname'] = $requestData['lastname'];
        $registerData['email'] = $requestData['email'];

        if (empty($registerData['login']) || empty($registerData['password'])) {
            render('../registration.html', ['<h4>Sprawdz poprawność danych</h4><span></span>']);
            die;
        }

        if ($mysqli) {
            $query = getInsertQuery($mysqli);
            $query( 'users', $registerData);

            render('../success.html', ['Witamy w Comfy! Rejestracja zakończona']);
            die;
        }

        break;
    case 'login':
        $login = $requestData['login'];
        $password = $requestData['password'];
        $authErrors = [];
        $user = authorize($login, $password, $authErrors);

        if (count($authErrors) > 0) {
            render('../login.html', [
                sprintf('<h4>%s</h4><span></span>', implode(',', $authErrors))
            ]);
            die;
        } else {
            render('../success.html', ['Witamy w Comfy! Jestesz już zalogowany!']);
            die;
        }

        break;
    case 'save':
        $updateData = [];
        $user = getCurrentUser();
        $updateData['login'] = sprintf('login="%s"', $requestData['login']);
        $updateData['password'] = sprintf('password="%s"', md5($requestData['password']));
        $updateData['firstname'] = sprintf('firstname="%s"', $requestData['firstname']);
        $updateData['lastname'] = sprintf('lastname="%s"', $requestData['lastname']);
        $updateData['email'] = sprintf('email="%s"', $requestData['email']);

        if ($mysqli) {
            $query = getUpdateQuery($mysqli);
            $query( 'users', $updateData, ['id=' . $user['id']]);

            render('../home.html', [
                '<h4>Dane zapisane!</h4><span></span>',
                $user['firstname'],
                $user['lastname'],
                $user['login'],
                $user['email']
            ]);
        } else {
            render('../home.html', [
                sprintf('<h4>%s</h4><span></span>', implode(',', $errors)),
                $user['firstname'],
                $user['lastname'],
                $user['login'],
                $user['email']
            ]);
        }

        break;
    case 'styles':
        if ($_GET['dark']) {
            setCooks('background','#f1f1f1');

        } elseif ($_GET['red']) {
            setCooks('background','red');

        } elseif ($_GET['off']) {
            deleteCooks('background');
        }

        header('Location: /home.php');

        break;
    default:
        echo '<h3>Action not found</h3>';
        break;
}

if ($errors) {
    echo print_r($errors, true);
}




function advancedForm($requestData)
{

    $hobbies = ['narty', 'bieg', 'pc'];
    $hobbiesAdd = ['jazda autem' => 'norm', 'jazda konna' => 'gorzej'];

    $birthMonth = (int)$requestData['birthMonth'];
    $birthYear = (int)$requestData['birthYear'];
    $hobby = $requestData['hobby'];

    $birthMonthString = '';

    $age = (int)date('Y') - $birthYear;
    if ($age < 18) {
        render('../registration-advanced-error.html', ['Masz mniej niż 18 lat!']);
        die;
    }

    switch ($birthMonth) {
        case MONTH_JAN:
            $birthMonthString = 'Styczen';
            break;
        case MONTH_FEB:
            $birthMonthString = 'Luty';
            break;
        case MONTH_MAR:
            $birthMonthString = 'Marzec';
            break;
        default:
            $birthMonthString = (string)$birthMonth;
            break;
    }

    if (!preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $_SERVER['REMOTE_ADDR'])) {
        die;
    }

    $isGoodHobby = false;
    $hobbiesLength = count($hobbies);
    for ($i = 0; $i < $hobbiesLength; $i++) {
        if ($hobby === $hobbies[$i]) {
            $isGoodHobby = true;
            break;
        }
    }

    $isHobby = false;
    reset($hobbiesAdd);
    while (next($hobbiesAdd)) {
        if (key($hobbiesAdd) === $hobby) {
            $isHobby = true;
            break;
        }
    }

    $firstName = $requestData['firstName'];
    $lastName = $requestData['lastName'];
    $lastName = preg_replace('/\s\s+/', ' ', $lastName);

    render('../registration-advanced-success.html', [
        $firstName,
        $lastName,
        $isGoodHobby ? 'Masz dobre hobby' : $hobby,
        $birthYear,
        $birthMonthString,
        $requestData['email'],
        $requestData['phone']
    ]);
    die;




}