<div class="main_block">
    <div class="main">
        <div class="form">
            <h1>Change password</h1>
            <h3 style="color: red"><?php if(isset($data))
            {
                    echo $data;?></h3>
                    <h6 style="color: red">Your password must be between eight and sixteen alphanumeric characters.</h6>
                <?php } ?>
            <form action="<?php echo $_SESSION['status'];?>/change_pass" method="POST" name="sign_in">
                <table>

                    <tr>
                        <th> <input type="text" class="form-control" name="pass" id="pass"
                                    placeholder="Input password"></th>
                    </tr>
                    <tr>
                        <th> <input type="text" class="form-control" name="pass_1" id="pass"
                                    placeholder="Input password"></th>
                    </tr>
                    <tr>
                        <th>  <input id="bottom" type="submit" name="submit" value="OK"></th>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

