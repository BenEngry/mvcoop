<?php

$auth->destroySession();

header('Location: ' . HOST . BASE_URL);
