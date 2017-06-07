<?php
$this->pageTitle = 'Ответ на запрос — '.Yii::app()->name;

$this->breadcrumbs = array('Ответ на запрос');

Yii::app()->clientScript->registerMetaTag('', 'description');
?>                 

<h1>Ответ на запрос</h1>

<p>Форма отправки оформленного письма от имени mailbox@vkomlev.ru.</p>

<?php
if (!empty($result))
    if ($result === true) echo '<p class="green bold">Письмо успешно отправлено!</p>';
    else echo '<p class="red bold">Ошибка! '.$result.'</p>';
?>

<form action="" method="POST" enctype="multipart/form-data" class="formatted_form">
    <label for="mail_type">Тип письма</label>
    <select name="mail_type">
        <option value="e-comm-proposition" <?php if (isset($_POST['mail_type']) && ($_POST['mail_type'] == 'e-comm-proposition')) echo 'checked'; ?>>Коммерческое предложение</option>
        <option value="plain_reply" <?php if (isset($_POST['mail_type']) && ($_POST['mail_type'] == 'plain_reply')) echo 'checked'; ?>>Ответ на запрос обратного звонка</option>
    </select>
    <label for="client_name">Имя клиента</label>
    <input type="text" name="client_name" value="<?php if (isset($_POST['client_name'])) echo $_POST['client_name']; ?>">
    <label for="client_email">E-mail клиента</label>
    <input type="text" name="client_email" value="<?php if (isset($_POST['client_email'])) echo $_POST['client_email']; ?>">
    <label for="filename">Коммерческое предложение</label>
    <input type="file" name="filename">
    <div class="row buttons">
        <a href="#" class="button green submit_button">Отправить ответ</a>
    </div>
</form>