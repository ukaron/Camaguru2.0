<div class="main_block">
        <div class="main">
            <h2 style="color: red";><?php if(isset($data)){
                    echo $data;} ?></h2>
            <div class="form">
                <h1>New tag</h1>
                <form action="/moder/new_tag" method="POST" name="sign_in">
                    <table>
                        <tr>
                            <th> <input type="text" class="form-control" name="tag" id="tag"
                                        placeholder="Input new tag"></th>
                        </tr>
                        <th>  <input id="bottom" type="submit" name="submit" value="OK"></th>

                        </tr>
                    </table>
                </form>
                <form action="/moder/show_tags" target="_blank">
                    <button id="bottom">Show all tags</button>
                </form>
                <h1>New post</h1>
                <form action="/moder/new_news" method="POST" name="sign_in">
                    <table>
                        <tr>
                            <th> <input type="text" class="form-control" name="news_name" id="news_name"
                                        placeholder="Input subject a new post"></th>
                        </tr>
                        <tr>
                            <th><input type="text" class="form-control" name="info" id="info"
                                       placeholder="Input text a new post"></th>
                        </tr>
                        <tr>
                            <th>  <input id="bottom" type="submit" name="submit" value="OK"></th>
                        </tr>
                    </table>
                </form>

            </div>
            <div class="form">
            <h1>My post</h1>
                <div class="main_block">
                    <div id="post" >
                        <?php foreach ($data as $news) : ?>
                            <?php foreach ($news as $post) : ?>
                                <h1><?php echo $post['subj']; ?></h1><br>
                                <h2><?php echo "<a href='/moder/edit_news/?id=". $post['news_id']."'>Edit</a>";?>
                                    <?php echo "<a href='/moder/delete_news/?id=". $post['news_id']."'>Delete</a>";?><br>
                                    <?php echo $post['public_date']; ?></h2>
                            <?php endforeach;
                        endforeach;?>
                    </div>
                    <div id="tag_block">

                    </div>
                </div>
            </div>
        </div>
</div>