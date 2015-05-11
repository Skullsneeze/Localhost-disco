<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0">
    <title>Localhost setup</title>
    <link rel="stylesheet" href="index-assets/setup.css">
</head>
<body>
    <?php
        // Submit handle.
        if (isset($_POST['submit']) && isset($_POST['hotlinks']) && isset($_POST['tools']) && isset($_POST['project_dir'])) {
            $hotlinks = $_POST['hotlinks'];
            $tools = $_POST['tools'];
            $project_dir = $_POST['project_dir'];

            // Store hotlinks in array.
            $hotlink_arr = array();
            if ($hotlinks) {
                foreach(explode("\n", $hotlinks) as $hotlink) {
                    if (preg_match('~^(.*?) % (.*)$~', $hotlink, $matches)) {
                        $hotlink_arr[] = array(
                            'title' => $matches[1],
                            'href' => $matches[2],
                        );
                    }
                }
            }
            // Store tools in array.
            $tools_arr = array();
            if ($tools) {
                foreach(explode("\n", $tools) as $tool) {
                    if (preg_match('~^(.*?) % (.*)$~', $tool, $matches)) {
                        $tools_arr[] = array(
                            'title' => $matches[1],
                            'href' => $matches[2],
                        );
                    }
                }
            }

            // Combine arrays.
            $config_arr = array(
                'hotlinks' => $hotlink_arr,
                'tools' => $tools_arr,
                'project_dir' => $project_dir,
            );

            // Convert to JSON
            $config_json = json_encode($config_arr);

            file_put_contents('index-assets/config.json', $config_json);
            header('Location: index.php'); exit;
        }

        // Check for exsisting config.
        if (file_exists('index-assets/config.json')) {
            $config_arr = json_decode(file_get_contents('index-assets/config.json'), TRUE);
        }

        // Check if we need to prefill any existing settings.
        $hotlinks = "";
        if (isset($config_arr['hotlinks'])) {
            foreach ($config_arr['hotlinks'] as $hotlink) {
                $hotlinks .= $hotlink['title'] ." % ". $hotlink['href'] ."\n";
            }
        }
        $tools = "";
        if (isset($config_arr['tools'])) {
            foreach ($config_arr['tools'] as $tool) {
                $tools .= $tool['title'] ." % ". $tool['href'] ."\n";
            }
        }
        $project_dir = "";
        if (isset($config_arr['project_dir'])) {
            $project_dir .= $config_arr['project_dir'];
        }

        echo '
            <form action="" method="post" accept-charset="utf-8">

                <label for="hotlinks">Hotlinks</label>
                <p class="note">Enter each value on a new line as follows:</p>
                <p class="note">Link title % http://www.link-to-site.com</p>
                <textarea id="hotlinks" name="hotlinks" rows="10">'. $hotlinks .'</textarea>

                <label for="tools">Tools</label>
                <p class="note">Enter each value on a new line as follows:</p>
                <p class="note">Link title % http://www.link-to-site.com</p>
                <textarea id="tools" name="tools" rows="10">'. $tools .'</textarea>

                <label for="tools">Project directory</label>
                <p class="note">Leave empty for root folder.</p>
                <p class="note">No leading or trailing slashes.</p>
                <input type="text" name="project_dir" value="'. $project_dir .'" placeholder="Project directory">

                <input type="submit" name="submit" value="Save setup">
            </form>';
    ?>
</body>
</html>
