<?php
      $selected = 'UserID, Password, Type, Username';
      $from = 'users';
      $primaryKey = 'UserID';
      
      $connection = new PDO($dsn, $dbUsername, $dbPassword, $options);
      $sql = getSelectQueryString($selected, $from);