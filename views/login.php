<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/login.css">
</head>
<body>
<div class="login-container">
      <h1><b>Login</b></h1>
      <form class="form-group" action="index.php?action=login" method="post">
        <div id="user">
            <label>Username</label>
            <input type="text" name="username" id="username"/>
        </div>
        <div id="pass">
            <label>Password</label>
            <input type="password" name="password" id="password"/>
            <div class="hideshow-container" onclick="togglePasswordVisibility()">
                <img id="toggleIcon" src="./public/images/show.png" alt="Toggle Password Visibility" width= "30px" height= "30px"/>
                <p id="toggleText">Hiện Mật Khẩu</p>
            </div>
            <style>
                .hideshow-container {
                    margin-top:10px;
                    display:flex;
                    align-items: center;
                    cursor: pointer;
                }
                #toggleIcon{
                    margin-right: 10px;
                }
            </style>
        </div>
        <button class="login-button">Login</button>
      </form>    
      <?php if (isset($error)): ?>
          <p style="color: red;"><?php echo $error; ?></p>
      <?php endif; ?>  
</div>
<script>
        function togglePasswordVisibility() {
            var imgElement = document.getElementById("toggleIcon");
            var passwordInput = document.getElementById("password");
            var txtElement = document.getElementById("toggleText");
            
            // Đổi hình ảnh giữa hide.png và show.png
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                imgElement.src = "./public/images/hide.png";
                txtElement.textContent = "Ẩn Mật Khẩu";
            } else {
                passwordInput.type = "password";
                imgElement.src = "./public/images/show.png";
                txtElement.textContent = "Hiện Mật Khẩu";
            }
        }
    </script>
</body>
</html>