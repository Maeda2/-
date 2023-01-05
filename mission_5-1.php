<!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission5-1</title>
    </head>
    <body>
        <?php
        
        $dsn = 'mysql:dbname=tb240561db;host=localhost';
        $user = 'tb-240561';
        $password = 'EZbMN4fvyg';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $sql = "CREATE TABLE IF NOT EXISTS tbt"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "str char(32),"
        . "com TEXT,"
        . "date TEXT,"
        . "passwowd TEXT"
        .");";
        $stmt = $pdo->query($sql);
             
            if(!empty($_POST["edit"])){
                $edit=$_POST["edit"];
                
                 if(!empty($_POST["edit_pass"])){
                    
                    $sql = 'SELECT pass FROM tbt';
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                    
                    foreach ($results as $row){
                    if($row['pass'] = $_POST["edit_pass"]){
                        $edit_pass = $_POST["edit_pass"];
                    }
                }
            }
        }
        ?>
        <h2>【掲示板】</h2>
        <form action="" method="post">
         
        <input type="text" name="str" placeholder="名前" value=<?php
        if(!empty($edit_pass)){
            $num = $edit;
            $sql = 'SELECT str FROM tbt where num=:number';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo $row['str'];
            }
        }
        ?>>
        
        <br>
        
        <input type="text" name="com" placeholder="コメント" value=<?php
        if(!empty($edit_pass)){
            $num = $edit;
            $sql = 'SELECT com FROM tbt where num=:number';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo $row['com'];
            }
        }
        ?>>
        
        <br>
        
        <input type="text" name="pass" placeholder="パスワード">
        
        <input type="hidden" name="hide" value=<?php
        if(!empty($edit_pass)){
            echo $edit;
        }
        ?>>
        
        <input type="submit" name="submit" value="投稿">
        
        <br>
        <br>
        
        <input type="number" name="del" placeholder="削除対象番号">
        
        <br>
        
        <input type="text" name="del_pass" placeholder="パスワード">
        <input type="submit" name="not" value="削除">
        
        <br>
        <br>
        
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
        
            if($del && !empty($del_pass)){
                $sql = 'SELECT pass FROM tbt';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                
                foreach ($results as $row){
                    $num = $del;
                }
                if($row['pass'] = $_POST["del_pass"]){
                
                $sql = 'delete from tbt where num=:number del_pass=:password';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':number', $num, PDO::PARAM_INT);
                $stmt->bindParam(':password', $del_pass, PDO::PARAM_INT);
                $stmt->execute();
                }

            }elseif(!empty($str && $com) && empty($hide)){
                
                $sql = $pdo -> prepare("INSERT INTO tbt (str, com, date, pass) VALUES (:name, :comment, :date, :password)");
                $sql -> bindParam(':name', $str, PDO::PARAM_STR);
                $sql -> bindParam(':comment', $com, PDO::PARAM_STR);
                $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                $sql -> bindParam(':password', $pass, PDO::PARAM_STR);
                
                $sql -> execute();
                
                
            }elseif(!empty($str && $com && $hide)){
                
                $num = $hide; //変更する投稿番号
                $sql = 'UPDATE tbt SET str=:name,com=:comment WHERE num=:number';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $str, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $com, PDO::PARAM_STR);
                $stmt->bindParam(':num', $num, PDO::PARAM_INT);
                $stmt->execute();
                            
            }
                    $sql = 'SELECT * FROM tbt';
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                        foreach ($results as $row){
                            //$rowの中にはテーブルのカラム名が入る
                            echo $row['num'].' ';
                            echo $row['str'].' ';
                            echo $row['com'].' ';
                            echo $row['date'].'<br>';
                            echo "<hr>";
    }
        
        ?>
    
</body>
</html>