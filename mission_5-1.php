<!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission5-1</title>
    </head>
    <body>
        <?php
        
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $sql = "CREATE TABLE IF NOT EXISTS 簡易掲示板"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "str char(32),"
        . "com TEXT,"
        . "date TEXT,"
        . "pass char(32)"
        .");";
        $stmt = $pdo->query($sql);
             
            if(!empty($_POST["edit"])){
                $edit=$_POST["edit"];
                
                 if(!empty($_POST["edit_pass"])){
                    
                    $sql = 'SELECT * FROM 簡易掲示板';
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                    
                    foreach ($results as $row){
                    if($row['id'] == $edit && $row['pass'] == $_POST["edit_pass"]){
                        $name=$row['str'];
                        $comment=$row['com'];
                    }
                }
            }
        }
        ?>
        <h2>【掲示板】</h2>
        
        <h3>【投稿フォーム】</h3>
        <form action="" method="post">
         
        <input type="text" name="str" placeholder="名前" value=<?php
        if(!empty($name)){
            echo $name;
        }
        ?>>
        
        <br>
        
        <input type="text" name="com" placeholder="コメント" value=<?php
        if(!empty($comment)){
            echo $comment;
        }
        ?>>
        
        <br>
        
        <input type="text" name="pass" placeholder="パスワード">
        
        <input type="hidden" name="hide" value=<?php
        if(!empty($name)){
            echo $edit;
        }
        ?>>
        
        <input type="submit" name="submit" value="投稿">
        
        <br>
        
        <h3>【削除フォーム】</h3>
        <input type="number" name="del" placeholder="削除対象番号">
        
        <br>
        
        <input type="text" name="del_pass" placeholder="パスワード">
        <input type="submit" name="not" value="削除">
        
        <br>
        <h3>【編集フォーム】</h3>
        <input type="number" name="edit" placeholder="編集対象番号">
        
        <br>
        
        <input type="text" name="edit_pass" placeholder="パスワード">
        <input type="submit" name="edi" value="編集">
        
    </form>
    
    <?php
        $str = $_POST["str"];
        $com = $_POST["com"];
        $del = $_POST["del"];
        $hide = $_POST["hide"];
        $pass = $_POST["pass"];
        $del_pass = $_POST["del_pass"];
        
        $date = date("Y/m/d H:i:s");
        
            if(!empty($del_pass && $del)){
                $sql = 'SELECT * FROM 簡易掲示板';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                
                foreach ($results as $row){
                
                if($row['id'] == $del && $row['pass'] == $del_pass){
                $id = $del;
                $sql = 'delete from 簡易掲示板 where id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                }
                
            }

            }elseif(!empty($str && $com) && empty($hide)){
                $sql = $pdo -> prepare("INSERT INTO 簡易掲示板 (str, com, date, pass) VALUES (:name, :comment, :date, :password)");
                $sql -> bindParam(':name', $str, PDO::PARAM_STR);
                $sql -> bindParam(':comment', $com, PDO::PARAM_STR);
                $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                $sql -> bindParam(':password', $pass, PDO::PARAM_STR);
                $sql -> execute();
                
                
            }elseif(!empty($str && $com && $hide)){
                $id = $hide; 
                $sql = 'UPDATE 簡易掲示板 SET str=:name,com=:comment WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $str, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $com, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                            
            }
                    $sql = 'SELECT * FROM 簡易掲示板';
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                        foreach ($results as $row){
                            echo $row['id'].' ';
                            echo $row['str'].' ';
                            echo $row['com'].' ';
                            echo $row['date'].'<br>';
                            echo "<hr>";
    }
        
        ?>
    
</body>
</html>
