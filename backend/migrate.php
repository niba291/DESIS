<?php
include_once "./src/utils/Databases.php";
include_once "./src/utils/Dotenv.php";

(new Dotenv())->load();
(new Databases())->migrate();
