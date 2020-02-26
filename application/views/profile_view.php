<div class="profile">
    <div class="user_pic">
        <?php
        echo "<img src='".$data['userpic']."'>";
        ?>
    </div>
    <div class="login">
        <?php
        echo "<h1>".$data['login']."</h1>";
        ?>
        <h3>Change login</h3>
        <?php
        echo "<h4 style='color: red'>".$data['mess_login']."</h4>";
        ?>
        <form method="POST" action="/profile/change_login">
            <input type="text" name="login" placeholder="Input new login">
            <input type="submit" value="Change">
        </form>
    </div>
    <div class="password">
        <h2>Change password</h2>
        <form method="LINK" action="/profile/change_pass/">
            <input type="submit" value="Change password" >
        </form>
    </div>
    <div class="email">
        <h2>Email</h2>
        <?php
        echo "<h2>".$data['email']."</h2>";
        ?>
        <h3>Change email</h3>
        <?php
        echo "<h4 style='color: red'>".$data['mess_email']."</h4>";
        ?>
        <form method="POST" action="/profile/change_email">
            <input type="text" name="email" placeholder="Input new email">
            <input type="submit" value="Change email">
        </form>
    </div>

</div>