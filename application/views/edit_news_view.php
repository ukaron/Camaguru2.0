<div class="form">
    <h1>My post #<?php echo $data['news_id']; ?></h1>
    <div class="main_block">
        <div id="post" >
            <h1>Subject news</h1>
            <h3><?php echo $data['subj']; ?></h3><br>
            <form action="/moder/edit_subj" method="POST"">
                <input type="hidden" name="news_id" id="news_id" value="<?php echo $data['news_id']; ?>">
                <table>
                    <tr>
                        <th> <input type="text" class="form-control" name="new_subj" id="info"
                                    placeholder="Edit subject"></th>
                    </tr>
                    <tr>
                        <th>  <input id="bottom" type="submit" name="submit" value="OK"></th>
                    </tr>
                </table>
            </form>
            <h1>Information</h1>
            <h3><?php echo $data['info']; ?></h3><br>
                <form action="/moder/edit_info" method="POST" name="sign_in">
                    <input type="hidden" name="news_id" value="<?php echo $data['news_id'] ?>">
                    <table>
                        <tr>
                            <th> <input type="text" class="form-control" name="new_info" id="new_info"
                                        placeholder="Edit info"></th>
                        </tr>
                        <tr>
                            <th>  <input id="bottom" type="submit" name="submit" value="OK"></th>
                        </tr>
                    </table>
                </form>
            <h1>Tags</h1>
                <h3 style="color: blue;"><?php if (isset($data['tags'])){
                    for ($i = 0; $i < count($data['tags'][0]); $i++){
                        echo "#".$data['tags'][0][$i]['tag_name']." ";
                    }}?></h3><br>
                <h3>Add tags</h3>
                <form action="/moder/add_tag_for_news" method="POST" name="sign_in">
                    <input type="hidden" name="news_id" value="<?php echo $data['news_id']; ?>">
                    <table>
                        <tr>
                            <th> <input type="text" class="form-control" name="tag_name" id="tag_name"
                                        placeholder="Tag name"></th>
                        </tr>
                        <tr>
                            <th>  <input id="bottom" type="submit" name="submit" value="OK"></th>
                        </tr>
                    </table>
                </form>
            <h2>Date created</h2>
                <h3><?php echo $data['public_date']; ?></h3>
        </div>
    </div>
</div>