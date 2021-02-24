<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
    <?php
// DB接続設定
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    $sql = "CREATE TABLE IF NOT EXISTS tbtest"//自動ナンバリング(投稿番号)
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "date TEXT,"
	. "pass TEXT"
	.");";
	$stmt = $pdo->query($sql);
    
    if(isset($_POST["submit"]))
        {$text=trim(mb_convert_kana($_POST["str"],"s"));
         $names=trim(mb_convert_kana($_POST["name"],"s"));
         $pass=trim(mb_convert_kana($_POST["pass"],"s"));
         $hidden=$_POST["id"];
         if(empty($text)&&empty($names))
            {$error= "データが入力されていません";
            }
         elseif(empty($text))
            {$error2= "コメントが入力されていません";
            }
         elseif(empty($names))
            {$error3= "名前が入力されていません";
            }
         elseif(empty($pass))
            {$error4= "パスワードが入力されていません";
            }
         elseif(!empty($hidden))
            {$id = $hidden; // idがこの値のデータだけを抽出したい、とする
             $sql = 'SELECT * FROM tbtest WHERE id=:id ';
             $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
             $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
             $stmt->execute();                             // ←SQLを実行する。
             $results = $stmt->fetchAll(); 
	         foreach ($results as $row)//$rowの中にはテーブルのカラム名が入る
	            {if($row["id"]==$hidden)
	                {$name = $names;
	                 $comment = $text; //変更したい名前、変更したいコメントは自分で決めること
	                 $sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
	                 $stmt = $pdo->prepare($sql);
	                 $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	                 $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	                 $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	                 $stmt->execute();
	                }
	            }
            }
         else
            {$sql = $pdo -> prepare("INSERT INTO tbtest(name, comment, date, pass) VALUES(:name, :comment, :date, :pass)");
	         $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	         $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	         $sql -> bindParam(':date', $date, PDO::PARAM_STR);
	         $sql -> bindParam(':pass', $password, PDO::PARAM_STR);
	         $name = $names;
	         $comment = $text; 
	         $date=date("Y/m/d H:i:s");
	         $password=$pass;
	         $sql -> execute();
            }
        }
    
    if(isset($_POST["delete"]))
        {$number=$_POST["number"];
         $pass2=$_POST["pass2"];
         $error8= "投稿が見つかりません。";
         if(empty($number))
            {$error5= "削除番号が入力されていません";
            }
         elseif(empty($pass2))
            {$error4= "パスワードが入力されていません";
            }
         else
            {$id = $number ; // idがこの値のデータだけを抽出したい、とする
             $sql = 'SELECT * FROM tbtest WHERE id=:id ';
             $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
             $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
             $stmt->execute();                             // ←SQLを実行する。
             $results = $stmt->fetchAll();
	         foreach ($results as $row)//$rowの中にはテーブルのカラム名が入る
	                {if($row["pass"]==$pass2)
	                    {$id = $number ; // idがこの値のデータだけを抽出したい、とする
                         $sql = 'SELECT * FROM tbtest WHERE id=:id ';
                         $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
                         $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
                         $stmt->execute();                             // ←SQLを実行する。
                         $results = $stmt->fetchAll(); 
	                     foreach ($results as $row)//$rowの中にはテーブルのカラム名が入る
	                        {if($row['id']==$number)
	                            {$sql = 'delete from tbtest where id=:id';
	                             $stmt = $pdo->prepare($sql);
	                             $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	                             $stmt->execute();
	                             $clear="投稿を削除しました";
	                            }
	                        }
	                    }
	                else
	                    {$error6= "パスワードが間違っています";
	                    }
	                }
            }
        }  
        
    if(isset($_POST["change"]))
        {$num=$_POST["num"];
         $pass3=$_POST["pass3"];
         $error8= "投稿が見つかりません。";
         if(empty($num))
            {$error7= "編集番号が入力されていません";
            }
         elseif(empty($pass3))
            {$error4= "パスワードが入力されていません";
            }
         else
            $id = $num ; // idがこの値のデータだけを抽出したい、とする
            $sql = 'SELECT * FROM tbtest WHERE id=:id ';
            $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
            $stmt->execute();                             // ←SQLを実行する。
            $results = $stmt->fetchAll(); 
	        foreach ($results as $row)//$rowの中にはテーブルのカラム名が入る
	                {if($row["pass"]==$pass3)
	                    {$id = $num ; // idがこの値のデータだけを抽出したい、とする
                        $sql = 'SELECT * FROM tbtest WHERE id=:id ';
                        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
                        $stmt->execute();                             // ←SQLを実行する。
                        $results = $stmt->fetchAll(); 
	                    foreach ($results as $row)//$rowの中にはテーブルのカラム名が入る
	                        {if($row['id']==$num)
	                            {$change_name=$row['name'];
	                            $change_str=$row['comment'];
	                            $change_num=$row['id'];
	                            }
	                        }
	                    }
	                else
	                    {$error6= "パスワードが間違っています";
	                    }
	                }
        }  
        
    ?>
    
     <form action="" method="post">
        <span style="font-size: 20px;">新規投稿</span><br>
        <input type="text" name="name" placeholder="名前を入力してください" value="<?php
                                                                                    if(!empty($change_name))
                                                                                    {echo $change_name;} ?>"><br>
        <input type="text" name="str" placeholder="コメント" value="<?php 
                                                                    if(!empty($change_str))
                                                                    {echo $change_str;} ?>"><br>
        <input type="password" name="pass" placeholder="パスワード" ><br>
        <input type="hidden" name="id" value="<?php 
                                            if(!empty($change_num))
                                            {echo $change_num;} ?>">
        <input type="submit" name="submit"><br>
        
        <?php
        if(isset($_POST["submit"]))
            {if(empty($text)&&empty($names))
                {echo $error;
                }
             elseif(empty($text))
                {echo $error2;
                }
             elseif(empty($names))
                {echo $error3;
                }
             elseif(empty($pass))
                {echo $error4;
                }
            }
        ?>
        
