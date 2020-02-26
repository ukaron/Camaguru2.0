<div class="photo">
    <?php
    for ($i = 0; $i < count($data); $i++)
    {
        echo "<div class='user_photo'>
        <h1>".$data[$i]["login"]."</h1><br>
        <a href='./photo/show/?login=".$data[$i]["login"]."&id=".$data[$i][0]."'><img src='".$data[$i]['path']."' height='190'></a>
        </div>".PHP_EOL;

    }
    ?>
</div>