<div class="main_block">
    <div class="main">
        <div class="form">
            <h1>Create account</h1>
            <h4 style="color: red";><?php if(isset($data)){
                    echo $data;
                } ?></h4>
            <form action="/sign_up/registr" method="POST" name="create">
                <table>
                    <tr>
                        <th><input type="text" class="form-control" name="login" id="login"
                                   placeholder="Input login"></th>
                    </tr>
                    <tr>
                        <th><input type="text" class="form-control" name="email" id="email"
                                   placeholder="Input E-Mail Address"></th>
                    </tr>
                    <tr>
                        <th> <input type="text" class="form-control" name="pass" id="pass"
                                    placeholder="Input password"></th>
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
