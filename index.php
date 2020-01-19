<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>html_tags</title>
</head>
<body>
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

    foreach($input_array as $paragraphNumber => $paragraph)
    {
      $paragraph_array = explode('||', $paragraph);
      $paragraph = ltrim($paragraph, '|');
      
      if(count($paragraph_array) > 1)
      {
          foreach($paragraph_array as $lineNumber => $line)
          {
            $line = ltrim($line, '|');
            $line = '<li>'.$line.'</li>';
            if($lineNumber === 0)
            {
              $line = '<ul>'.$line;
            }
            elseif($lineNumber === count($paragraph_array)-1)
            {
              $line = $line.'</ul>';
            }
            echo $line;
            $strResult.= $line;
          }
      }
      else
      {
        if(strlen($paragraph) <= 90)
        {
          $paragraph = '<h2>'.$paragraph.'</h2>';
          echo $paragraph;
        }
        else
        {
          $paragraph = '<p>'.$paragraph.'</p>';
          echo $paragraph;
        }
        $strResult.= $paragraph;
      }
    }
  }
  ?>
  <p><textarea name="preview_text" id="preview_text" cols="50" rows="10" disabled><?php
            if(isset($strResult)) {
              echo $strResult;
            } else {
              echo '';
            }
    ?></textarea></p>
</body>
</html>