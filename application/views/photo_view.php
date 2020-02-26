<div class="photo">
    <?php
    echo "<div class='user_photo'><img src='/".$data['photo']['path']."'></div>".PHP_EOL;
    session_start();
    if ($_SESSION['login'] === $_GET['login'])
        echo "<a href='/gallery/delete_photo/?id=".$_GET['id']."'>Delete</a>";
    ?>
</div>
<div class="likes">
    <?php
    if ($data['like'] !== 0)
        echo  '<a id="like0" href=""><img src="/images/like.png" style="height: 30px;"></a>';
    else
        echo  '<a id="like1" href=""><img src="/images/like1.png" style="height: 40px;"></a>';
    ?>
</div>
</div>
<div class="comments">
    <?php
    for ($i= 0; $i < count($data['comments']); $i++)
        echo "<div class='comment'><h1>".$data['comments'][$i]['user_login']."</h1><br><p>".$data['comments'][$i]['comment']."</p></div>"
    ?>
</div>
<div class="add_comment" id="comments">
        <table>
            <tr>
                <th><input type="text" class="form-control" name="comment"
                           placeholder="Input comment..." id="comment_input"></th>
            </tr>
            <tr>
                <th>  <input id="bottom" type="submit" name="submit" value="OK" onclick="addComment()"></th>
            </tr>
        </table>
</div>
<script src = "/js/addComment.js"></script>