<hr>
        <span style="font-size: 20px;">投稿を削除</span><br>
        <input type="number" name="number" min="1" placeholder="削除したい投稿番号"><br>
        <input type="password" name="pass2" placeholder="パスワード"><br>
        <input type="submit" name="delete" value="削除"><br>
        
        <?php
        if(isset($_POST["delete"]))
            {if(empty($number))
                {echo $error5;
                }
             elseif(empty($pass2))
                {echo $error4;
                }
             elseif(empty($clear))
                {$id = $number ; // idがこの値のデータだけを抽出したい、とする
                 $sql = 'SELECT * FROM tbtest WHERE id=:id ';
                 $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
                 $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
                 $stmt->execute();                             // ←SQLを実行する。
                 $results = $stmt->fetchAll();
	             if(empty($results)&&empty($clear))
	               {echo $error8;
	               }
	             else
	                {foreach ($results as $row)//$rowの中にはテーブルのカラム名が入る
	                    {if($row["pass"]!=$pass2)
	                        {echo $error6;
	                        }
	                    }
	                }         
                }
             else
                {echo $clear;
                }
	        }
        ?>
        
<hr>
        <span style="font-size: 20px;">投稿を編集</span><br>
        <input type="number" name="num" min="1" placeholder="編集したい投稿番号を入力"><br>
        <input type="password" name="pass3" placeholder="パスワード"><br>
        <input type="submit" name="change" value="修正"><br>
        
        <?php
        if(isset($_POST["change"]))
            {if(empty($num))
                {echo $error7;
                }
             elseif(empty($pass3))
                {echo $error4;
                }
             else
                {$id = $num ; // idがこの値のデータだけを抽出したい、とする
                $sql = 'SELECT * FROM tbtest WHERE id=:id ';
                $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
                $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
                $stmt->execute();                             // ←SQLを実行する。
                $results = $stmt->fetchAll(); 
                if(empty($results))
	                {echo $error8;
	                }
	            else
	                {foreach ($results as $row)//$rowの中にはテーブルのカラム名が入る
	                    {if($row["pass"]!=$pass3)
	                        {echo $error6;
	                        }
	                    }
	                }
                }
	        }
        ?>
<hr>
    <span style="font-size: 20px;">投稿一覧</span><br>
    <?php
        $sql = 'SELECT * FROM tbtest';
	    $stmt = $pdo->query($sql);
	    $results = $stmt->fetchAll();
	    foreach ($results as $row){
		    //$rowの中にはテーブルのカラム名が入る
		    echo $row['id'].',';
		    echo $row['name'].',';
		    echo $row['date'].'<br>';
		    echo $row['comment'];
	    echo "<hr>";
	    }
    ?>
</body>
</html>