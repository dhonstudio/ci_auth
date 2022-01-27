<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="image/x-icon" href="https://dhonstudio.com/assets/img/icon.ico">
    <title><?= $title ?></title>

    <?= isset($font) ? implode($font) : ''?>
    <?= isset($css) ? implode($css) : ''?>    

</head>

<body class="<?= $body_class ?>">
    