<head>
  <title>sqStorage</title>
  <link rel="stylesheet" href="./css/bootstrap/bootstrap.css">
  <link rel="stylesheet" href="./css/base.css">

  <link rel="stylesheet" href="./fonts/fontawesome/css/solid.css">
  <link rel="stylesheet" href="./fonts/fontawesome/css/regular.css">
  <link rel="stylesheet" href="./fonts/fontawesome/css/fontawesome.css">
  <meta charset="utf-8">
  <?php
    require_once('./includer.php');

//    require_once('./support/dba.php');
    if ($usePrettyURLs) $smarty->assign('urlPostFix', '');
    else $smarty->assign('urlPostFix', '.php');
  ?>
</head>
