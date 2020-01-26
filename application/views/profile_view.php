<div class="main_block">
    <div class="main">
        <div class="form">
            <h1>Change information</h1>
            <div>
                <h2><?php echo $data[0]['login'] ?></h2>
                <div>
                    <img alt="Add a profile photo"  src="<?php echo $data[0]['userpic'] ?>" id="userpic_profile">
                </div>
            </div>
            <form action="" method="POST" name="create">
                <table>
                    <tr>
                        <th><input type="text" class="form-control" name="fname" id="fname"
                                   placeholder="<?php echo $data[0]['fname'] ?>"></th>
                    </tr>
                    <tr>
                        <th><input type="text" class="form-control" name="lname" id="lname"
                                   placeholder="<?php echo $data[0]['lname'] ?>"></th>
                    </tr>
                    <tr>
                        <th> <input type="text" class="form" name="bio" id="bio"
                                    placeholder="<?php echo $data[0]['bio'] ?>"></th>
                    </tr>
                    <tr>
                        <th>  <input id="bottom" type="submit" name="submit" value="Save"></th>
                    </tr>
                </table>
            </form>
            <ul id="nav">
                <li><a href="reset_pass.php">Change Password</a></li>
            </ul>
        </div>
    </div>
</div>