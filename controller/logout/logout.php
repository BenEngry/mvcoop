<?php

unset($_SESSION['is_user_logined']);
unset($_SESSION['user_data']);
unset($_SESSION["log"]);

header('Location: ' . HOST . BASE_URL);
