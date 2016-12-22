<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0">
    <title>Start</title>
    <link rel="stylesheet" href="index-assets/css/icons.css">
    <link rel="stylesheet" href="index-assets/css/index.css">
    <link rel="stylesheet" href="index-assets/css/clock.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.0.0/moment.min.js"></script>
</head>
<body>

    <div id="large-header" class="large-header">
        <canvas id="myriad-canvas"></canvas>
    </div>

    <h1 class="local-text">Localh<span class="spyglass">o</span>st</h1>

    <ul class="admin-links">
        <li>
            <a href="https://github.com/Skullsneeze/Localhost-disco" target="_blank">
                <span class="icon icon-github5"></span>
                Project on GitHub
            </a>
        </li>
        <li>
            <a href="setup.php">
                <span class="icon icon-wrench"></span>
                Adjust configuration
            </a>
        </li>
    </ul>
    <button class="cmn-toggle-switch cmn-toggle-switch__htx">
        <span>toggle menu</span>
    </button>


    <div class="switch-container">
        <div class="label">Disco</div>
        <label class="switch-check">
            <input <?php if (isset($_COOKIE['disco']) && $_COOKIE['disco'] == 'true') { echo 'checked'; } ?> id="switch" type="checkbox" class="ios-switch green" />
            <div><div></div></div>
        </label>
    </div>


    <div id="clock" class="light">
        <div class="display">
            <div class="date">
                <span class="weekday"></span>
                <span class="day"></span>
                <span class="month"></span>
                <span class="year"></span>
            </div>
            <div class="ampm"></div>
            <div class="digits"></div>
        </div>
    </div>

    <input class="search" autocomplete="off" autofocus="autofocus" id="filter" type="text" name="filter" value="" placeholder="Search for projects...">
    <?php

        // Get the config.
        $config_arr = array();
        if (file_exists('index-assets/config.json')) {
            $json_config = file_get_contents('index-assets/config.json');
            $config_arr = json_decode($json_config, TRUE);
        } else {
            header('Location: setup.php');
        }

        // Check for hotlinks.
        $hotlink_html = '';
        if (isset($config_arr['hotlinks'])) {
            foreach ($config_arr['hotlinks'] as $hotlink) {
                $hotlink_html .= '
                    <li>
                        <div class="project-wrapper">
                            <a target="_blank" href="'. $hotlink['href'] .'">
                                <div class="project">'. $hotlink['title'] .'</div>
                            </a>
                        </div>
                    </li>
                ';
            }

            // Render hotlinks.
            echo '
                <div class="list-container hotlinks">
                    <h2 class="hotlinks-text header">Hotlinks</h2>
                    <ul class="list">
                        '. $hotlink_html .'
                    </ul>
                </div>
            ';
        }

        // Check for tools.
        $tools_html = '';
        if (isset($config_arr['tools'])) {
            foreach ($config_arr['tools'] as $tool) {
                $tools_html .= '
                    <li>
                        <div class="project-wrapper">
                            <a target="_blank" href="'. $tool['href'] .'">
                                <div class="project">'. $tool['title'] .'</div>
                            </a>
                        </div>
                    </li>
                ';
            }

            // Render tools.
            echo '
                <div class="list-container tools">
                    <h2 class="test-tools-text header">Testing and tools</h2>
                    <ul class="list">
                        '. $tools_html .'
                    </ul>
                </div>
            ';
        }

    echo '
        <div class="list-container projects">
            <h2 class="projects-text header">Projects</h2>
            <ul class="list">
    ';

        // Get the projects dir.
        if ($config_arr['project_dir']) {
            $project_dir = $config_arr['project_dir'] .'/';
        } else {
            $project_dir = '';
        }

        // Open the dir.
        $dir = opendir(__DIR__ .'/'. trim($project_dir, '/'));

        // Read contents of directory
        while ($read = readdir($dir)) {

            // Hide default folders.
            if ($read!='.' && $read!='..' && $read!='.DS_Store'){

                // Init.
                $name      = ucfirst(str_replace('_', ' ', $read));
                $links_arr = '';
                $links     = '';
                $project   = '<div class="project">'. $name .'</div>';

                // Trunk
                if (is_dir($project_dir . $read.'/trunk')) {
                    $links_arr[] = '<a class="trunk-link" target="_blank" href="'. $project_dir . $read.'/trunk">Trunk</a>';
                }
                // Trunk fallback
                else {
                    $links_arr[] = '<a class="trunk-link" target="_blank" href="'. $project_dir . $read.'">'. $name .'</a>';
                }
                // Branches
                if (is_dir($project_dir . $read.'/branches')) {
                    $links_arr[] = '<a target="_blank" href="'. $project_dir . $read.'/branches">Branches</a>';
                }
                // Tags
                if (is_dir($project_dir . $read.'/tags')) {
                    $links_arr[] = '<a target="_blank" href="'. $project_dir . $read.'/tags">Tags</a>';
                }
                // Meta
                if (is_dir($project_dir . $read.'/meta')) {
                    $links_arr[] = '<a target="_blank" href="'. $project_dir . $read.'/meta">Meta</a>';
                }

                // set links
                if (!empty($links_arr)) {
                    $links = '
                        <div class="project-links">
                            '. implode($links_arr, "\n") .'
                        </div>
                    ';
                }

                // wrap list item
                echo '<li>';
                echo '
                    <div class="project-wrapper">
                        '. $links .'
                        '. $project .'
                    </div>
                ';
                echo '</li>';

            }
        }

        closedir($dir);
        ?>
        </ul>
    </div>
    <script src="index-assets/js/clock.js" type="text/javascript"></script>
    <script src="index-assets/js/bg.js" type="text/javascript"></script>
    <script src="index-assets/js/scripts.js" type="text/javascript"></script>
</body>
</html>
