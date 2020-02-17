<div class="main_block">
        <div class="main">
            <div class="form">
                <h1>Sign in</h1>
                <h2 style="color: red";><?php if(isset($data)){
                        echo $data;
                    } ?></h2>
                <form action="" method="POST" name="sign_in">
                    <table>
                        <tr>
                            <th><input type="text" class="form-control" name="login" id="login"
                                   placeholder="Input login"></th>
                        </tr>
                        <tr>
                            <th> <input type="text" class="form-control" name="pass" id="pass"
                                   placeholder="Input password"></th>
                        </tr>
                        <tr>
                            <th>  <input id="bottom" type="submit" name="submit" value="OK"></th>
                        </tr>
                    </table>
                </form>
                <ul id="nav">
                    <li><a href="sign_up">Create an account</a></li>
                    <li><a href="reset_pass">Forgotten password?</a></li>
                </ul>
            </div>
        </div>
</div>

