<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>html_tags</title>
</head>
<body>
  <h1>Введите текст:</h1>
  <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
    <p><textarea name="input_text" id="input_text" cols="50" rows="10"><?php
            if(isset($_POST['input_text'])) {
              echo $_POST['input_text'];
            } else {
              echo '';
            }
    ?></textarea></p>
    <p><input type="submit" name="submit" value="Показать результат" /></p>
  </form>
  <?php
  $strResult = '';
  if(isset($_POST['submit']))
  {
    $input_text = $_POST['input_text'];

    //считаем символы
    $input_text_withSpaces__length = strlen($input_text);
    $input_text_withoutSpaces__length = strlen(str_replace(' ','', $input_text));

    $input_text_modified = preg_replace('~[\\n\\r]+?~','|',$input_text);
    $input_array = explode('|||',$input_text_modified);

    foreach($input_array as $paragraphNumber => $paragraph)
    {
      $paragraph_array = explode('||', $paragraph);
      $paragraph = ltrim($paragraph, '|');

    /** размечаем список из подряд идущих абзацев */
      if(count($paragraph_array) > 1)
      {
        foreach($paragraph_array as $lineNumber => $line)
        {
          //отсекаем прямые слэши в начале строк
          $line = ltrim($line, '|');

          //удаляем лишние пробелы
          $line = trim(preg_replace('/\s+/', ' ', $line));

          if(strlen($line) <= 130)
          {
            $line = '<li>'.$line.'</li>'."\n";
            if($lineNumber === 0)
            {
              $line = '<ul>'."\n".$line;
            }
            if($lineNumber === count($paragraph_array)-1)
            {
              $line = $line.'</ul>'."\n";
            }
          }
          else
          {
            $line = '<p>'.$line.'</p>'."\n";
          }
          $strResult.= $line;
        }
      }

      /** находим заголовки и параграфы */
      else
      //удаляем лишние пробелы
      $paragraph = trim(preg_replace('/\s+/', ' ', $paragraph));
      {
        if(strlen($paragraph) <= 90 || (($paragraphNumber === 0) && (strlen($paragraph) <= 90)))
        {
          $paragraph = '<h2>'.$paragraph.'</h2>'."\n";
        }
        else
        {
          $paragraph = '<p>'.$paragraph.'</p>'."\n";
        }
        $strResult.= $paragraph;
      }
    }
  }
  ?>
  <h1>Количество символов</h1>
  <h4>без учёта тегов html:</h4>
  <ul>
    <li>С пробелами: <?= isset($input_text_withSpaces__length) ? $input_text_withSpaces__length : '<i>нет данных</i>' ?></li>
    <li>Без пробелов: <?= isset($input_text_withoutSpaces__length) ? $input_text_withoutSpaces__length : '<i>нет данных</i>' ?></li>
  </ul>
  <h1>Разметка:</h1>
  <p><textarea name="preview_text" id="preview_text" cols="50" rows="10" disabled><?php
            if(isset($strResult)) {
              echo $strResult;
            } else {
              echo '';
            }
    ?></textarea></p>
  <h1 style="text-align:center">Результат:</h1>
  <div style="border:1px solid gray; min-height: 200px; width: 90%; margin: 0 auto;padding: 10px;"><?= $strResult ?></div>
</body>
</html>