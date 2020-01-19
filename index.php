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
    $input_text_modified = preg_replace('~[\\n\\r]+?~','|',$input_text);
    $input_array = explode('|||',$input_text_modified);

    /**
     * bug:
     * если идёт список -> строка более 200 символов -> список, то:
     * <ul>
     *  <li>blabla</li>
     *  <li>blabla</li>
     * </ul>
     * <ul>
     *  tself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example,
     *  <li> which of us ever undertakes laborious </li>
     * </ul>
     */
    foreach($input_array as $paragraphNumber => $paragraph)
    {
      $paragraph_array = explode('||', $paragraph);
      $paragraph = ltrim($paragraph, '|');
      
      if(count($paragraph_array) > 1)
      {
        foreach($paragraph_array as $lineNumber => $line)
        {
          $line = ltrim($line, '|');
          // if(strlen($line) <= 200)
          // {
            if(strlen($line) <= 130)
            {
              $line = '<li>'.$line.'</li>';
            }
            // else
            // {
            //   if(($lineNumber >= 1) && ($lineNumber < count($paragraph_array)-1))
            //   {
            //     if((strlen($line) + 30 <= strlen($paragraph_array[$lineNumber+1])) && (strlen($line)-30 >= strlen($paragraph_array[$lineNumber-1])))
            //     {
            //       $line = '<li>'.$line.'</li>';
            //     }
            //   }
            // }
            if($lineNumber === 0)
            {
              $line = '<ul>'.$line;
            }
            elseif($lineNumber === count($paragraph_array)-1)
            {
              $line = $line.'</ul>';
            }
          // }
          // else
          // {
          //   $line = '<p>'.$line.'</p>';
          // }
          $strResult.= $line;
        }
      }
      else
      {
        if(strlen($paragraph) <= 90 || (($paragraphNumber === 0) && (strlen($paragraph) <= 90)))
        {
          $paragraph = '<h2>'.$paragraph.'</h2>';
        }
        else
        {
          $paragraph = '<p>'.$paragraph.'</p>';
        }
        $strResult.= $paragraph;
      }
    }
  }
  ?>
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