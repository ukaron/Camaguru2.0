<div class="main_block">
    <div class="main">
        <h2 style="color: red";><?php if(isset($data)){
                echo $data;
            } ?></h2>
        <div class="form">
                <h1>New admin</h1>
                <form action="/admin/new_admin" method="POST" name="sign_in">
                <table>
                    <tr>
                        <th> <input type="text" class="form-control" name="login" id="login"
                                    placeholder="Input new admin login"></th>
                    </tr>
                    <tr>
                        <th><input type="text" class="form-control" name="email" id="email"
                                   placeholder="Input E-Mail Address"></th>
                    </tr>
                    <tr>
                        <th> <input type="text" class="form-control" name="pass" id="pass"
                                    placeholder="Input password for new admin"></th>
                    </tr>
                    <tr>
                        <th> <input type="text" class="form-control" name="pass_1" id="pass_1"
                                    placeholder="Input password again"></th>
                    </tr>
                    <tr>
                        <th>  <input id="bottom" type="submit" name="submit" value="OK"></th>
                    </tr>
                </table>
                </form>
        </div>
        <div class="form">
            <h1>New moderator</h1>
            <form action="/admin/new_moderator" method="POST" name="sign_in">
                <table>
                    <tr>
                        <th> <input type="text" class="form-control" name="login" id="login"
                                    placeholder="Input new moderator login"></th>
                    </tr>
                    <tr>
                        <th><input type="text" class="form-control" name="email" id="email"
                                   placeholder="Input E-Mail Address"></th>
                    </tr>
                    <tr>
                        <th> <input type="text" class="form-control" name="pass" id="pass"
                                    placeholder="Input password for new moderator"></th>
                    </tr>
                    <tr>
                        <th> <input type="text" class="form-control" name="pass_1" id="pass_1"
                                    placeholder="Input password again"></th>
                    </tr>
                    <tr>
                        <th>  <input id="bottom" type="submit" name="submit" value="OK"></th>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>