    <div class="photo">
        <?php
        session_start();
        $login = $_SESSION['login'];
        for ($i = 0; $i < count($data['photo']); $i++)
        {
            echo "<div class='user_photo'><a href='./photo/show/?login=".$login."&id=".$data["link"][$i][0]."'><img src='".$data['photo'][$i]['path']."' height='190'></a></div>".PHP_EOL;

        }
        ?>
    </div>