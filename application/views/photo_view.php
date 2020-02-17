<div class="photo">
    <?php
        echo "<div class='user_photo'><img src='/".$data['photo']['path']."'></div>".PHP_EOL;
    ?>
</div>
<div class="comments">
    <?php
    echo "<div class='comment'><img src='".$data['comments']['user_pic'][0]."'><br><p>".$data['comments']['comment'][0]."</p></div>"
    ?>
</div>
<div class="add_comment">
    <form name="comment_form" method="POST">
        <input type="hidden" name="login" value="<?php $_GET['login'] ?>">
        <input type="hidden" name="photo_id" value="<?php $_GET['photo_id']; ?>">
        <table>
            <tr>
                <th><input type="text" class="form-control" name="comment"
                           placeholder="Input comment..."></th>
            </tr>
            <tr>
                <th>  <input id="bottom" type="submit" name="submit" value="OK" onclick="addComment()"></th>
            </tr>
        </table>
    </form>
</div>
<script src="/js/addComment.js"></script>